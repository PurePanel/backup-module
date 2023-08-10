<?php namespace Visiosoft\BackupModule\Backup;

use Illuminate\Database\Eloquent\Factories\Factory;

class BackupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var BackupModel
     */
    protected $model = BackupModel::class;


    /**
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [];
    }
}
