<?php

namespace App\Livewire\Admin\Admins;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class AdminAdd extends Component
{
    use WithFileUploads;

    public $name ,$email,$password,$password_confirmation, $type, $gender, $mobile_number, $image, $address, $country_id, $state_id, $city_id;
    public $states = [];
    public $cities = [];

    public function closeAddModal()
    {
        $this->dispatch('closeAddModal');
    }

    public function updatedCountryId($value)
    {
        $this->state_id = null;
        $this->city_id = null;
        $this->cities = [];

        if($value){
            $this->states = State::where('country_id',$value)->orderBy('name')->get();
        }else {
            $this->states = [];
        }
    }

    public function updatedStateId($value)
    {
        $this->city_id = null;
        $this->cities = [];

        if($value){
            $this->cities = City::where('state_id',$value)->orderBy('name')->get();
        }else {
            $this->cities = [];
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed',
            'type' => 'required',
            'gender' => 'required|in:0,1',
            'mobile_number' => 'required|min:10|max:20',
            'image' => 'required|image',
            'address' => 'nullable|string|max:500',
            'country_id' => 'nullable',
            'state_id' => 'nullable',
            'city_id' => 'nullable',
        ]);

         if ($this->image) {
            $extension = $this->image->getClientOriginalExtension();
            $userImage = "user_" .now().".".$extension;
            $this->image->storeAs('uploads/user',$userImage,'public');

            $this->image = $userImage;
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'type' => $this->type,
            'gender' => $this->gender,
            'mobile_number' => $this->mobile_number,
            'address' => $this->address,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'image' => $this->image
        ]);
        sleep(1);
        $this->reset();
        $this->closeAddModal();
    }

    public function render()
    {
        $countries = Country::orderBy('name')->get();

        return view('livewire.admin.admins.admin-add',[
            'countries' => $countries
        ]);
    }

    
}
