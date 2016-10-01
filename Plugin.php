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

        User::extend(function($model){
            $model->hasOne['Pet'] = ['GoodNello\Pets\Model\Pet'];
        });

        UserController::extendFormFields(function($form, $model, $context) {

            $form->addTabFields([

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
