<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupIsCompressFile extends Migration
{
    protected $stream = [
        'slug' => 'jobs',
    ];

    protected $fields = [
        'is_compress' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => true,
            ],
        ],
    ];

    protected $assignments = [
        'is_compress'
    ];
}
