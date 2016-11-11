<?php namespace GoodNello\Pets\Components;

use Auth;
use Cms\Classes\ComponentBase;
use GoodNello\Pets\Models\Pet as PetModel;
use GoodNello\Pets\Models\Settings as Settings;

class PetManager extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'PetManager Component',
            'description' => 'Allows signed-in users to manage their pets'
        ];
    }

    public function defineProperties()
    {
        return [
            'petID' => [
                'title'       => 'Pet ID',
                'description' => 'The ID of the pet',
                'type'        => 'string',
                'default'     => 'id'
            ]
        ];
    }

    public function onRun() {
        $this->page['user'] = $user = $this->getUser();
        $this->page['alert'] = Settings::get('login_alert');
        if($user) //Checks if the user has any pets associated
            $this->page['pets'] = $pets = $this->getPets($user);
    }

    public function getPets($user) {
        if(PetModel::where('owner_id', $user->id)->first())
            return PetModel::where('owner_id', $user->id)->get();
        else
            return 0;
    }

    public function onCreate() {

        if(!$this->getUser())
            return;

        $mode = post('mode', 'create');

        if($mode == 'save') {
            $pet = new PetModel;
            $pet->fill(post());
            $pet->save();
            $this->page['message'] = 'Pet saved successfully!';
        }
        else
            $this->page['speciesList'] = $this->listSpecies();

        $this->page['mode'] = $mode;
        $this->onRun();

    }

    public function getUser() {

        if (!Auth::check())
            return null;

        return Auth::getUser();

    }

    protected function listSpecies() {
        return json_decode(file_get_contents(__DIR__.'/../data/species.json'));
    }

}
