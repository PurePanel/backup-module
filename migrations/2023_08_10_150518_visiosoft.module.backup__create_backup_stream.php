<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupCreateBackupStream extends Migration
{

    /**
     * This migration creates the stream.
     * It should be deleted on rollback.
     *
     * @var bool
     */
    protected $delete = false;

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'backup',
        'title_column' => 'id',
        'translatable' => false,
        'versionable' => true,
        'trashable' => true,
        'searchable' => true,
        'sortable' => true,
    ];

    protected $fields = [
        'source_server' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\ServerModule\Server\ServerModel::class,
                'mode' => 'lookup'
            ],
        ],
        'target_server' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\ServerModule\Server\ServerModel::class,
                'mode' => 'lookup'
            ],
        ],
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name' => [
            'translatable' => true,
            'required' => true,
        ],
        'slug' => [
            'unique' => true,
            'required' => true,
        ],
    ];

}
