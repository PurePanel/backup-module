<?php namespace Visiosoft\BackupModule\Command;

use Illuminate\Console\Command;
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
        if ($site) {
            $sourcePath = "/home/" . $site->username;

            $remoteHostPort = setting_value('visiosoft.module.backup::remote_host_port');
            $remoteHostServerDir = setting_value('visiosoft.module.backup::remote_host_server_directory');
            $remoteHostUser = setting_value('visiosoft.module.backup::remote_host_user');
            $remoteHostAddress = setting_value('visiosoft.module.backup::remote_host_address');

            //TODO:: Make The Sync Process to Driver Based
            $rsyncCommand = "rsync  -avzu --delete -e 'ssh -p$remoteHostPort'  $sourcePath  $remoteHostUser@$remoteHostAddress:$remoteHostServerDir/" . $site->username;
            exec($rsyncCommand, $output, $returnCode);
            $status = $returnCode == 0;
            app(BackupLogRepositoryInterface::class)->create(['site_id' => $site->id, 'status' => $status]);
        }
    }
}
