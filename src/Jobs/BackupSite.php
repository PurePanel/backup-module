<?php

namespace Visiosoft\BackupModule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpseclib3\Net\SSH2;

class BackupSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $ssh_host;
    protected $ssh_root_username;
    protected $ssh_root_password;
    protected $ssh_port;
    protected $location;
    protected $backup_filename;

    public $tries = 3;

    public function __construct(
        $ssh_host,
        $ssh_root_username,
        $ssh_root_password,
        $ssh_port,
        $location,
        $backup_filename

    )
    {
        $this->ssh_host = $ssh_host;
        $this->ssh_root_username = $ssh_root_username;
        $this->ssh_root_password = $ssh_root_password;
        $this->ssh_port = $ssh_port;
        $this->location = $location;
        $this->backup_filename = $backup_filename;
    }

    public function handle()
    {

        $ssh = new SSH2($this->ssh_host, $this->ssh_port);
        $ssh->login($this->ssh_root_username, $this->ssh_root_password);
        $ssh->setTimeout(360);

        // Set Backup Storage Values
        $backup_host = setting_value('visiosoft.module.backup::remote_host_address');
        $backup_user = setting_value('visiosoft.module.backup::remote_host_user');
        $backup_port = setting_value('visiosoft.module.backup::remote_host_port');

        $command = "zip -r /tmp/".$this->backup_filename.".zip " . $this->location . " && scp -P $backup_port /tmp/".$this->backup_filename.".zip $backup_user@$backup_host:/home/";
        $ssh->exec($command);
    }
}
