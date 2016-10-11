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
            $model->hasOne['pet'] = ['GoodNello\Pets\Models\Pet'];
        });

        UsersController::extendFormFields(function($form, $model, $context) {

            if(!$model instanceof UserModel || !$model->exists)
                return;

            PetModel::getFromUser($model);

            $form->addTabFields([
                'pet[name]' => [
                    'label' => 'Name',
                    'tab' => 'Pets',
                    'type' => 'text',
                ],
                'pet[genus]' => [
                    'label' => 'Genus',
                    'tab' => 'Pets',
                    'type' => 'dropdown',
                    'options' => [
                        'Cat' => 'Cat',
                        'Dog' => 'Dog',
                    ],
                ],
                'pet[species]' => [
                    'label' => 'Species',
                    'tab' => 'Pets',
                    'type' => 'text',
                ],
                'pet[birth]' => [
                    'label' => 'Birth',
                    'tab' => 'Pets',
                    'type' => 'datepicker',
                    'mode' => 'date',
                    'maxDate' => 'today',
                ],
                'pet[description]' => [
                    'label' => 'Description',
                    'tab' => 'Pets',
                    'type' => 'textarea',
                ],
            ]);

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
