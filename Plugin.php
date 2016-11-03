<?php namespace GoodNello\Pets;

use Backend;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use GoodNello\Pets\Models\Settings as Settings;

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
            'GoodNello\Pets\Components\PetManager' => 'petManager'
        ];
    }

    public function registerPermissions()
    {
        return [
            'goodnello.pets.access_settings' => [
                'tab' => 'Pets',
                'label' => 'Manage backend settings'
            ],
        ];
    }

    public function registerNavigation()
    {
        if (Settings::instance()->backend_menu)
            return [
                'pets' => [
                    'label'       => 'Pets',
                    'url'         => Backend::url('goodnello/pets/pets'),
                    'icon'        => 'icon-paw',
                    'permissions' => ['goodnello.pets.*'],
                    'order'       => 500,
                ],
            ];
        else
            return [];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Pets Settings',
                'description' => 'Manage settings for the Pets plugin.',
                'category'    => 'Pets',
                'icon'        => 'icon-paw',
                'class'       => 'GoodNello\Pets\Models\Settings',
                'order'       => 500,
                'keywords'    => 'pets pet',
                'permissions' => ['goodnello.pets.access_settings']
            ]
        ];
    }

}
