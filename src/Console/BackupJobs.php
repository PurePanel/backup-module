<?php namespace Visiosoft\BackupModule\Console;

use Illuminate\Console\Command;
use Visiosoft\BackupModule\Command\BackupJob;
use Visiosoft\BackupModule\Job\Contract\JobRepositoryInterface;

class BackupJobs extends Command
{
    protected $signature = 'backup:jobs';
    protected $description = 'Backup the all jobs';

    public function handle()
    {
        $jobs = app(JobRepositoryInterface::class)->all();
        $this->info('------- Started Backups(Jobs) -------');
        foreach ($jobs as $job) {
            dispatch(new BackupJob($job->id));
            $this->info('------- Backup Job Created (Queue) => ' . $job->job_name . '  -------');
        }
        $this->info('------- Completed Backups(Jobs) -------');
    }
}