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
        $fileName = time() . "-" . date("Y-m-d") . "-" . $site->username . ".sql";

        $serverPassword = $site->server->getPassword();

        $ssh = new SSH2($site->server->ip, 22);
        $ssh->login('pure', $serverPassword);
        $ssh->setTimeout(360);

        if ((int)$backupDir == 0) {
            $backupDir = "/home/" . $site->username . "/web/sql_backup";
            $ssh->exec('echo ' . $serverPassword . ' | sudo -S sudo mkdir ' . $backupDir);
            $ssh->exec('echo ' . $serverPassword . ' | sudo -S sudo chmod -R 777 ' . $backupDir);
        }

        $ssh->exec('echo ' . $serverPassword . ' | sudo -S sudo mysqldump --host="localhost" --user=pure --password=' . $site->server->getDatabasePassword() . ' ' . $site->username . ' > ' . $backupDir . '/' . $fileName);
        $ssh->exec('exit');
    }
}
