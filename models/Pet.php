<?php namespace GoodNello\Pets\Models;

use Model;
use Db;
use Carbon\Carbon as Carbon;
use October\Rain\Database\Traits\Validation as Validation;
use GoodNello\Pets\Models\Pet as PetModel;

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
        'owner_id',
        'breed',
        'species',
        'description'
    ];

    protected $dates = [
        'birth',
    ];

    public static function getFromUser($user) {

        return PetModel::where('owner_id', $user->id)->get();

    }

    public function getOwnerIdOptions($keyValue = null) {

        $users_name = Db::table('users')->lists('username');

        return $users_name;
    }

    protected function listSpecies() {
        return json_decode(file_get_contents(__DIR__.'/../data/species.json'));
    }

    // Lists species for creation/editing
    public function getSpeciesOptions($keyValue = null) {
        //I don't know why, but this keeps resetting when editing the model
        $species = array_map('ucfirst', $this->listSpecies());

        return $species;
    }

    // Shows the species name when displaying the model
    protected function getSpeciesAttribute($value) {

        $species = array_map('ucfirst', $this->listSpecies());
        $value = $species[($value ?: 0)];

        return $value;
    }

    protected function getBirthAttribute($value) {

        $formatted = Carbon::createFromFormat('Y-m-d', $value)->formatLocalized('%d/%m/%Y'); ;

        return $formatted;
    }

}
