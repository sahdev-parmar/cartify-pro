<?php

namespace App\Livewire\Admin\Myprofile;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class Myprofileindex extends Component
{
    use WithFileUploads;

     // Tab state
    public $activeTab = 'personal';

    public $user;
    // Personal Info
    public $name,$email,$mobile_number,$image,$newImage;

    // Address
    public $address,$country_id,$state_id,$city_id;

    // Password
    public $current_password,$new_password,$new_password_confirmation;

    // Data
    public $countries = [];
    public $states = [];
    public $cities = [];

    public function mount()
    {
        $user = Auth::guard('admin')->user();
        $this->user = $user;
        // Load personal info
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile_number = $user->mobile_number;
        $this->image = $user->image;

        // Load address
        $this->address = $user->address;
        $this->country_id = $user->country_id;
        $this->state_id = $user->state_id;
        $this->city_id = $user->city_id;

        // Load countries
        $this->countries = Country::all();

        // Load states and cities if country/state selected
        if ($this->country_id) {
            $this->loadStates();
        }
        if ($this->state_id) {
            $this->loadCities();
        }
    }

    private function loadStates()
    {
        $this->states = State::where('country_id', $this->country_id)->get();
    }

    private function loadCities()
    {
        $this->cities = City::where('state_id', $this->state_id)->get();
    }

    public function render()
    { 
        return view('livewire.admin.myprofile.myprofileindex');
    }
}
