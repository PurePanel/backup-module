<?php namespace Visiosoft\BackupModule\BackupLog\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class BackupLogTableBuilder extends TableBuilder
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
        'id' => [
            'wrapper' => 'entry.id'
        ],
        'created_at' => [
            'wrapper' => '<strong>{value.datetime}</strong><br><small>{value.timeago}</small>',
            'value'   => [
                'datetime' => 'entry.created_at_datetime',
                'timeago'  => 'entry.created_at.diffForHumans()',
            ],
        ],
        'site',
        'status',
        'ip',
        'path',
        'type'
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'edit'
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
        "order_by" => [
            "id" => "DESC"
        ],
    ];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

}
