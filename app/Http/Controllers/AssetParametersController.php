<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\FlightConnection;
use App\Models\AssetParameters;
use App\Models\Assets;
use App\Models\AdvertisementType;
use App\Models\AsstesChangeLog;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use File;
use App\Models\notification;
use DB;
use Illuminate\Support\Facades\Log;

class AssetParametersController extends Controller
{
    public function AssetsStore(Request $request, $id, $lang, $type, $Adtype)
    {

        $userID = Auth::id();

        // dd($userID);

        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster')->where('id', $id)->first();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();
        $language = $lang;
        $FlightConnection = FlightConnection::with('Assets')->where('campaign_id', $id)->where('language', $lang)->where('type', $type)->get();
        $assetsId = $request->id;
       

        if ($request->has('statusButton')) {
            $buttonValue = $request->input('statusButton');
            if (strtolower($buttonValue) == 'briefed') {
                $statusValue = 'draft';
            } elseif (strtolower($buttonValue) == 'draft') {
                $statusValue = 'progress';
            } elseif (strtolower($buttonValue) == 'progress') {
                $statusValue = 'review';
            } elseif (strtolower($buttonValue) == 'review') {
                if ($request->changechecker == 1) {
                    $statusValue = 'progress';
                } else {
                    $statusValue = 'approved';
                }
            } elseif (strtolower($buttonValue) == 'approved') {
                $statusValue = 'trafficking';
            } elseif (strtolower($buttonValue) == 'trafficking') {
                $statusValue = 'live';
            } else {
                $statusValue = 'briefed';
            }
        } else {

            if ($request->changechecker == 1) {
                $statusValue = 'progress';
            }
        }

        // foreach ($request->AdTitle as $AssetKey => $AssetData) {
        //     $Assets = Assets::where('id', $AssetKey)->update([
        //         'ad_title' => $AssetData,
        //     ]);
        // }
        foreach ($request->ConversionLocation as $AssetKey => $AssetData) {


            if (!empty($request->AssetParametersId[$AssetKey])) {
                // if ($statusValue != 'approved' || $statusValue != 'trafficking' || $statusValue != 'live') {
                $AssetParameters = AssetParameters::where('id', $request->AssetParametersId[$AssetKey])->update([
                    // 'flight_connection_id' => $Assets->flight_connection_id,
                    // 'assets_id' => $AssetKey,
                    'ad_title' => $request->AdTitle[$AssetKey],
                    'conversion_location' => $AssetData,
                    'cta' => $request->Cta[$AssetKey] ?? null,
                    'clickthrougn_url' => $request->ClickthrougnURL[$AssetKey] ?? null,
                    'utm' => $request->Utm[$AssetKey] ?? null,
                    'primary_text' => $request->PrimaryText[$AssetKey] ?? null,
                    'headline' => $request->Headline[$AssetKey] ?? null,
                    'description' => $request->Description[$AssetKey] ?? null,
                    'link_primary_text' => $request->LinkPrimaryText[$AssetKey] ?? null,
                    'link_headline' => $request->LinkHeadline[$AssetKey] ?? null,
                    'link_description' => $request->LinkDescription[$AssetKey] ?? null,
                    'remark' => $request->remark[$AssetKey] ?? null,
                    
                ]);
                if (isset($statusValue)) {
                    $AssetParameters = AssetParameters::where('id', $request->AssetParametersId[$AssetKey])->update([
                        // 'flight_connection_id' => $Assets->flight_connection_id,
                        'status' => $statusValue,
                    ]);

                    $changeType = 'processUpdate';
                } else {
                    $changeType = 'updated';
                }

                $AsstesChangeLog = new AsstesChangeLog([
                    'assets_id' => $request->AssetParametersId[$AssetKey],
                    'user_id' => $userID,
                    'date' => date('Y-m-d'), // Format: YYYY-MM-DD
                    'type' => $statusValue,
                    'time' => date('H:i:s'), // Format: HH:MM:SS
                    'remarks' => $request->remark[$AssetKey] ?? '',

                ]);

                $AsstesChangeLog->save();
                
                $assets = AssetParameters::where('id', $request->AssetParametersId[$AssetKey])->first();
                $flights = assets::where('id', $assets->assets_id)->first();
                $Adtype = $request->Adtype;
                $team_id = Auth::user()->team_id;
               

                $notification = new notification([
                    'campaign_id' => $request->id,
                    'flight_id' => $flights->flight_id,
                    'advertisement_id' => $Adtype,
                    'flight_connection_id' => $flights->flight_connection_id,
                    'assets_id' => $request->AssetParametersId[$AssetKey],
                    'user_id' => $userID,
                    'team_id' => $team_id,
                    'status_from' => $request->status_from,
                    'status_to' => $statusValue,
                    'remarks' => $request->remark[$AssetKey] ?? '',
                ]);

                $notification->save();

                // $flight_connection_id = $flights->flight_connection_id;


                if (!empty($request->Visuals[$AssetKey])) {
                    foreach ($request->Visuals[$AssetKey] as $Keys => $visuals) {
                        if (!empty($visuals)) {
                            // $this->validate(request(), [
                            //     'spec_sheet.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
                            // ]);
                            $file = $visuals;
                            $file_name = $file->getClientOriginalName();
                            $new_file_name = str_replace(' ', '-', $file_name);
                            $destination_path = public_path('/Visuals/' . $request->AssetParametersId[$AssetKey] . '/');
                            if (!is_dir(public_path('/Visuals'))) {
                                mkdir(public_path('/Visuals'), 0755, true);
                            }
                            $file->move($destination_path, $new_file_name);

                            if ($Keys == 0) {
                                AssetParameters::where('id', $request->AssetParametersId[$AssetKey])->update([
                                    "visuals" => $new_file_name,
                                ]);
                            }
                        }
                    }
                }
                // }
            } else {

                $assets = Assets::where('id', $request->assetsId)->first();
                // dd($assets->flight_id);
                // $flight_id = $assets->flight_id;
                // dd($assets->flight_id);

                $AssetParameters = new AssetParameters([
                    'flight_id' => $assets->flight_id,
                    'campaign_id' => $request->id,
                    'flight_connection_id' => $assets->flightConnectionId,
                    'assets_id' => $request->assetsId,
                    'ad_title' => $request->AdTitle[$AssetKey],
                    'conversion_location' => $AssetData,
                    'cta' => $request->Cta[$AssetKey] ?? null,
                    'clickthrougn_url' => $request->ClickthrougnURL[$AssetKey] ?? null,
                    'utm' => $request->Utm[$AssetKey] ?? null,
                    'primary_text' => $request->PrimaryText[$AssetKey] ?? null,
                    'headline' => $request->Headline[$AssetKey] ?? null,
                    'description' => $request->Description[$AssetKey] ?? null,
                    'link_primary_text' => $request->LinkPrimaryText[$AssetKey] ?? null,
                    'link_headline' => $request->LinkHeadline[$AssetKey] ?? null,
                    'link_description' => $request->LinkDescription[$AssetKey] ?? null,
                    'status' => $statusValue ?? 'briefed',
                ]);
                $AssetParameters->save();
                
                if (!empty($request->Visuals[$AssetKey])) {
                    foreach ($request->Visuals[$AssetKey] as $Keys => $visuals) {
                        if (!empty($visuals)) {
                            // $this->validate(request(), [
                            //     'spec_sheet.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
                            // ]);
                            $file = $visuals;
                            $file_name = $file->getClientOriginalName();
                            $new_file_name = str_replace(' ', '-', $file_name);
                            $destination_path = public_path('/Visuals/' . $AssetParameters->id . '/');
                            if (!is_dir(public_path('/Visuals'))) {
                                mkdir(public_path('/Visuals'), 0755, true);
                            }
                            $file->move($destination_path, $new_file_name);

                            AssetParameters::where('id', $AssetParameters->id)->update([
                                "visuals" => $new_file_name,
                            ]);
                        }
                    }
                }
            }
        }


        return view('asset.manage', compact('FlightConnection', 'Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type'));
    }
    public function assetsManage($id, $lang, $type, $flight_id)
    {
        // return view('campaign-visualview-awarness');


        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster', 'Assets.AssetParameters')->where('id', $id)->first();

        $request = request();
        $flight_id = $request->flight_id;
        // $assetStatus = AssetParameters::with('Flight')->where('flight_id', $flight_id)->get();
        // $assetStatusCount = AssetParameters::where('flight_id', $flight_id)
        // ->groupBy('flight_id', 'status')
        // ->get(['flight_id', 'status']);
        // dd($assetStatusCount1);

        $statusCounts = AssetParameters::select('flight_id', 'status', DB::raw('count(*) as count'))
        ->where('flight_id', $flight_id)
        ->whereIn('status', ['briefed', 'draft', 'progress', 'review', 'approved', 'trafficking', 'live']) 
        ->groupBy('flight_id', 'status')
        ->get();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();
        $language = $lang;
        $FlightConnection = FlightConnection::with('Assets')->where('campaign_id', $id)->where('language', $lang)->where('type', $type)->get();

        // $FlightConnections = $FlightConnection->toArray();
        // dd($FlightConnection->toArray());
        return view('asset.manage', compact('FlightConnection', 'Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type', 'statusCounts'));
    }

  
    public function redirectsummery()
    {
        // return view('summery');
    }

    public function AssetsBuilder($id, $lang, $type, $Adtype, $AssetId)
    {
        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster', 'User')->where('id', $id)->first();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();


        $AdvertisementType = AdvertisementType::where('id', $Adtype)->first();
        $AdvertisementName = $AdvertisementType->name;

        $language = $lang;

        $Assets = Assets::with('AssetParameters.AsstesChangeLog.User')->where('id', $AssetId)->get();


        $fileUrls = [];

        foreach ($Assets as $AssetKey => $Asset) {
            foreach ($Asset->AssetParameters as $AssetParameter) {

                if (!empty($AssetParameter->visuals)) {
                    $directory = public_path('Visuals/' . $AssetParameter->id . '/');
                    // Check if the directory exists
                    if (!File::exists($directory)) {
                        // return view('images', ['fileUrls' => []]);
                    }
                    $files = File::files($directory);
                    foreach ($files as $file) {
                        $fileUrls[$AssetParameter->id][] = asset('Visuals/' . $AssetParameter->id . '/' . $file->getFilename());
                    }
                }
            }
        }

        return view('asset.build', compact('Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type', 'Adtype', 'fileUrls', 'Assets', 'AdvertisementName'));
    }
}
