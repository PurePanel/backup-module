<?php namespace Visiosoft\BackupModule\Backup;

use Visiosoft\BackupModule\Backup\Contract\BackupRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class BackupRepository extends EntryRepository implements BackupRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var BackupModel
     */
    protected $model;

    /**
     * Create a new BackupRepository instance.
     *
     * @param BackupModel $model
     */
    public function __construct(BackupModel $model)
    {
        $this->model = $model;
    }
}
