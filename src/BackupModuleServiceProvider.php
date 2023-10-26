<?php namespace Visiosoft\BackupModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Visiosoft\BackupModule\BackupLog\Contract\BackupLogRepositoryInterface;
use Visiosoft\BackupModule\BackupLog\BackupLogRepository;
use Anomaly\Streams\Platform\Model\Backup\BackupBackupLogsEntryModel;
use Visiosoft\BackupModule\BackupLog\BackupLogModel;
use Illuminate\Routing\Router;
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
        BackupBackupLogsEntryModel::class => BackupLogModel::class,
    ];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [
        BackupLogRepositoryInterface::class => BackupLogRepository::class,
    ];
}
