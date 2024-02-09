<?php namespace Visiosoft\BackupModule\Http\Controller\Admin;

use Visiosoft\BackupModule\Command\BackupJob;
use Visiosoft\BackupModule\Job\Form\JobFormBuilder;
use Visiosoft\BackupModule\Job\Table\JobTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Visiosoft\BackupModule\Jobs\BackupDB;

class JobsController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param JobTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(JobTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param JobFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(JobFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param JobFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(JobFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    public function backupNow($jobId)
    {
        dispatch(new BackupJob($jobId));
        $this->messages->success(trans('module::message.backup_started'));
        return $this->redirect->to('/admin/backup/jobs');
    }
}
