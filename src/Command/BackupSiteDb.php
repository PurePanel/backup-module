<?php

namespace Visiosoft\BackupModule\Command;

use Illuminate\Console\Command;
use phpseclib3\Net\SSH2;
use Visiosoft\SiteModule\Site\Contract\SiteRepositoryInterface;

class BackupSiteDb extends Command
{
    protected $signature = 'backup:site_db {site_id} {backup_dir}';
    protected $description = 'Backup the site_Db specified site';

    public function handle()
    {
        $siteId = $this->argument('site_id');
        $site = app(SiteRepositoryInterface::class)->getSiteBySiteID($siteId);
        $backupDir = $this->argument('backup_dir');
        $fileName = date("Y-m-d H:i:s") . "_" . $site->username;

        $serverPassword = $site->server->getPassword();

        $ssh = new SSH2($site->server->ip, 22);
        $ssh->login('pure', $serverPassword);
        $ssh->setTimeout(360);

        if (strlen($backupDir)) {
            $backupDir = "/home/" . $site->username . "/www/sql_backup";
            $ssh->exec('mkdir ' . $backupDir);
        }

        $ssh->exec('mysqldump --host="localhost" --user=' . $site->username . ' --password=' . $site->database . ' ' . $site->username . ' > ' . $backupDir . '/' . $fileName);
        $ssh->exec('exit');
    }
}
