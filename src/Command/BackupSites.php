<?php namespace Visiosoft\BackupModule\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Visiosoft\SiteModule\Site\Contract\SiteRepositoryInterface;

class BackupSites extends Command
{
    protected $name = 'backup:sites';
    protected $signature = 'backup:sites';
    protected $description = 'Backup the all sites';

    public function handle()
    {
        $sites = app(SiteRepositoryInterface::class)->newQuery()->get();

        foreach ($sites as $site) {
            //Artisan::call(BackupSiteDb::class, ['site_id' => $site->site_id, 'backup_dir' => ""]);
            Artisan::call(BackupSite::class, ['site_id' => $site->site_id]);
        }
    }
}
