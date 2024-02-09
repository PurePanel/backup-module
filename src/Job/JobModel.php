<?php namespace Visiosoft\BackupModule\Job;

use Visiosoft\BackupModule\Job\Contract\JobInterface;
use Anomaly\Streams\Platform\Model\Backup\BackupJobsEntryModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobModel extends BackupJobsEntryModel implements JobInterface
{
    use HasFactory;

    /**
     * @return JobFactory
     */
    protected static function newFactory()
    {
        return JobFactory::new();
    }
}
