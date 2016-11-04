<?php namespace GoodNello\Pets\Components;

use Auth;
use Flash;
use Input;
use Request;
use Redirect;
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

    public function loadPet() {
        $id = $this->property('id');
        $pet = PetModel::find($id);

        return $pet;
    }

    public function onEdit() {
        $this->page['pet'] = $pet = PetModel::find(post('id'));

        if(!$pet || !$this->isOwner())
            return;
    }

    public function onUpdate() {

        $pet = PetModel::find(post('id'));

        if(!$pet || !$this->isOwner())
            return;

        $pet->fill(post());
        $pet->save();
        Flash::success(post('flash', 'Pet saved successfully'));
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

}
