<?php namespace GoodNello\Pets\Components;

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
        $this->page['mode'] = $mode = $this->property('mode');

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

    public function onUpdate() {

        if(!$pet = $this->loadPet())
            return;

        $pet->fill(post());
        $pet->save();

        Flash::success(post('flash', 'Pet saved successfully'));

    }

}
