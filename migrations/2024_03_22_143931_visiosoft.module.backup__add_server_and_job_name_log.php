<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupAddServerAndJobNameLog extends Migration
{

    protected $stream = [
        'slug' => 'backup_logs'
    ];

    protected $fields = [
        'ip' => [
            'type' => 'anomaly.field_type.text',
        ],
        'path' => [
            'type' => 'anomaly.field_type.text',
        ]
    ];

    protected $assignments = [
        'ip',
        'path'
    ];
}
