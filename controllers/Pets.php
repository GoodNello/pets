<?php namespace GoodNello\Pets\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Pets Back-end Controller
 */
class Pets extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('GoodNello.Pets', 'pets', 'pets');
    }
}
