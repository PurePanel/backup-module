<?php

namespace Visiosoft\BackupModule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpseclib3\Net\SSH2;
use Visiosoft\BackupModule\BackupLog\Contract\BackupLogRepositoryInterface;

class BackupSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ssh_host;
    protected $ssh_root_username;
    protected $ssh_root_password;
    protected $ssh_port;
    protected $location;
    protected $backup_filename;
    protected $compress;
    protected $compressType;

    public $tries = 3;

    public $timeout = 3600;

    public function __construct(
        $ssh_host,
        $ssh_root_username,
        $ssh_root_password,
        $ssh_port,
        $location,
        $backup_filename,
        $compress = true,
        $compressType = 'zip'

    )
    {
        $this->ssh_host = $ssh_host;
        $this->ssh_root_username = $ssh_root_username;
        $this->ssh_root_password = $ssh_root_password;
        $this->ssh_port = $ssh_port;
        $this->location = $location;
        $this->backup_filename = $backup_filename;
        $this->compress = $compress;
        $this->compressType = $compressType;
    }

    public function handle()
    {
        try {
            $status = true;

            $ssh = new SSH2($this->ssh_host, $this->ssh_port);
            $ssh->login($this->ssh_root_username, $this->ssh_root_password);
            $ssh->setTimeout(3600);

            // Set Backup Storage Values
            $backup_host = setting_value('visiosoft.module.backup::remote_host_address');
            $backup_user = setting_value('visiosoft.module.backup::remote_host_user');
            $backup_port = setting_value('visiosoft.module.backup::remote_host_port');

            $backupServerDir = str_replace('.', '_', $this->ssh_host);

            if ($this->compress) {
                // Make directory (Zip & Tar)
                if ($this->compressType == 'zip') {
                    $compressCommand = "zip -r /tmp/" . $this->backup_filename . ".zip " . $this->location;
                    $this->backup_filename = $this->backup_filename . ".zip";
                } else {
                    $compressCommand = "tar -zcvf /tmp/" . $this->backup_filename . ".tar.gz " . $this->location;
                    $this->backup_filename = $this->backup_filename . ".tar.gz";
                }
                // Create Directory for Storage
                $mkdirCommand = "ssh -p$backup_port $backup_user@$backup_host 'mkdir -p /home/$backupServerDir'";
                // Transfer Zip File
                $transferCommand = "scp -P $backup_port /tmp/" . $this->backup_filename . " $backup_user@$backup_host:/home/$backupServerDir/";
                // Remove Temp File
                $removeLocalFileCommand = "rm -rf /tmp/" . $this->backup_filename;

                $combinedCommand = $compressCommand . " && " . $mkdirCommand . " && " . $transferCommand . " && " . $removeLocalFileCommand;
            } else {
                $backupPath = "/home/$backupServerDir/rsyncBackups/" . $this->backup_filename;
                $mkdirCommand = "ssh -p$backup_port $backup_user@$backup_host 'mkdir -p $backupPath'";
                $transferCommand = "rsync -avzu --delete -e 'ssh -p$backup_port' " . $this->location . " $backup_user@$backup_host:$backupPath";

                $combinedCommand = $mkdirCommand . " && " . $transferCommand;
            }

            $ssh->exec($combinedCommand);

        } catch (\Exception $exception) {
            $status = false;
        }

        app(BackupLogRepositoryInterface::class)->create(['ip' => $this->ssh_host, 'path' => $this->location, 'status' => $status, 'type' => 'files']);
    }
}
