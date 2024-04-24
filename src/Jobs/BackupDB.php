<?php

namespace Visiosoft\BackupModule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpseclib3\Net\SSH2;
use Visiosoft\BackupModule\BackupLog\Contract\BackupLogRepositoryInterface;

class BackupDB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ssh_host;
    protected $ssh_root_username;
    protected $ssh_root_password;
    protected $ssh_port;
    protected $db_host;
    protected $db_root_username;
    protected $db_root_password;
    protected $db_port;
    protected $db_driver;
    protected $db_name;
    protected $backup_filename;

    public $tries = 3;

    public function __construct(
        $ssh_host,
        $ssh_root_username,
        $ssh_root_password,
        $ssh_port,
        $db_host,
        $db_root_username,
        $db_root_password,
        $db_port,
        $db_driver,
        $db_name,
        $backup_filename
    )
    {
        $this->ssh_host = $ssh_host;
        $this->ssh_root_username = $ssh_root_username;
        $this->ssh_root_password = $ssh_root_password;
        $this->ssh_port = $ssh_port;
        $this->db_host = $db_host;
        $this->db_root_username = $db_root_username;
        $this->db_root_password = $db_root_password;
        $this->db_port = $db_port;
        $this->db_driver = $db_driver;
        $this->db_name = $db_name;
        $this->backup_filename = $backup_filename;
    }

    public function handle()
    {
        try {
            $status = true;

            // Set Backup Storage Values
            $backup_host = setting_value('visiosoft.module.backup::remote_host_address');
            $backup_user = setting_value('visiosoft.module.backup::remote_host_user');
            $backup_port = setting_value('visiosoft.module.backup::remote_host_port');

            $backupServerDir = str_replace('.', '_', $this->ssh_host);

            $ssh = new SSH2($this->ssh_host, $this->ssh_port);
            $ssh->login($this->ssh_root_username, $this->ssh_root_password);
            $ssh->setTimeout(360);


            $dumpCommand = "";
            if ($this->db_driver == 'postgresql') {
                $dumpCommand = "pg_dump -h " . $this->db_host . " -p " . $this->db_port . " -U " . $this->db_root_username . " -Fc " . $this->db_name . " > /tmp/" . $this->backup_filename . ".sql";
            } else {
                $dumpCommand = "mysqldump --defaults-extra-file=~/." . $this->db_name . ".cnf --single-transaction -h " . $this->db_host . " -u " . $this->db_root_username . " " . $this->db_name . " > " . $this->backup_filename . ".sql";
            }

            // Create Directory for Storage
            $mkdirCommand = "ssh -p$backup_port $backup_user@$backup_host 'mkdir -p /home/$backupServerDir'";
            // Transfer SQL File
            $transferCommand = "scp -P $backup_port /tmp/" . $this->backup_filename . ".sql $backup_user@$backup_host:/home/$backupServerDir/" . $this->backup_filename . ".sql";
            // Remove SQL file in local
            $removeLocalFileCommand = "rm /tmp/" . $this->backup_filename . ".sql";

            $combinedCommand = $dumpCommand . " && " . $mkdirCommand . " && " . $transferCommand . " && " . $removeLocalFileCommand;

            $ssh->exec($combinedCommand);

        } catch (\Exception $exception) {
            $status = false;
        }

        app(BackupLogRepositoryInterface::class)->create(['ip' => $this->db_host, 'path' => $this->db_name, 'status' => $status, 'type' => 'db']);
    }
}
