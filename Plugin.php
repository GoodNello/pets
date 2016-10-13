<?php namespace GoodNello\Pets;

use Backend;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
use GoodNello\Pets\Models\Pet as PetModel;

/**
 * Pets Plugin Information File
 */
class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Pets',
            'description' => 'Allows users to add their pets to their profiles',
            'author'      => 'GoodNello',
            'icon'        => 'icon-paw'
        ];
    }

    public function boot() {

        UserModel::extend(function($model){
            $model->belongsToMany['pet'] = ['GoodNello\Pets\Models\Pet', 'table' => 'goodnello_pets_owners'];
        });

    }

    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'GoodNello\Pets\Components\MyComponent' => 'myComponent',
        ];
    }

    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'goodnello.pets.some_permission' => [
                'tab' => 'Pets',
                'label' => 'Some permission'
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'pets' => [
                'label'       => 'Pets',
                'url'         => Backend::url('goodnello/pets/pets'),
                'icon'        => 'icon-paw',
                'permissions' => ['goodnello.pets.*'],
                'order'       => 500,
            ],
        ];
    }

}
