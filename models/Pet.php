<?php namespace GoodNello\Pets\Models;

use Model;
use Db;

/**
 * Pet Model
 */
class Pet extends Model
{
    public $table = 'goodnello_pets_pets';

    public $timestamps = false;

    public $belongsToMany = [
        'owners' => ['RainLab\User\Models\User', 'table' => 'goodnello_pets_owners']
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

    }

    public function getUserOptions($keyValue = null) {

        $users_name = Db::table('users')->lists('username');

        return $users_name;
    }

}
