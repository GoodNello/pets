<?php namespace GoodNello\Pets\Models;

use Model;

/**
 * Settings Model
 */
class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'goodnello_pets_settings';

    public $settingsFields = 'fields.yaml';

}
