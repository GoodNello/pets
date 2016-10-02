<?php namespace GoodNello\Pets\Models;

use Model;

/**
 * Pet Model
 */
class Pet extends Model
{
    public $table = 'goodnello_pets_pets';

    public $timestamps = false;

    public $belongsTo = [
        'user' => ['RainLab\User\Models\User']
    ];

    public static function getFromUser($user) {

        if($user->pet)
            return $user->pet;

        $pet = new static;
        $pet->user = $user;
        $pet->save();

        $user->pet = $pet;

        return $pet;

    }

}
