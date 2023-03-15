<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentCampaign = Campaign::whereNull('end_date')->first();
        if ( isset($currentCampaign) ) {
            $currentCampaign = $currentCampaign
                ->loadCount([
                    'volunteers'
                ]);
            $currentCampaign->administrators_count = User::whereHas('typeUser', function ($query) {
                $query->where('nombre', 'Administrator');
            })->count();
            $currentCampaign->sympathizers_count = User::whereHas('typeUser', function ($query) {
                $query->where('nombre', 'Sympathizer');
            })->count();
        }
        return view('dashboard')->with([
            'campaign' => $currentCampaign
        ]);
    }
}
