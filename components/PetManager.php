<?php namespace GoodNello\Pets\Components;

use Auth;
use Cms\Classes\ComponentBase;
use GoodNello\Pets\Models\Pet as PetModel;

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
        if($user) //Checks if the user has any pets associated
            $this->page['pets'] = $pets = (PetModel::where('owner_id', $user->id)->first() ? PetModel::where('owner_id', $user->id)->get() : 0);
    }

    public function getUser() {

        if (!Auth::check())
            return null;

        return Auth::getUser();

    }


}
