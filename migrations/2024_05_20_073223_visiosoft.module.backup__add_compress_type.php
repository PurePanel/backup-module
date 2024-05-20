<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupAddCompressType extends Migration
{

    protected $stream = [
        'slug' => 'jobs',
    ];

    protected $fields = [
        'compress_type' => [
            'type' => 'anomaly.field_type.select',
            'config' => [
                'options' => [
                    'tar' => 'tar',
                    'zip' => 'zip'
                ],
                'default_value' => 'zip',
            ],
        ],
    ];

    protected $assignments = [
        'compress_type'
    ];
}
