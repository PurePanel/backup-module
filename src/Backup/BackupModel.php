<?php namespace Visiosoft\BackupModule\Backup;

use Visiosoft\BackupModule\Backup\Contract\BackupInterface;
use Anomaly\Streams\Platform\Model\Backup\BackupBackupEntryModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackupModel extends BackupBackupEntryModel implements BackupInterface
{
    use HasFactory;

    /**
     * @return BackupFactory
     */
    protected static function newFactory()
    {
        return BackupFactory::new();
    }
}
