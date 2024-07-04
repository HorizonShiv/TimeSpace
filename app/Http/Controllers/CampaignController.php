<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignLanguages;
use App\Models\CampaignMember;
use App\Models\FlightConnection;
use App\Models\Assets;
use App\Models\Thumbnails;
use App\Models\User;
use App\Models\AssetParameters;
use Illuminate\Support\Facades\DB;
use App\Models\AdvertisementType;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Campaigns = Campaign::with('CampaignLanguages', 'CampaignMember')->get();
        $Campaign_id = Campaign::with('CampaignLanguages', 'CampaignMember')->pluck('id');
        foreach ($Campaigns as $Campaign) {
            $campaign_id = $Campaign->id;
        }

        $assetStatusCount = AssetParameters::with('Campaign')
            ->whereIn('campaign_id', $Campaign_id)
            ->select('status', DB::raw('count(*) as status_count'))
            ->groupBy('status')
            ->get();
            

        // dd($assetStatusCount);

        return view('dashboard.index', compact('Campaigns', 'assetStatusCount'));
    }
    public function assetsManage($id, $lang, $type)
    {
        // return view('campaign-visualview-awarness');
        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster')->where('id', $id)->first();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();
        $language = $lang;
        $FlightConnection = FlightConnection::with('Assets')->where('campaign_id', $id)->where('language', $lang)->where('type', $type)->get();

        // $FlightConnections = $FlightConnection->toArray();
        // dd($FlightConnection->toArray());
        return view('asset.manage', compact('FlightConnection', 'Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type'));
    }
    public function redirectsummery()
    {
        // return view('summery');
    }

    public function AssetsBuilder($id, $lang, $type, $Adtype)
    {
        $Campaign = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster')->where('id', $id)->first();

        $FlightCount = $Campaign->Flight->count();
        $AssetsCount = $Campaign->Assets->count();

        $language = $lang;

        $FlightConnection = FlightConnection::with([
            'Assets' => function ($query) use ($Adtype) {
                $query->where('advertisement_id', $Adtype);
            },
            'Assets.AssetParameters'
        ])->where('campaign_id', $id)
            ->where('language', $lang)
            ->where('type', $type)
            ->whereHas('Assets', function ($query) use ($Adtype) {
                $query->where('advertisement_id', $Adtype);
            })
            ->get();

        // dd($FlightConnection->AssetParameters);
        return view('asset.build', compact('FlightConnection', 'Campaign', 'FlightCount', 'AssetsCount', 'id', 'language', 'type'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $Clients = User::with('Team')->where('type', 'Client')->groupBy('team_id')->get();
        $Clients = User::with('Team')->select('team_id')->where('type', 'Client')->groupBy('team_id')->get();
        // dd($Clients);

        $Users = User::where('type', 'User')->get();

        return view('campaign.add', compact('Clients', 'Users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate(request(), [
            'Client' => 'required',
            'CampaignName' => 'required',
            // 'Languages' => 'required',
            // 'projectCode' => 'required',
            // 'CampaignImage' => 'required',
            // 'Budget' => 'required',
            'TeamMember' => 'required',
        ]);
        $string = '';

        // dd($request->toArray());

        if ($request->exClient) {
            $string .= $request->exClient . '_';
        }

        if ($request->exLanguage) {
            $string .= $request->exLanguage . '_';
        }

        if ($request->exTarget) {
            $string .= $request->exTarget . '_';
        }

        if ($request->exRegion) {
            $string .= $request->exRegion . '_';
        }

        if ($request->exPublisher) {
            $string .= $request->exPublisher . '_';
        }

        if ($request->exAdtype) {
            $string .= $request->exAdtype;
        }

        // Remove trailing underscore if present
        $string = rtrim($string, '_');
        // $string .= '.jpg';

        // $Lang = [];

        $Campaign = new Campaign([
            'client_id' => $request->Client,
            'campaign_name' => $request->CampaignName,
            'project_code' => $request->projectCode,
            'export_name' => $string,
            'budget' => $request->Budget,
        ]);

        if ($Campaign->save()) {
            $CampaignId = $Campaign->id;
            $CampaignName = $Campaign->campaign_name;
            $CampaignCode = $Campaign->project_code;
            $CampaignBudget = $Campaign->budget;

            $Languages = $request->Languages;
            foreach ($Languages as $lang) {
                $CampaignLanguages = new CampaignLanguages([
                    'campaign_id' => $CampaignId,
                    'language' => $lang,
                ]);
                $CampaignLanguages->save();
            }
            ;
            // $Lang[]=$CampaignLanguages->language;

            // if ($request->CampaignImage) {
            //     $this->validate(request(), [
            //         'CampaignImage.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
            //     ]);
            //     $file = $request->CampaignImage;
            //     $file_name = $file->getClientOriginalName();
            //     $new_file_name = str_replace(' ', '-', $file_name);
            //     $destination_path = public_path('/campaignHeaderImage/' . $CampaignId . '/');
            //     if (!is_dir(public_path('/campaignHeaderImage'))) {
            //         mkdir(public_path('/campaignHeaderImage'), 0755, true);
            //     }
            //     $file->move($destination_path, $new_file_name);

            //     Campaign::where('id', $CampaignId)->update([
            //         "image" => $new_file_name,
            //     ]);
            // }

            foreach ($request->TeamMember as $teamMember) {
                $CampaignMember = new CampaignMember([
                    'campaign_id' => $CampaignId,
                    'user_id' => $teamMember,
                ]);
                $CampaignMember->save();
            }

            $success = 'Successfully Added';
            $id = $CampaignId;
            return redirect()->action([FlightController::class, 'create'], compact('id'));
        } else {
            $error = 'Failed';
            return redirect()->action([CampaignController::class, 'index'], compact('error'));
        }
    }

    // public function assetsStatus() {

    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Campaigns = Campaign::with('CampaignLanguages', 'CampaignMember', 'Flight.FlightConnection.CategoryMaster', 'Assets.AdvertisementType.CategoryMaster', 'Assets.PublisherMaster')->where('id', $id)->first();

        $campaign_id = $id;
        $AssetsCount = AssetParameters::with('Campaign')->where('campaign_id', $id)->count();

        $flightId = $Campaigns->Flight[0]->id;
        $assetStatusCount = AssetParameters::with('Campaign')
            ->where('campaign_id', $id)
            ->select('status', DB::raw('count(*) as status_count'))
            ->groupBy('status')
            ->get();
        // dd($assetStatusCount);
        // dd($assetStatusCount);

        $FlightCount = $Campaigns->Flight->count();
        $AssetsCount = $Campaigns->Assets->count();
        // $assetStatusCount = $Campaigns->AssetParameter->Status->count();
        // dd($Campaigns->Assets);
        $enCounts = [
            'Awareness' => 0,
            'Consideration' => 0,
            'Trail' => 0
        ];

        $frCounts = [
            'Awareness' => 0,
            'Consideration' => 0,
            'Trail' => 0
        ];

        foreach ($Campaigns->Flight as $Flights) {
            foreach ($Flights->FlightConnection as $Connection) {
                foreach ($Campaigns->Assets as $Asset) {
                    if ($Asset->flight_id == $Flights->id && $Asset->flight_connection_id == $Connection->id) {
                        if ($Connection->language === 'EN') {
                            switch ($Connection->type) {
                                case 'Awareness':
                                    $enCounts['Awareness']++;
                                    break;
                                case 'Consideration':
                                    $enCounts['Consideration']++;
                                    break;
                                case 'Trail':
                                    $enCounts['Trail']++;
                                    break;
                            }
                        } elseif ($Connection->language === 'FR') {
                            switch ($Connection->type) {
                                case 'Awareness':
                                    $frCounts['Awareness']++;
                                    break;
                                case 'Consideration':
                                    $frCounts['Consideration']++;
                                    break;
                                case 'Trail':
                                    $frCounts['Trail']++;
                                    break;
                            }
                        }
                    }
                }
            }
        }

        // $FlightCount=NULL;
        // $Campaigns = $CampaignData->toArray();
        // dd($Campaigns->Assets);
        return view('campaign.dashboard', compact('Campaigns', 'FlightCount', 'AssetsCount', 'enCounts', 'frCounts', 'assetStatusCount', 'flightId'));
    }

    public function AssetsStatus(string $id)
    {

        $statusCounts = AssetParameters::select('flight_id', 'status', DB::raw('count(*) as count'))
            ->where('campaign_id', $id)
            ->whereIn('status', ['briefed', 'draft', 'progress', 'review', 'approved', 'trafficking', 'live'])
            ->groupBy('flight_id', 'status')
            ->get();

        return view('campaign.dashboard', compact('assetsStatusCount'));
    }


    public function imageUpdate(Request $request)
    {
        // dd($request->campaignId);
        $Campaign = $request->campaignId;

        if ($request->imageUpload) {
            $this->validate(request(), [
                'imageUpload.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
            ]);
            $file = $request->imageUpload;
            $file_name = $file->getClientOriginalName();
            // $file_name = 'SPForAccountBlack.png';
            $new_file_name = str_replace(' ', '-', $file_name);
            $destination_path = public_path('/campaignHeaderImage/' . $Campaign . '/');
            if (!is_dir(public_path('/campaignHeaderImage'))) {
                mkdir(public_path('/campaignHeaderImage'), 0755, true);
            }
            $file->move($destination_path, $new_file_name);

            Campaign::where('id', $Campaign)->update([
                "image" => $new_file_name,
            ]);

            return response()->json(['success' => true]);
        }
    }

    public function imageUpdateTragetThumbnail(Request $request)
    {
        // dd($request->campaignId);
        $Campaign = $request->campaignId;

        $Thumbnails = Thumbnails::where('campaign_id', $Campaign)->where('type', $request->type)->first();

        // dd($Thumbnails);

        if ($request->imageUpload) {
            $this->validate(request(), [
                'imageUpload.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
            ]);
            $file = $request->imageUpload;
            $file_name = $file->getClientOriginalName();
            // $file_name = 'SPForAccountBlack.png';
            $new_file_name = str_replace(' ', '-', $file_name);
            $destination_path = public_path('/Thumbnails/' . $Campaign . '/');
            if (!is_dir(public_path('/Thumbnails'))) {
                mkdir(public_path('/Thumbnails'), 0755, true);
            }
            $file->move($destination_path, $new_file_name);

            if (!empty($Thumbnails)) {
                Thumbnails::where('id', $Campaign)->where('type', $request->type)->where('language', $request->language)->update([
                    "thumbnail" => $new_file_name,
                ]);
            } else {
                $Thumbnails = new Thumbnails([
                    'campaign_id' => $Campaign,
                    'type' => $request->type,
                    'thumbnail' => $new_file_name,
                    'language' => $request->language,
                ]);
                $Thumbnails->save();
            }

            return response()->json(['success' => true]);
        }
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
    public function view(string $id)
    {
        return view('Compaign-view');
    }
}
