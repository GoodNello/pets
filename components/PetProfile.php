<?php namespace GoodNello\Pets\Components;

use Auth;
use Flash;
use Input;
use Request;
use Redirect;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use GoodNello\Pets\Models\Pet as PetModel;

class PetProfile extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'PetProfile Component',
            'description' => 'Displays a pet profile on the page'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title' => 'Pet ID',
                'description' => 'The unique identifier of a pet',
                'default' => '{{ :id }}',
                'type' => 'string'
            ],
            'mode' => [
                'title' => 'Mode',
                'description' => 'How the page should be loaded',
                'type' => 'string',
                'default' => '{{ :mode }}'
            ]
        ];
    }

    public function onRun() {
        $this->page['pet'] = $pet = $this->loadPet();
        $this->page['owner'] = $this->isOwner();

        //If no pet is found, a 404 error page is shown
        if($this->page['pet'] == NULL) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }
    }

    public function onEnd() {

        $this->page['message'] = 0;
    }

    public function loadPet() {
        $id = $this->property('id');
        $pet = PetModel::find($id);

        return $pet;
    }

    public function onUpdate() {

        $this->page['pet'] = $pet = PetModel::find(post('id'));

        if(!$pet || !$this->isOwner())
            return;

        $mode = post('mode', 'edit');

        if($mode == 'save') {
            $pet->fill(post());
            $pet->save();
            $this->page['message'] = 'Pet saved successfully!';
        }
        elseif($mode == 'delete') {
            $pet->delete();
            $this->page['message'] = 'Pet deleted successfully!';
        }
        else {
            $this->page['speciesList'] = $species = $this->listSpecies();
            $this->page['birthdate'] = Carbon::parse($pet->birth)->format('Y-m-d');
            $this->page['today'] = Carbon::today()->format('Y-m-d');
        }

        $this->page['mode'] = $mode;
        $this->page['owner'] = $this->isOwner();
    }

    public function onUndo() {
        $this->page['pet'] = $pet = PetModel::find(post('id'));
        $this->page['owner'] = $this->isOwner();
    }

    public function isOwner() {

        $user = $this->getUser();

        if($user) {
            $petID = $this->property('id');
            if(PetModel::where('owner_id', $user->id)->where('id', $petID)->first())
                return $user;
        }

        return;
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
