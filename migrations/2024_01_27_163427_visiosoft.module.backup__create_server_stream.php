<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupCreateServerStream extends Migration
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
        'slug' => 'server',
        'title_column' => 'server_name',
        'translatable' => false,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    protected $fields = [
        'server_name' => 'anomaly.field_type.text',
        'server_ip' => 'anomaly.field_type.text',
        'server_ssh_port' => [
            'type' => 'anomaly.field_type.integer',
            'config' => [
                'min' => 0,
                'default_value' => 22
            ],
        ],
        'server_ssh_username' => [
            'type' => 'anomaly.field_type.text',
            'config' => [
                'default_value' => 'root'
            ],
        ],
        'server_ssh_password' => 'anomaly.field_type.text',
        'configuration_completed' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false
            ],
        ],
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'server_name' => [
            'required' => true,
        ],
        'server_ip' => [
            'required' => true,
        ],
        'server_ssh_port' => [
            'required' => true,
        ],
        'server_ssh_username' => [
            'required' => true,
        ],
        'server_ssh_password' => [
            'required' => true,
        ],
        'configuration_completed',
    ];
}
