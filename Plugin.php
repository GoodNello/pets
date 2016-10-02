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

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Pets',
            'description' => 'No description provided yet...',
            'author'      => 'GoodNello',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot() {

        UserModel::extend(function($model){
            $model->hasOne['Pet'] = ['GoodNello\Pets\Model\Pet'];
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
                        'cat' => 'Cat',
                        'dog' => 'Dog',
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

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'GoodNello\Pets\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
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

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'pets' => [
                'label'       => 'Pets',
                'url'         => Backend::url('goodnello/pets/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['goodnello.pets.*'],
                'order'       => 500,
            ],
        ];
    }

}
