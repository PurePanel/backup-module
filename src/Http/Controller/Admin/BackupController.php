<?php namespace Visiosoft\BackupModule\Http\Controller\Admin;

use Visiosoft\BackupModule\Backup\Form\BackupFormBuilder;
use Visiosoft\BackupModule\Backup\Table\BackupTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class BackupController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param BackupTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BackupTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param BackupFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(BackupFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param BackupFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(BackupFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
