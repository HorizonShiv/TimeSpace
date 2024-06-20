<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\FlightConnection;
use App\Models\AssetParameters;
use App\Models\Assets;
use App\Models\AsstesChangeLog;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use File;

class AssetParametersController extends Controller
{
    public function AssetsStore(Request $request, $id, $lang, $type, $Adtype)
    {
        // dd($request->all());

        $userID = Auth::id();

        // dd($userID);

        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster')->where('id', $id)->first();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();
        $language = $lang;
        $FlightConnection = FlightConnection::with('Assets')->where('campaign_id', $id)->where('language', $lang)->where('type', $type)->get();

        if ($request->has('statusButton')) {
            $buttonValue = $request->input('statusButton');
            if (strtolower($buttonValue) == 'briefed') {
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

        foreach ($request->AdTitle as $AssetKey => $AssetData) {
            $Assets = Assets::where('id', $AssetKey)->update([
                'ad_title' => $AssetData,
            ]);
        }
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
                    'type' => $changeType,
                    'time' => date('H:i:s'), // Format: HH:MM:SS

                ]);

                $AsstesChangeLog->save();

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
                $AssetParameters = new AssetParameters([
                    // 'flight_connection_id' => $Assets->flight_connection_id,
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


        return view('campaign-assets-manage', compact('FlightConnection', 'Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type'));
    }
    public function assetsManage($id, $lang, $type, $flight_id)
    {
        // return view('campaign-visualview-awarness');


        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster')->where('id', $id)->first();

        // $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster')
        //     ->whereHas('Flight', function ($query) use ($flight_id) {
        //         $query->where('id', $flight_id);
        //     })
        //     ->first();

        // dd($Campaign);

        // $Campaign = Campaign::with([
        //     'CampaignLanguages',
        //     'CampaignMember',
        //     'Flight.FlightConnection.CategoryMaster',
        //     'Assets.AdvertisementType.CategoryMaster',
        //     'Assets.PublisherMaster'
        // ])
        //     ->whereHas('Flight', function ($query) use ($flight_id) {
        //         $query->where('id', $flight_id);
        //     })
        //     ->first();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();
        $language = $lang;
        $FlightConnection = FlightConnection::with('Assets')->where('campaign_id', $id)->where('language', $lang)->where('type', $type)->get();

        // $FlightConnections = $FlightConnection->toArray();
        // dd($FlightConnection->toArray());
        return view('campaign-assets-manage', compact('FlightConnection', 'Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type'));
    }
    public function redirectCampaignSummery()
    {
        // return view('campaignSummery');
    }

    public function AssetsBuilder($id, $lang, $type, $Adtype, $AssetId)
    {
        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster', 'User')->where('id', $id)->first();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();

        $language = $lang;

        $Assets = Assets::with('AssetParameters.AsstesChangeLog.User')->where('id', $AssetId)->get();

        // dd($Assets);

        // $FlightConnection = FlightConnection::with([
        //     'Assets' => function ($query) use ($Adtype) {
        //         $query->where('advertisement_id', $Adtype);
        //     },
        //     'Assets.AssetParameters'
        // ])->where('campaign_id', $id)
        //     ->where('language', $lang)
        //     ->where('type', $type)
        //     ->whereHas('Assets', function ($query) use ($Adtype) {
        //         $query->where('advertisement_id', $Adtype);
        //     })
        //     ->get();

        // dd($Asset);

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
        // dd($fileUrls);

        // dd($FlightConnection->Assets->AssetParameters);
        // foreach ($FlightConnection as $FlightConnectionKey => $Connection) {
        //     foreach ($Connection->Assets as $AssetKey => $Asset) {
        //         if (!empty($Asset->AssetParameters->visuals)) {
        //             $directory = public_path('Visuals/' . $Asset->AssetParameters->id . '/');
        //             // Check if the directory exists
        //             if (!File::exists($directory)) {
        //                 // return view('images', ['fileUrls' => []]);
        //             }
        //             $files = File::files($directory);
        //             foreach ($files as $file) {
        //                 $fileUrls[$Asset->AssetParameters->id][] = asset('Visuals/' . $Asset->AssetParameters->id . '/' . $file->getFilename());
        //             }
        //         }
        //     }
        // }
        return view('assets-builder', compact('Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type', 'Adtype', 'fileUrls', 'Assets'));
    }
}
