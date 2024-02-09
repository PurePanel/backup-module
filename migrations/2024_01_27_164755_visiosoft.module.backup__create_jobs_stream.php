<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupCreateJobsStream extends Migration
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
        'slug' => 'jobs',
        'title_column' => 'job_name',
        'translatable' => false,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    protected $fields = [
        'job_server' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\BackupModule\Server\ServerModel::class,
                'mode' => 'lookup'
            ],
        ],
        'job_name' => 'anomaly.field_type.text',
        'job_slug' => [
            'type' => 'anomaly.field_type.slug',
            'config' => [
                'slugify' => 'job_name',
                'type' => '-'
            ],
        ],
        'backup_path' => 'anomaly.field_type.text',
        'backup_name_schema' => [
            'type' => 'anomaly.field_type.text',
            'config' => [
                'default_value' => 'backup-{job_slug}-{datetime}'
            ],
        ],
        'database_type' => [
            'type' => 'anomaly.field_type.select',
            'config' => [
                'options' => [
                    'postgresql' => 'PostgresSQL',
                    'mysql' => 'MySQL',
                ]
            ],
        ],
        'database_name' => 'anomaly.field_type.text',
        'database_username' => [
            'type' => 'anomaly.field_type.text',
            'config' => [
                'default_value' => 'root'
            ],
        ],
        'database_password' => 'anomaly.field_type.text',
        'last_backup_at' => 'anomaly.field_type.datetime',
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'job_server' => [
            'required' => true,
        ],
        'job_name' => [
            'required' => true,
        ],
        'job_slug' => [
            'unique' => true,
            'required' => true,
        ],
        'backup_path' => [
            'required' => true,
        ],
        'backup_name_schema' => [
            'required' => true,
        ],
        'database_type' => [
            'required' => true,
        ],
        'database_name' => [
            'required' => true,
        ],
        'database_username' => [
            'required' => true,
        ],
        'database_password' => [
            'required' => true,
        ],
        'last_backup_at'
    ];

}
