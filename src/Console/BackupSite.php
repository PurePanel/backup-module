<?php namespace Visiosoft\BackupModule\Console;

use Illuminate\Console\Command;
use phpseclib3\Net\SSH2;
use Visiosoft\BackupModule\BackupLog\Contract\BackupLogRepositoryInterface;
use Visiosoft\SiteModule\Site\Contract\SiteRepositoryInterface;

class BackupSite extends Command
{
    protected $signature = 'backup:site {site_id}';
    protected $description = 'Backup the specified site';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $siteId = $this->argument('site_id');
        $site = app(SiteRepositoryInterface::class)->getSiteBySiteID($siteId);
        $serverPassword = $site->server->getPassword();
        $status = true;
        if ($site) {
            $sourcePath = "/home/" . $site->username . "/web";

            try {
                $remoteHostPort = setting_value('visiosoft.module.backup::remote_host_port');
                $remoteHostUser = setting_value('visiosoft.module.backup::remote_host_user');
                $remoteHostAddress = setting_value('visiosoft.module.backup::remote_host_address');
                $remoteHostPassword = setting_value('visiosoft.module.backup::remote_host_password');

                $remoteHostServerDir = str_replace('.', '_', $site->server->getIp());

                $ssh = new SSH2($remoteHostAddress, $remoteHostPort);
                $ssh->login($remoteHostUser, $remoteHostPassword);
                $ssh->setTimeout(360);

                $ssh = new SSH2($site->server->getIp(), 22);
                $ssh->login('pure', $serverPassword);
                $ssh->setTimeout(360);
                //TODO:: Make The Sync Process to Driver Based
                $rsyncCommand = "echo $serverPassword | sudo -S sudo rsync  -avzu --delete -e 'ssh -i /home/pure/.ssh/id_rsa -p$remoteHostPort'  $sourcePath  $remoteHostUser@$remoteHostAddress:$remoteHostServerDir/" . $site->username . "| echo data ok";
                $deleteCommand = "rm -rf /home/" . $site->username . "/web/sql_backup";

                $combinedCommand = $rsyncCommand . " && " . $deleteCommand;

                $ssh->exec($combinedCommand);
            } catch (\Exception $e) {
                $status = false;
            }
            app(BackupLogRepositoryInterface::class)->create(['site_id' => $site->id, 'status' => $status]);
        }
    }
}
