<?php namespace Visiosoft\BackupModule\Server;

use Visiosoft\BackupModule\Server\Contract\ServerInterface;
use Anomaly\Streams\Platform\Model\Backup\BackupServerEntryModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServerModel extends BackupServerEntryModel implements ServerInterface
{
    use HasFactory;

    /**
     * @return ServerFactory
     */
    protected static function newFactory()
    {
        return ServerFactory::new();
    }
}
