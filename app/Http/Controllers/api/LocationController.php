<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\State;

class LocationController extends Controller
{
    public function states($countryId)
    {
        return response()->json(
            State::where('country_id', $countryId)->get()
        );
    }

    public function cities($stateId)
    {
        return response()->json(
            City::where('state_id', $stateId)->get()
        );
    }
}
