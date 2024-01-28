<?php namespace Visiosoft\BackupModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Visiosoft\BackupModule\Job\Contract\JobRepositoryInterface;
use Visiosoft\BackupModule\Job\JobRepository;
use Anomaly\Streams\Platform\Model\Backup\BackupJobsEntryModel;
use Visiosoft\BackupModule\Job\JobModel;
use Visiosoft\BackupModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\BackupModule\Server\ServerRepository;
use Anomaly\Streams\Platform\Model\Backup\BackupServerEntryModel;
use Visiosoft\BackupModule\Server\ServerModel;
use Visiosoft\BackupModule\BackupLog\Contract\BackupLogRepositoryInterface;
use Visiosoft\BackupModule\BackupLog\BackupLogRepository;
use Anomaly\Streams\Platform\Model\Backup\BackupBackupLogsEntryModel;
use Visiosoft\BackupModule\BackupLog\BackupLogModel;
use Visiosoft\BackupModule\Command\BackupSite;
use Visiosoft\BackupModule\Command\BackupSiteDb;
use Visiosoft\BackupModule\Command\BackupSites;

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
        ]
    ];

    /**
     * The addon routes.
     *
     * @type array|null
     */
    protected $routes = [
        'admin/backup/jobs'           => 'Visiosoft\BackupModule\Http\Controller\Admin\JobsController@index',
        'admin/backup/jobs/create'    => 'Visiosoft\BackupModule\Http\Controller\Admin\JobsController@create',
        'admin/backup/jobs/edit/{id}' => 'Visiosoft\BackupModule\Http\Controller\Admin\JobsController@edit',
        'admin/backup/server'           => 'Visiosoft\BackupModule\Http\Controller\Admin\ServerController@index',
        'admin/backup/server/create'    => 'Visiosoft\BackupModule\Http\Controller\Admin\ServerController@create',
        'admin/backup/server/edit/{id}' => 'Visiosoft\BackupModule\Http\Controller\Admin\ServerController@edit',
        'admin/backup' => 'Visiosoft\BackupModule\Http\Controller\Admin\BackupLogsController@index',
        'admin/backup/create' => 'Visiosoft\BackupModule\Http\Controller\Admin\BackupLogsController@create',
        'admin/backup/edit/{id}' => 'Visiosoft\BackupModule\Http\Controller\Admin\BackupLogsController@edit',
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
