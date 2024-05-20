<?php namespace Visiosoft\BackupModule\Command;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Visiosoft\BackupModule\Job\Contract\JobRepositoryInterface;
use Visiosoft\BackupModule\Jobs\BackupDB;
use Visiosoft\BackupModule\Jobs\BackupSite;
use Visiosoft\BackupModule\Server\Contract\ServerRepositoryInterface;

class BackupJob
{
    protected $job_id;

    public function __construct($job_id)
    {
        $this->job_id = $job_id;
    }

    public function handle(JobRepositoryInterface $jobRepository, ServerRepositoryInterface $serverRepository)
    {
        if ($job = $jobRepository->find($this->job_id)) {
            $server = $serverRepository->find($job->job_server_id);

            // Set Server Variables
            $server_host = $server->getAttribute('server_ip');
            $server_ssh_port = $server->getAttribute('server_ssh_port');
            $server_ssh_username = $server->getAttribute('server_ssh_username');
            $server_ssh_password = $server->getAttribute('server_ssh_password');
            $location = $job->getAttribute('backup_path');

            // Set Database Variables
            $db_host = $job->getAttribute('database_host') ?? $server_host;
            $db_driver = $job->getAttribute('database_type');
            $db_port = $job->getAttribute('database_type') == 'postgresql' ? 5432 : 3306;
            $db_username = $job->getAttribute('database_username');
            $db_password = $job->getAttribute('database_password');
            $db_name = $job->getAttribute('database_name');
            $isCompress = $job->getAttribute('is_compress');
            $compressType = $job->getAttribute('compress_type');

            $backup_name_schema = $job->getAttribute('backup_name_schema');

            $schema_params = [
                'job_slug' => $job->getAttribute('job_slug'),
                'datetime' => Carbon::now()->format('Y-m-d-H-i-s')
            ];

            foreach ($schema_params as $schema_key => $schema_value) {
                $backup_name_schema = Str::replace("{".$schema_key."}", $schema_value, $backup_name_schema);
            }

            $filename = $backup_name_schema;

            // Database Backup
            BackupDB::dispatch(
                $server_host,
                $server_ssh_username,
                $server_ssh_password,
                $server_ssh_port,
                $db_host,
                $db_username,
                $db_password,
                $db_port,
                $db_driver,
                $db_name,
                $filename)->onQueue('database-backup');

            // Files Backup
            BackupSite::dispatch(
                $server_host,
                $server_ssh_username,
                $server_ssh_password,
                $server_ssh_port,
                $location,
                $filename,
                $isCompress ?? true,
                $compressType
            )->onQueue('file-backup');

        }
    }
}
