<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nnjeim\World\Models\Country;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $countries = Country::all();
        return view('profile.profile-index',compact('user','countries'));
    }

    public function updatePersonal(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|between:10,13',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store new image
            $image = $request->file('image');
            $imageName = "user_" .now()."." . $image->getClientOriginalExtension();
            $image->storeAs('uploads/user', $imageName, 'public');
            $user->image = $imageName;
        }

        $user->name = $request->name;
        $user->mobile_number = $request->mobile_number;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Personal information updated successfully',
            'name' => $user->name,
            'image' => $user->image
        ]);
   
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id'
        ]);

        $user = Auth::user();
        $user->address = $request->address;
        $user->country_id = $request->country_id;
        $user->state_id = $request->state_id;
        $user->city_id = $request->city_id;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect'
            ],400);
        }

        // Check if new password is same as current
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'New password cannot be the same as current password'
            ],400);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }

}
