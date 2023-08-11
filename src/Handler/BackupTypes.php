<?php

namespace Visiosoft\BackupModule\Handler;

use Anomaly\SelectFieldType\SelectFieldType;

class BackupTypes
{
    public function handle(SelectFieldType $fieldType)
    {
        $fieldType->setOptions([
            'database' => 'Database',
            'files' => 'Files'
        ]);
    }
}
