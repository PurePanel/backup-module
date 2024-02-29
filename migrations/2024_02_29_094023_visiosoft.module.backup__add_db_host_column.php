<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleBackupAddDbHostColumn extends Migration
{
    protected $stream = [
        'slug' => 'jobs'
    ];

    protected $fields = [
        'database_host' => 'anomaly.field_type.text',
    ];

    protected $assignments = [
        'database_host'
    ];
}
