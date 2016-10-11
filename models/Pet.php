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

    protected $guarded = [
        'user_id'
    ];

    protected $fillable = [
        'name',
        'genus',
        'species',
        'description'
    ];

    protected $dates = [
        'birth',
    ];

    public static function getFromUser($user) {

        if($user->pet)
            return $user->pet;

        if($user->pet) {
            $user->pet = $pet;
            $pet->setRelation('user', $user);
        }
        else {
            $pet = new static;
            $pet->user = $user;
            $pet->save();

            $user->pet = $pet;

            return $pet;
        }

    }

}
