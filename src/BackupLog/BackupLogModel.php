<?php namespace Visiosoft\BackupModule\BackupLog;

use Visiosoft\BackupModule\BackupLog\Contract\BackupLogInterface;
use Anomaly\Streams\Platform\Model\Backup\BackupBackupLogsEntryModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackupLogModel extends BackupBackupLogsEntryModel implements BackupLogInterface
{
    use HasFactory;

    /**
     * @return BackupLogFactory
     */
    protected static function newFactory()
    {
        return BackupLogFactory::new();
    }
}
