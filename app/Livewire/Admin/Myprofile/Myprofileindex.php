<?php

namespace App\Livewire\Admin\Myprofile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetErrorBag();
    }

    public function updatedCountryId($value)
    {
        $this->state_id = null;
        $this->city_id = null;
        $this->states = [];
        $this->cities = [];
        
        if ($value) {
            $this->loadStates();
        }
    }

    public function updatedStateId($value)
    {
        $this->city_id = null;
        $this->cities = [];
        
        if ($value) {
            $this->loadCities();
        }
    }

    public function updatePersonalInfo()
    {
        $this->validate([
            'name' => 'required|string',
            'mobile_number' => 'required|string|min:10|max:20',
            'newImage' => 'nullable|image'
        ]);

        $user = Auth::guard('admin')->user();

        // Handle image upload
        if ($this->newImage) {
            // Store new image
            $extension = $this->newImage->getClientOriginalExtension();
            $imageName = "user_" .now().".".$extension;
            $this->newImage->storeAs('uploads/user',$imageName,'public');
            $user->image = $imageName;
            $this->image = $imageName;
        }

        $user->name = $this->name;
        $user->mobile_number = $this->mobile_number;
        $user->save();

        $this->newImage = null;
        
        session()->flash('message', 'Personal information updated successfully!');
    }

    public function updateAddress()
    {
        $this->validate([
            'address' => 'required|string',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required'
        ]);

        $user = Auth::guard('admin')->user();
        $user->address = $this->address;
        $user->country_id = $this->country_id;
        $user->state_id = $this->state_id;
        $user->city_id = $this->city_id;
        $user->save();

        session()->flash('message', 'Address updated successfully!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::guard('admin')->user();

        // Check current password
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect');
            return;
        }

        // Check if new password is same as current
        if (Hash::check($this->new_password, $user->password)) {
            $this->addError('new_password', 'New password cannot be the same as current password');
            return;
        }

        // Update password
        $user->password = Hash::make($this->new_password);
        $user->save();

        // Reset fields
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        session()->flash('message', 'Password changed successfully!');
    }

    public function render()
    { 
        return view('livewire.admin.myprofile.myprofileindex');
    }
}
