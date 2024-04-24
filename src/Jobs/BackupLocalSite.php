<?php

namespace Visiosoft\BackupModule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Visiosoft\BackupModule\Console\BackupSite;
use Visiosoft\BackupModule\Console\BackupSiteDb;
use Visiosoft\SiteModule\Site\Contract\SiteInterface;

class BackupLocalSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $site;

    public $tries = 3;

    public function __construct(SiteInterface $site)
    {
        $this->site = $site;
    }

    public function handle()
    {
        Artisan::call(BackupSiteDb::class, ['site_id' => $this->site->site_id, 'backup_dir' => ""]);
        Artisan::call(BackupSite::class, ['site_id' => $this->site->site_id]);
    }
}
