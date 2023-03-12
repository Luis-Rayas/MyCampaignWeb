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
            $currentCampaign->users = DB::table('users')
            ->selectRaw('COUNT(type_user_pivot.type_user_id) as num, type_users.nombre')
            ->join('type_user_pivot', 'users.id', '=', 'type_user_pivot.user_id')
            ->join('type_users', 'type_users.id', '=', 'type_user_pivot.type_user_id')
            ->groupBy('type_user_pivot.type_user_id')->get();
        }
        return view('dashboard')->with([
            'campaign' => $currentCampaign
        ]);
    }
}
