<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nnjeim\World\Models\Country;

class AuthController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('Auth.register',compact('countries'));    
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
            'gender' => ['required', 'in:0,1'],
            'mobile_number' => ['required', 'string', 'between:10,13'],
            'address' => ['required', 'string'],
            'country_id' => ['required', 'integer'],
            'state_id' => ['nullable', 'integer'],
            'city_id' => ['nullable', 'integer'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ],[
        'name.required' => 'Please enter your full name.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        
        'password.required' => 'Password is required.',
        'password.confirmed' => 'Password confirmation does not match.',
        'password.min' => 'Password must be at least 6 characters.',

        'gender.required' => 'Please select your gender.',

        'mobile_number.required' => 'Mobile number is required.',
        'mobile_number.between' => 'Enter Correct Mobile number .',

        'address.required' => 'Address is required.',
        'country_id.required' => 'Please select a country.',
        'image.required' => 'Please upload a profile image.',
        'image.image' => 'Uploaded file must be an image.',
    ]);

        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = "user_" .now()."." . $image->getClientOriginalExtension();
            $image->storeAs('uploads/user', $imageName, 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => 'user', // Set as regular user
            'status' => 1, // Active by default
            'gender' => $request->gender,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'image' => $imageName,
        ]);

        Auth::login($user,$request->remember_me);
        return redirect()->route('home');
        
    }

    public function login(Request $request)
    {
         // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Email address is required.',
            'password.required' => 'password is required.'
        ]);

        // Attempt to login
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check user type and redirect accordingly
            $user = Auth::user();

            // Check if user is blocked
            if ($user->status == 0) {
                Auth::logout();
                return back()->with('error', 'Your account has been blocked. Please contact support.');
            }

            return redirect()->intended(route('home'));
                
        }

        // Login failed
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password. Please try again.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
