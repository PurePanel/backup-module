<?php namespace Visiosoft\BackupModule\Job\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class JobTableBuilder extends TableBuilder
{

    /**
     * The table views.
     *
     * @var array|string
     */
    protected $views = [];

    /**
     * The table filters.
     *
     * @var array|string
     */
    protected $filters = [];

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'job_name',
        'job_server',
        'database_type',
        'backup_path',
        'last_backup_at'
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'edit',
        'backup_now' => [
            'type' => 'primary',
            'icon' => 'refresh',
            'href' => 'admin/backup/backup-now/{entry.id}'
        ],
    ];

    /**
     * The table actions.
     *
     * @var array|string
     */
    protected $actions = [
        'delete'
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'order_by' => [
            'id' => 'DESC'
        ],
    ];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

}
