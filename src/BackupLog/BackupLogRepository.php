<?php namespace Visiosoft\BackupModule\BackupLog;

use Visiosoft\BackupModule\BackupLog\Contract\BackupLogRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class BackupLogRepository extends EntryRepository implements BackupLogRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var BackupLogModel
     */
    protected $model;

    /**
     * Create a new BackupLogRepository instance.
     *
     * @param BackupLogModel $model
     */
    public function __construct(BackupLogModel $model)
    {
        $this->model = $model;
    }
}
