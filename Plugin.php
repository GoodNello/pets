<?php namespace GoodNello\Pets;

use Backend;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;

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
            $model->hasMany['pet'] = ['GoodNello\Pets\Models\Pet'];
        });

    }

    public function registerComponents()
    {
        return [
            'GoodNello\Pets\Components\PetProfile' => 'petProfile',
            'GoodNello\Pets\Components\PetManager' => 'petManager',
            'GoodNello\Pets\Components\PetEditor' => 'petEditor',
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
