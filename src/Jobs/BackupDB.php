<?php

namespace Visiosoft\BackupModule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpseclib3\Net\SSH2;

class BackupDB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $server;
    protected $db_host;
    protected $db_root_username;
    protected $db_root_password;
    protected $db_port;

    protected $db_name;
    protected $backup_filename;

    public $tries = 3;

    public function __construct(
        $server,
        $db_host,
        $db_root_username,
        $db_root_password,
        $db_port,
        $db_name,
        $backup_filename
    )
    {
        $this->server = $server;
        $this->db_host = $db_host;
        $this->db_root_username = $db_root_username;
        $this->db_root_password = $db_root_password;
        $this->db_port = $db_port;
        $this->db_name = $db_name;
        $this->backup_filename = $backup_filename;
    }

    public function handle()
    {
        $serverPassword = $this->server->getPassword();

        $ssh = new SSH2($this->server->getIp(), 22);
        $ssh->login("pure", $serverPassword);
        $ssh->setTimeout(360);

        $rsyncCommand = "echo $serverPassword | sudo -S sudo apt-get install -y postgresql-client-14 && pg_dump -h " . $this->db_host . " -p " . $this->db_port . " -U " . $this->db_root_username . " -Fc " . $this->db_name . " > /home/pure/" . $this->backup_filename . ".sql";
        $ssh->exec($rsyncCommand);
    }
}
