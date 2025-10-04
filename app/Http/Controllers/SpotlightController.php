<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Spotlight')]
class SpotlightController
{
    public function searchSpotlight(Request $request)
    {
        $query = $request->input('query');

        return apiResponse('Spotlight results retrieved successfully', app('spotlight')->search($query));
    }

    public function getStaticItems()
    {
        return apiResponse('Static items retrieved successfully', app('spotlight')->getStaticItems());
    }

    public function getManualItems()
    {
        return apiResponse('Static items retrieved successfully', app('spotlight')->getManualItems());
    }
}
