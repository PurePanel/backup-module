<?php namespace Visiosoft\BackupModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class BackupModule extends Module
{

    /**
     * The navigation display flag.
     *
     * @var bool
     */
    protected $navigation = true;

    /**
     * The addon icon.
     *
     * @var string
     */
    protected $icon = 'fa fa-puzzle-piece';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'backup_logs' => [
            'buttons' => [
                'new_backup_log',
            ],
        ],
        'server' => [
            'buttons' => [
                'new_server',
            ],
        ],
        'jobs' => [
            'buttons' => [
                'new_job',
            ],
        ],
    ];

}
