<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupAddBackupType extends Migration
{

    protected $stream = [
        'slug' => 'backup_logs'
    ];

    protected $fields = [
        'type' => [
            'type' => 'anomaly.field_type.text',
        ],
    ];

    protected $assignments = [
        'type',
    ];
}
