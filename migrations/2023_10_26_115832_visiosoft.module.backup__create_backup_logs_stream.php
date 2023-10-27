<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupCreateBackupLogsStream extends Migration
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
        'slug' => 'backup_logs',
        'title_column' => 'site_id',
        'translatable' => false,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    protected $fields = [
        'site' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\SiteModule\Site\SiteModel::class
            ]
        ],
        'status' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false
            ]
        ]
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'site',
        'status'
    ];

}
