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
        // Set Backup Storage Values
        $backup_host = setting_value('visiosoft.module.backup::remote_host_address');
        $backup_user = setting_value('visiosoft.module.backup::remote_host_user');
        $backup_port = setting_value('visiosoft.module.backup::remote_host_port');

        $ssh = new SSH2($this->ssh_host, $this->ssh_port);
        $ssh->login($this->ssh_root_username, $this->ssh_root_password);
        $ssh->setTimeout(360);

        if ($this->db_driver == 'postgresql') {
            $command = "pg_dump -h " . $this->db_host . " -p " . $this->db_port . " -U " . $this->db_root_username . " -Fc " . $this->db_name . " > " . $this->backup_filename . ".sql && scp -P $backup_port " . $this->backup_filename . ".sql $backup_user@$backup_host:/home/" . $this->backup_filename . ".sql";
        } else {
            $command = "mysqldump --defaults-extra-file=~/." . $this->db_name . ".cnf --single-transaction -h " . $this->db_host . " -u " . $this->db_root_username . " " . $this->db_name . " > " . $this->backup_filename . ".sql && scp -P $backup_port " . $this->backup_filename . ".sql $backup_user@$backup_host:/home/" . $this->backup_filename . ".sql";
        }
        $ssh->exec($command);
    }
}
