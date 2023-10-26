<?php namespace Visiosoft\BackupModule\Http\Controller\Admin;

use Visiosoft\BackupModule\BackupLog\Form\BackupLogFormBuilder;
use Visiosoft\BackupModule\BackupLog\Table\BackupLogTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class BackupLogsController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param BackupLogTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BackupLogTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param BackupLogFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(BackupLogFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param BackupLogFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(BackupLogFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
