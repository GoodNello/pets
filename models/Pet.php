<?php namespace GoodNello\Pets\Models;

use Model;
use Db;
use October\Rain\Database\Traits\Validation as Validation;

/**
 * Pet Model
 */
class Pet extends Model
{

    use Validation;

    protected $primaryKey = 'id';

    public $table = 'goodnello_pets_pets';

    public $timestamps = false;

    public $belongsTo = [
        'owner' => ['RainLab\User\Models\User']
    ];

    public $rules = [
        'name' => 'required|between:2,255',
    ];

    protected $fillable = [
        'name',
        'breed',
        'species',
        'description'
    ];

    protected $dates = [
        'birth',
    ];

    public static function getFromUser($user) {

        //NEEDS ATTENTION
        if($user->pet)
            return $user->pet;

        if($user->pet) {
            $user->pet = $pet;
            $pet->setRelation('user', $user);
        }

    }

    public function getOwnerIdOptions($keyValue = null) {

        $users_name = Db::table('users')->lists('username');

        return $users_name;
    }

    protected function listSpecies() {
        return json_decode(file_get_contents(__DIR__.'/../data/species.json'), true);
    }

    public function getSpeciesOptions($keyValue = null) {

        $species = array_map('ucfirst', $this->listSpecies());

        return $species;
    }

    protected function getSpeciesAttribute($value) {

        $species = array_map('ucfirst', $this->listSpecies());
        $value = $species[($value ?: 0)];

        return $value;
    }

}
