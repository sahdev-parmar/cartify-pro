<?php

namespace App\Livewire\Admin\Admins;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class AdminEdit extends Component
{
    use WithFileUploads;
    
    #[Reactive] 
    public $editUserId;
    public $name,$email,$type,$status,$image,$gender,$mobile_number,$address,$city_id,$state_id,$country_id;
    public $Userimage;
    public $countries = [];
    public $states = [];
    public $cities = [];

    public function mount()
    {
        $user = User::find($this->editUserId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->type = $user->type;
        $this->status = $user->status;
        $this->Userimage = $user->image;
        $this->gender = $user->gender;
        $this->mobile_number= $user->mobile_number;
        $this->address= $user->address;
        $this->city_id= $user->city_id;
        $this->state_id= $user->state_id;
        $this->country_id= $user->country_id;

        $this->countries = Country::orderBy('name')->get();
        
        if ($this->country_id) {
            $this->states = State::where('country_id', $this->country_id)
                ->orderBy('name')
                ->get();
        }
        
        if ($this->state_id) {
            $this->cities = City::where('state_id', $this->state_id)
                ->orderBy('name')
                ->get();
        }

    }

    
    public function updatedCountryId($value)
    {
        $this->state_id = null;
        $this->city_id = null;
        $this->cities = [];
        
        if ($value) {
            $this->states = State::where('country_id', $value)
                ->orderBy('name')
                ->get();
        } else {
            $this->states = [];
        }
    }

    public function updatedStateId($value)
    {
        $this->city_id = null;
        
        if ($value) {
            $this->cities = City::where('state_id', $value)
                ->orderBy('name')
                ->get();
        } else {
            $this->cities = [];
        }
    }

    public function  updateUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required|string|digits_between:10,13',
            'type' => 'required',
            'status' => 'required',
            'gender' => 'required',
            'image' => 'image|nullable',
        ],[
            'mobile_number.required' =>  'Please Provide mobile number',
            'mobile_number.*' =>  'Please Provide Correct mobile number',
        ]);    

        if($this->image){
            $extension = $this->image->getClientOriginalExtension();
            $userImage = "user_" .now().".".$extension;
            $this->image->storeAs('uploads/user',$userImage,'public');

            $this->image = $userImage;
        }else{
            $this->image = $this->Userimage;
        }

        $user = User::find($this->editUserId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'gender' => $this->gender,
            'type' => $this->type,
            'status' => $this->status,
            'address' => $this->address,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'image' => $this->image
        ]);
        sleep(1);
        $this->resetExcept('editUserId');
        $this->closeEditModal();
    }

    public function render()
    {
        return view('livewire.admin.admins.admin-edit');
    }

    public function closeEditModal()
    {
        $this->dispatch('closeEditModal');
    }
}
