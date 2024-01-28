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

    protected $server;
    protected $ssh_host;
    protected $ssh_root_username;
    protected $ssh_root_password;
    protected $ssh_port;
    protected $location;
    protected $backup_filename;

    public $tries = 3;

    public function __construct(
        $server,
        $ssh_host,
        $ssh_root_username,
        $ssh_root_password,
        $ssh_port,
        $location,
        $backup_filename

    )
    {
        $this->ssh_host = $ssh_host;
        $this->server = $server;
        $this->ssh_root_username = $ssh_root_username;
        $this->ssh_root_password = $ssh_root_password;
        $this->ssh_port = $ssh_port;
        $this->location = $location;
        $this->backup_filename = $backup_filename;
    }

    public function handle()
    {
        $serverPassword = $this->server->getPassword();

        $ssh = new SSH2($this->server->getIp(), 22);
        $ssh->login("pure", $serverPassword);
        $ssh->setTimeout(360);

        $rsyncCommand = "echo $serverPassword | sudo -S sudo apt-get install sshpass -y && sshpass -p '" . $this->ssh_root_password . "' ssh -o StrictHostKeyChecking=no " . $this->ssh_root_username . "@" . $this->ssh_host . " 'cd " . $this->location . " && zip -r - . | cat' > /home/pure/" . $this->backup_filename . ".zip";
        $ssh->exec($rsyncCommand);
    }
}
