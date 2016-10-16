<?php namespace GoodNello\Pets\Components;

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
            ]
        ];
    }

    public function onRun() {
        $this->page['pet'] = $pet = $this->loadPet();

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

}
