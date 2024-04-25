<?php namespace Visiosoft\BackupModule\Console;

use Illuminate\Console\Command;
use Visiosoft\BackupModule\Jobs\BackupLocalSite;
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
            BackupLocalSite::dispatch($site);
        }
    }
}
