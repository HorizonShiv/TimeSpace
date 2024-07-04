<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notification;
use App\Models\Campaign;
use App\Models\Team;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Assets;
use App\Models\AssetParameters; 

class notificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $team_id = Auth::user()->team_id;
        $notifications = notification::with(['Campaign', 'flight_connection.CategoryMaster', 'AdvertisementType', 'flight', 'AssetParameters.Assets.AdvertisementType', 'User'])
        ->where('team_id', $team_id)->get();
        // dd($notifications);

        foreach ($notifications as $notification) {
            $categoryName = $notification->flight_connection->CategoryMaster->name ?? 'N/A';
        }
        // dd($categoryName);
        $categoryName = $categoryName ?? 'N/A';

        // $user_id = Auth::user()->id; 
        $team_id = Auth::user()->team_id;
        $user_name = Auth::user()->name;
        return view('notification.index', compact('notifications', 'user_name', 'categoryName'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $campaign = campaign::with(['CampaignLanguages', 'CampaignMember', 'User', 'team', 'Flight', 'FlightConnection', 'Assets'])->get();

        $user_id = Auth::user()->id; 
        dd($user_id);

        $team_id = $campaign->client_id->team_id;
        return view('notification.index', compact('campaign', 'user_id'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
