<?php namespace Visiosoft\BackupModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Model\Backup\BackupBackupLogsEntryModel;
use Anomaly\Streams\Platform\Model\Backup\BackupJobsEntryModel;
use Anomaly\Streams\Platform\Model\Backup\BackupServerEntryModel;
use Visiosoft\BackupModule\BackupLog\BackupLogModel;
use Visiosoft\BackupModule\BackupLog\BackupLogRepository;
use Visiosoft\BackupModule\BackupLog\Contract\BackupLogRepositoryInterface;
use Visiosoft\BackupModule\Console\BackupJobs;
use Visiosoft\BackupModule\Console\BackupSite;
use Visiosoft\BackupModule\Console\BackupSiteDb;
use Visiosoft\BackupModule\Console\BackupSites;
use Visiosoft\BackupModule\Job\Contract\JobRepositoryInterface;
use Visiosoft\BackupModule\Job\JobModel;
use Visiosoft\BackupModule\Job\JobRepository;
use Visiosoft\BackupModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\BackupModule\Server\ServerModel;
use Visiosoft\BackupModule\Server\ServerRepository;

class BackupModuleServiceProvider extends AddonServiceProvider
{

    /**
     * The addon Artisan commands.
     *
     * @type array|null
     */
    protected $commands = [
        BackupSite::class,
        BackupSiteDb::class,
        BackupSites::class
    ];

    /**
     * The addon's scheduled commands.
     *
     * @type array|null
     */
    protected $schedules = [
        'daily' => [
            BackupSites::class,
            BackupJobs::class,
        ]
    ];

    /**
     * The addon routes.
     *
     * @type array|null
     */
    protected $routes = [
        'admin/backup/jobs' => 'Visiosoft\BackupModule\Http\Controller\Admin\JobsController@index',
        'admin/backup/jobs/create' => 'Visiosoft\BackupModule\Http\Controller\Admin\JobsController@create',
        'admin/backup/jobs/edit/{id}' => 'Visiosoft\BackupModule\Http\Controller\Admin\JobsController@edit',
        'admin/backup/server' => 'Visiosoft\BackupModule\Http\Controller\Admin\ServerController@index',
        'admin/backup/server/create' => 'Visiosoft\BackupModule\Http\Controller\Admin\ServerController@create',
        'admin/backup/server/edit/{id}' => 'Visiosoft\BackupModule\Http\Controller\Admin\ServerController@edit',
        'admin/backup' => 'Visiosoft\BackupModule\Http\Controller\Admin\BackupLogsController@index',
        'admin/backup/create' => 'Visiosoft\BackupModule\Http\Controller\Admin\BackupLogsController@create',
        'admin/backup/edit/{id}' => 'Visiosoft\BackupModule\Http\Controller\Admin\BackupLogsController@edit',
        'admin/backup/backup-now/{job_id}' => 'Visiosoft\BackupModule\Http\Controller\Admin\JobsController@backupNow',
    ];

    /**
     * The addon class bindings.
     *
     * @type array|null
     */
    protected $bindings = [
        BackupJobsEntryModel::class => JobModel::class,
        BackupServerEntryModel::class => ServerModel::class,
        BackupBackupLogsEntryModel::class => BackupLogModel::class,
    ];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [
        JobRepositoryInterface::class => JobRepository::class,
        ServerRepositoryInterface::class => ServerRepository::class,
        BackupLogRepositoryInterface::class => BackupLogRepository::class,
    ];
}
