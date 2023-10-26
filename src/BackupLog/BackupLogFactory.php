<?php namespace Visiosoft\BackupModule\BackupLog;

use Illuminate\Database\Eloquent\Factories\Factory;

class BackupLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var BackupLogModel
     */
    protected $model = BackupLogModel::class;


    /**
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [];
    }
}
