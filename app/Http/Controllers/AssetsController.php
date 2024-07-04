<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignLanguages;
use App\Models\Campaign;
use App\Models\CampaignMember;
use App\Models\Flight;
use App\Models\FlightConnection;
use App\Models\AdvertisementType;
use App\Models\CategoryMaster;
use App\Models\Assets;
use App\Models\AssestSetup;
use App\Models\PublisherMaster;
use App\Helpers\Helpers;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd($request->toArray());
        $CampaignData = Campaign::with("Flight", "FlightConnection")->where('id', $request->campaign)->get();
        return view('asset.add', compact('CampaignData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $Campaigns = Campaign::with("Flight.FlightConnection")->where('id', $request->CampaignId)->first();
        $id = $request->CampaignId;

        // dd($Campaigns);
        $oldId = 0;
        foreach ($Campaigns->Flight as $Flights) {
            $FlightId = $Flights->id;

            foreach ($Flights->FlightConnection as $Connection) {
                $ConnectionId = $Connection->id;
                $lang = $Connection->language;
                $type = $Connection->type;
                // foreach ($Campaign->AdvertisementType as $AdType) {
                $AdtypeId = $Connection->category_id;
                // $CategroryId = $Connection->AdvertisementType->category_master_id;
                foreach ($request->AdPublisher[$FlightId][$ConnectionId][$lang][$type][$AdtypeId] as $indexKey => $data) {

                    // dd($request->AdType);
                    $Assets = new Assets([
                        'campaign_id' => $request->CampaignId,
                        'flight_id' => $FlightId,
                        'flight_connection_id' => $Connection->id,
                        'category_id' => $AdtypeId,
                        'publisher_id' => $data,
                        'advertisement_id' => $request->AdType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_format' => $request->AdFormate[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_size' => $request->AdSize[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_bleed' => $request->AdBleed[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_colour' => $request->AdColour[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_kbs' => $request->AdKbs[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_duration' => $request->AdDuration[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_filetype' => $request->AdFileType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_version' => $request->AdVersion[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_publisher_specs' => $request->AdPublisherSpecs[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'due_to_publisher' => $request->AdDate[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    ]);
                    $Assets->save();
                    $success = 'Successfully Added';

                    // $AssestSetup = new AssestSetup([
                    //     'campaign_id' => $request->CampaignId,
                    //     'flight_id' => $FlightId,
                    //     'flight_connection_id' => $Connection->id,
                    //     'category_id' => $AdtypeId,
                    //     'publisher_id' => $data,
                    //     'advertisement_id' => $request->AdType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_format' => $request->AdFormate[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_size' => $request->AdSize[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_bleed' => $request->AdBleed[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_colour' => $request->AdColour[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_kbs' => $request->AdKbs[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_duration' => $request->AdDuration[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_filetype' => $request->AdFileType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_version' => $request->AdVersion[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                    //     'ad_publisher_specs' => $request->AdPublisherSpecs[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,

                    // ]);
                    // $AssestSetup->save();
                    // $success = 'Successfully Added';
                }
            }
        }

        // return view('campaign.dashboard', compact('Campaigns', 'id', 'success'));
        // return redirect()->action([TeamController::class, 'managePeople'], compact('success'));
        return redirect()->route('campaign-show', ['id' => $id, 'success' => $success]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function AssetsSetup(string $id)
    {
        $CampaignData = Campaign::with("Flight.FlightConnection.CategoryMaster")->where('id', $id)->first();

        $html = [];
        $tags = [];
        $htmlFieldName = '';
        $htmlField = '';
        $htmlData = '';
        $CategoryName = '';

        $OldId = '0';
        $temp = 0;
        foreach ($CampaignData->Flight as $Flights) {
            $FlightConnectionData = $Flights->FlightConnection->groupBy('tag');
            foreach ($FlightConnectionData as $flightsConnections) {
                foreach ($flightsConnections as $Connection) {
                    $AdvertisementType = AdvertisementType::where('category_master_id', $Connection->category_id)->get();

                    $tags[$Flights->id][$Connection->language][$Connection->type][$Connection->tag][] = $Connection->CategoryMaster->name . '_' . $Connection->CategoryMaster->id;

                    if (strtolower($Connection->CategoryMaster->name) == 'social') {

                        $CategoryName = 'social';

                        $PublisherMaster = PublisherMaster::where('category_id', $Connection->category_id)->get();
                        $htmlFieldName .= '<p class="text-base font-normal w-32"
                        input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';
                        $htmlField .= '<select id="publisher_' . $Connection->CategoryMaster->id . '_' . $temp . '" onchange="getPublisherAdType(' . $Connection->CategoryMaster->id . ',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option selected disabled>Select Publisher</option>';
                        foreach ($PublisherMaster as $Publisher) {
                            $htmlField .= '<option value="' . $Publisher->id . '">' . $Publisher->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';


                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';

                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }
                    if (strtolower($Connection->CategoryMaster->name) == 'print') {
                        $CategoryName = 'print';
                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }

                    if (strtolower($Connection->CategoryMaster->name) == 'radio') {
                        $CategoryName = 'radio';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }

                    if (strtolower($Connection->CategoryMaster->name) == 'television') {
                        $CategoryName = 'television';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }
                    if (strtolower($Connection->CategoryMaster->name) == 'broadcast') {
                        $CategoryName = 'broadcast';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }

                    if (strtolower($Connection->CategoryMaster->name) == 'outdoor') {
                        $CategoryName = 'outdoor';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }

                    if (strtolower($Connection->CategoryMaster->name) == 'display') {
                        $CategoryName = 'display';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }
                    if (strtolower($Connection->CategoryMaster->name) == 'podcast') {
                        $CategoryName = 'podcast';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }

                    if (strtolower($Connection->CategoryMaster->name) == 'influencer') {
                        $CategoryName = 'influencer';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                        $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                        $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Flights->id . ',' . $Connection->id . ',\'' . $Connection->language . '\',\'' . $Connection->type . '\',' . $Connection->CategoryMaster->id . ',\'' . $Connection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
                        $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                        foreach ($AdvertisementType as $Ads) {
                            $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                        }
                        $htmlField .= '</select>';

                        $htmlData .= '<input type="date" value="" name="AdDate[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlData'] = $htmlData;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['categoryName'] = $CategoryName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                        $html[$Flights->id][$Connection->id][$Connection->language][$Connection->type][$Connection->CategoryMaster->id]['htmlField'] = $htmlField;
                        $htmlFieldName = "";
                        $htmlField = "";
                        $htmlData = "";
                        $CategoryName = "";
                        $temp++;
                    }
                }
            }
        }
        // dd($html);

        return view('asset.add', compact('CampaignData', 'html', 'id', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function fetchAdvertisementTypes($categoryMasterId)
    {
        $advertisementTypes = AdvertisementType::where('category_master_id', $categoryMasterId)->get();
        return response()->json($advertisementTypes);
    }
    public function edit(string $id)
    {
        //
        // $CampaignData = Campaign::with("Flight.FlightConnection.AdvertisementType", 'Assets')->where('id', $id)->first();
        $CampaignData = Campaign::with("Flight.FlightConnection.CategoryMaster", 'Flight.FlightConnection.Assets')->where('id', $id)->first();




        // dd($CampaignData->toArray());
        $html = [];
        $tags = [];
        $htmlFieldName = '';
        $htmlField = '';
        $htmlData = '';

        $newhtmlFieldName = '';
        $newhtmlField = '';
        $newhtmlData = '';

        $OldId = '0';
        $temp = 0;
        $t = 0;

        foreach ($CampaignData->Flight as $Flight) {
            if (!empty($Flight->FlightConnection)) {

                foreach ($Flight->FlightConnection as $FlightConnection) {
                    $tempArrayChecker = $Flight->FlightConnection->toArray();
                    $tags[$Flight->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->tag][] = $FlightConnection->CategoryMaster->name . '_' . $FlightConnection->CategoryMaster->id;
                    // dd($FlightConnection->Assets->isNotEmpty());
                    if ($FlightConnection->Assets->isNotEmpty()) {
                        $t++;
                        foreach ($FlightConnection->Assets as $Asset) {

                            $Category = CategoryMaster::where('id', $Asset->category_id)->first();
                            $AdvertisementTypeSelected = AdvertisementType::where('id', $Asset->advertisement_id)->first();
                            // dd($AdvertisementTypeSelected->toArray());

                            $FlightConnection = FlightConnection::where('id', $Asset->flight_connection_id)->first();


                            $AllPublisherCategory = PublisherMaster::where('category_id', $Asset->category_id)->get();
                            $AdvertisementType = AdvertisementType::where('category_master_id', $Asset->category_id)->get();


                            if (strtolower($Category->name) == 'social') {
                                if (is_numeric($Asset->publisher_id)) {
                                    $PublisherMaster = PublisherMaster::where('id', $Asset->publisher_id)->first();
                                }
                                $CategoryName = 'social';

                                // dd($AdvertisementTypeSelected->name);

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                // $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';
                                $htmlField .= '<select id="publisher_' . $Asset->flight_connection_id . '" onchange="getPublisherAdType(' . $Asset->flight_connection_id . ')" class="select select-primary w-32 rounded-md" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                foreach ($AllPublisherCategory as $Publisher) {
                                    $htmlField .= '<option ' . ($Asset->publisher_id == $Publisher->id ? 'selected' : '')  . ' value="' . $Publisher->id . '">' . $Publisher->name . '</option>';
                                }
                                $htmlField .= '</select>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';

                                if (strtolower($PublisherMaster->name) == 'meta') {
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb video feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                                <option value="4:5">4:5</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb stories') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb reels') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb ads on reels') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta profile feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta stories') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta reels') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'carousel') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'collection') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }
                                }

                                if (strtolower($PublisherMaster->name) == 'pinterest') {

                                    if (strtolower($AdvertisementTypeSelected->name) == 'standard image') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="2:3"> 2:3</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'standard video') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'max video') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                                <option value="16:9">16:9</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'carousel ads') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                                <option value="2:3">2:3</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'shopping ads') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="2:3">2:3</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'collections ads') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                                <option value="2:3">2:3</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'lead ads') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="2:3">2:3</option>
                                            </select>';
                                    }
                                }

                                if (strtolower($PublisherMaster->name) == 'tiktok') {
                                    if (strtolower($AdvertisementTypeSelected->name) == 'image') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'video') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'spark') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'pangle') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'playable') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'carousel') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'topview') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'dynamic showcase') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                }

                                if (strtolower($PublisherMaster->name) == 'snapchat') {

                                    if (strtolower($AdvertisementTypeSelected->name) == 'image') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'video') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }

                                    if (strtolower($AdvertisementTypeSelected->name) == 'collection') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'story') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                }

                                if (strtolower($PublisherMaster->name) == 'linkedin') {
                                    if (strtolower($AdvertisementTypeSelected->name) == 'carousel') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'conversation') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }

                                    if (strtolower($AdvertisementTypeSelected->name) == 'event') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'follower') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'lead gen') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'message') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'ingle image') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'spotlight') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'text') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'video') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="9:16">9:16</option>
                                            </select>';
                                    }
                                }

                                if (strtolower($PublisherMaster->name) == 'x') {

                                    if (strtolower($AdvertisementTypeSelected->name) == 'text') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option selected value="N/A">N/A</option>
                                            </select>';
                                    }

                                    if (strtolower($AdvertisementTypeSelected->name) == 'image') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="16:09">16:09</option>
                                            </select>';
                                    }

                                    if (strtolower($AdvertisementTypeSelected->name) == 'video') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }

                                    if (strtolower($AdvertisementTypeSelected->name) == 'carousel') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }

                                    if (strtolower($AdvertisementTypeSelected->name) == 'moment') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                <option value="1:1">1:1</option>
                                            </select>';
                                    }
                                }


                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Duration</p>
                                <p class="text-base font-normal w-32" >Versions</p>
                                ';

                                $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="' . $Asset->ad_duration . '" name="AdDuration[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="[# value]" type="text" value="' . $Asset->ad_version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';

                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            } elseif (strtolower($Category->name) == 'print') {

                                $CategoryName = 'print';
                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';


                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                                <p class="text-base font-normal w-32" >Ad Size</p>
                                <p class="text-base font-normal w-32" >Bleed</p>
                                <p class="text-base font-normal w-32" >Colour</p>
                                <p class="text-base font-normal w-32" >File Type</p>
                                <p class="text-base font-normal w-32" >Versions</p>
                                <p class="text-base font-normal w-32" >Publisher Specs</p>
                                ';

                                $htmlField .= '<input placeholder="eg. 1/4p, 1/2p, Full Page" type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="Width x Height (inches/mm) @Resolution" type="text" value="' . $Asset->ad_size . '" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. 0125", N/A" type="text" value="' . $Asset->ad_bleed . '" name="AdBleed[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. CMYK, K" type="text" value="' . $Asset->ad_colour . '" name="AdColour[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="' . $Asset->ad_filetype . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="[# value]" type="text" value="' . $Asset->ad_version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="Provide link to specs" value="' . $Asset->ad_publisher_specs . '" type="text" name="AdPublisherSpecs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            } elseif (strtolower($Category->name) == 'radio') {
                                $CategoryName = 'radio';
                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->file_type . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                                $htmlField .= '<input required type="number" value="' . $Asset->version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            } elseif (strtolower($Category->name) == 'television') {
                                $CategoryName = 'television';
                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size</p>';
                                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->ad_size == 'metric' ? 'selected' : '')  . ' value="metric">metric</option>
                                                    <option ' . ($Asset->ad_size == 'imperial' ? 'selected' : '')  . ' value="imperial">imperial</option>
                                                    <option ' . ($Asset->ad_size == 'etc' ? 'selected' : '')  . ' value="etc">etc</option>
                                                </select>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Resolution</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->resolution . '" name="AdResolution[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->file_type . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                                $htmlField .= '<input required type="number" value="' . $Asset->version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            } elseif (strtolower($Category->name) == 'broadcast') {

                                $CategoryName = 'broadcast';
                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';


                                if (strtolower($AdvertisementType->name) == 'tv :30s' || strtolower($AdvertisementType->name) == 'tv :15s' || strtolower($AdvertisementType->name) == 'tv :05s' || strtolower($AdvertisementType->name) == 'tv other') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                                    <p class="text-base font-normal w-32" >Ad Size</p>';


                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->ad_format == $Ads->id ? '16:9' : '')  . ' value="16:9">16:9</option>
                                                        <option ' . ($Asset->ad_format == $Ads->id ? '4:3' : '')  . ' value="4:3">4:3</option>
                                                        <option ' . ($Asset->ad_format == $Ads->id ? 'N/A' : '')  . ' value="N/A">N/A</option>
                                                    </select>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->ad_format == $Ads->id ? '1080p' : '')  . ' value="1080p">1080p</option>
                                                    <option ' . ($Asset->ad_format == $Ads->id ? '2160p' : '')  . ' value="2160p">2160p</option>
                                                    <option ' . ($Asset->ad_format == $Ads->id ? '4320' : '')  . ' value="4320p">4320p</option>
                                                </select>';
                                } else {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                                    <p class="text-base font-normal w-32" >Ad Size</p>';
                                    $htmlField .= '<input readonly type="text" value="N/A" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    $htmlField .= '<input readonly type="text" value="N/A" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>
                                <p class="text-base font-normal w-32" >Versions</p>
                                <p class="text-base font-normal w-32" >Publisher Specs</p>';

                                $htmlField .= '<input type="text" placeholder="eg. AIFF, MP4, MOV" value="' . $Asset->ad_filetype . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                $htmlField .= '<input required placeholder="[# value]" type="text" value="' . $Asset->ad_version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                $htmlField .= '<input required  placeholder="Provide link to specs" value="' . $Asset->ad_publisher_specs . '" type="text" name="AdPublisherSpecs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                            } elseif (strtolower($Category->name) == 'outdoor') {
                                $CategoryName = 'outdoor';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';


                                // dd($AdvertisementTypeSelected);
                                if (strtolower($AdvertisementTypeSelected->name) == 'posters') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                    $htmlField .= '<input placeholder="eg. Vertical, Digital" type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }

                                if (strtolower($AdvertisementTypeSelected->name) == 'large format') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                    $htmlField .= '<input placeholder="eg. Super Board, Digital" type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }

                                if (strtolower($AdvertisementTypeSelected->name) == 'street furniture') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                    $htmlField .= '<input placeholder="eg. Transit, Street, Digital" type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }

                                if (strtolower($AdvertisementTypeSelected->name) == 'transit') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                    $htmlField .= '<input placeholder="eg. Bus Wrap, Subway Interior" type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }

                                if (strtolower($AdvertisementTypeSelected->name) == 'place based') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                                    $htmlField .= '<input placeholder="eg. Stadium, Airport" type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }

                                $htmlFieldName .= '
                                <p class="text-base font-normal w-32" >Ad Size</p>
                                <p class="text-base font-normal w-32" >Bleed</p>
                                <p class="text-base font-normal w-32" >Colour</p>
                                <p class="text-base font-normal w-32" >File Type</p>
                                <p class="text-base font-normal w-32" >Versions</p>
                                <p class="text-base font-normal w-32" >Publisher Specs</p>
                                ';
                                // dd($Asset->ad_bleed);

                                $htmlField .= '<input placeholder="Width x Height (inches/mm/px) @Resolution" type="text" value="' . $Asset->ad_size . '" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. 2, N/A" type="text" value="' . $Asset->ad_bleed . '" name="AdBleed[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. CMYK, RGB" type="text" value="' . $Asset->ad_colour . '" name="AdColour[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="' . $Asset->ad_filetype . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="[# value]" type="text" value="' . $Asset->ad_version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="Provide link to specs" value="' . $Asset->ad_publisher_specs . '" type="text" name="AdPublisherSpecs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            } elseif (strtolower($Category->name) == 'display') {
                                $CategoryName = 'display';
                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';
                                if (strtolower($AdvertisementTypeSelected->name) == 'billboard') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                     $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="970x250">970x250</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial 250">Initial 250</option>
                                        <option value="Subload 500">Subload 500</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'smartphone banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="300x50">300x50</option>
                                            <option value="320x50">320x50</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial 50">Initial 50</option>
                                        <option value="Subload 100">Subload 100</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'leaderboard') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="728x90">728x90</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial 150">Initial 150</option>
                                        <option value="Subload 300">Subload 300</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'pushdown') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="970x90">970x90</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial 200">Initial 200</option>
                                        <option value="Subload 400">Subload 400</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'portrait') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="300x1050">300x1050</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial 250">Initial 250</option>
                                        <option value="Subload 500">Subload 500</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'skyscraper') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="160x600">160x600</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                         <option value="Initial 150">Initial 150</option>
                                        <option value="Subload 300">Subload 300</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'medium rectangle') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="300x250">300x250</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                         <option value="Initial 150">Initial 150</option>
                                        <option value="Subload 300">Subload 300</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == '120x60') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="120x60">120x60</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial 50">Initial 50</option>
                                        <option value="Subload 100">Subload 100</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'mobile interstitial') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="640x1136">640x1136</option>
                                            <option value="750x1334">750x1334</option>
                                            <option value="1080x1920">1080x1920</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial 300">Initial 300</option>
                                        <option value="Subload 600">Subload 600</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'feature phone small banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="120x20">120x20</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial Load 5">Initial Load 5</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'feature phone med banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="168x28">168x28</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial Load 5">Initial Load 5</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'feature phone Lrg banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option value="216x36">216x36</option>
                                        </select>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option value="Initial Load 5">Initial Load 5</option>
                                    </select>';
                                }
                                if (strtolower($AdvertisementTypeSelected->name) == 'other') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                                    <p class="text-base font-normal w-32" >kB/s</p>';
                                    $htmlField .= '<input placeholder="Width x Height px" type="text" value="" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    $htmlField .= '<input placeholder="Initial Load/Subload" type="text" value="" name="AdKbs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>
                                        <p class="text-base font-normal w-32" >Version</p>
                                    <p class="text-base font-normal w-32" >Publisher Specs</p>';

                                $htmlField .= '<input placeholder="eg. JPEG, PNG, GIF" type="text" value="' . $Asset->ad_filetype . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="[# value]" value="' . $Asset->ad_version . '" type="text" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="Provide link to specs" value="' . $Asset->ad_publisher_specs . '" type="text" name="AdPublisherSpecs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            } elseif (strtolower($Category->name) == 'podcast') {
                                $CategoryName = 'podcast';
                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';

                                $htmlFieldName .= '
                                <p class="text-base font-normal w-32" >Duration</p>
                                <p class="text-base font-normal w-32" >File Type</p>
                                <p class="text-base font-normal w-32" >Versions</p>
                                <p class="text-base font-normal w-32" >Publisher Specs</p>
                                ';

                                $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="' . $Asset->ad_duration . '" name="AdDuration[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. AIFF, MP4, MOV" type="text" value="' . $Asset->ad_filetype . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="[# value]" type="text" value="' . $Asset->ad_version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="Provide link to specs" value="' . $Asset->ad_publisher_specs . '" type="text" name="AdPublisherSpecs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            } elseif (strtolower($Category->name) == 'influencer') {
                                $CategoryName = 'influencer';
                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->publisher_id . '" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                foreach ($AdvertisementType as $Ads) {
                                    $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                }
                                $htmlField .= '</select>';
                                $htmlFieldName .= '

                                ';

                                // <p class="text-base font-normal w-32" >Duration</p>
                                // <p class="text-base font-normal w-32" >File Type</p>
                                // <p class="text-base font-normal w-32" >Versions</p>
                                // <p class="text-base font-normal w-32" >Publisher Specs</p>

                                $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="' . $Asset->ad_duration . '" name="AdDuration[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="eg. AIFF, MP4, MOV" type="text" value="' . $Asset->ad_filetype . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="[# value]" type="text" value="' . $Asset->ad_version . '" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlField .= '<input placeholder="Provide link to specs" type="text" value="' . $Asset->ad_publisher_specs . '" name="AdPublisherSpecs[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlData .= '<input required type="date" value="' . $Asset->due_to_publisher . '" name="AdDate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlData'] = $htmlData;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlFieldName'] = $htmlFieldName;
                                $html[$Asset->flight_id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->category_id][$Asset->id]['htmlField'] = $htmlField;
                                $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                                $CategoryName = "";
                                $htmlFieldName = "";
                                $htmlField = "";
                                $htmlData = "";
                                $temp++;
                            }
                        }
                    } else {
                        // dd($t);
                        $AdvertisementType = AdvertisementType::where('category_master_id', $FlightConnection->category_id)->get();
                        if (strtolower($FlightConnection->CategoryMaster->name) == 'social') {

                            $CategoryName = 'social';

                            $PublisherMaster = PublisherMaster::where('category_id', $FlightConnection->category_id)->get();
                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            // $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';
                            $htmlField .= '<select id="Newpublisher_' . $FlightConnection->id . '" onchange="getPublisherAdType(' . $FlightConnection->id . ')" class="select select-primary w-32 rounded-md" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            foreach ($PublisherMaster as $Publisher) {
                                $htmlField .= '<option value="' . $Publisher->id . '">' . $Publisher->name . '</option>';
                            }
                            $htmlField .= '</select>';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';


                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input required type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';

                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }
                        if (strtolower($FlightConnection->CategoryMaster->name) == 'print') {
                            $CategoryName = 'print';
                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            $htmlField .= '<input type="text" value="" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }

                        if (strtolower($FlightConnection->CategoryMaster->name) == 'radio') {
                            $CategoryName = 'radio';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            $htmlField .= '<input type="text" value="" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';


                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input required type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }

                        if (strtolower($FlightConnection->CategoryMaster->name) == 'television') {
                            $CategoryName = 'television';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            $htmlField .= '<input type="text" value="" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input required type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }

                        if (strtolower($FlightConnection->CategoryMaster->name) == 'outdoor') {
                            $CategoryName = 'outdoor';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            $htmlField .= '<input type="text" value="" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';


                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input required type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }

                        if (strtolower($FlightConnection->CategoryMaster->name) == 'display') {
                            $CategoryName = 'display';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            $htmlField .= '<input type="text" value="" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';


                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input required type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }
                        if (strtolower($FlightConnection->CategoryMaster->name) == 'podcast') {
                            $CategoryName = 'podcast';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            $htmlField .= '<input type="text" value="" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input required type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }

                        if (strtolower($FlightConnection->CategoryMaster->name) == 'influencer') {
                            $CategoryName = 'influencer';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                            $htmlField .= '<input type="text" value="" name="NewAdPublisher[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                            $htmlField .= '<select required id="AdType_' . $temp . '" onchange="getInputFields(' . $Flight->id . ',' . $FlightConnection->id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->CategoryMaster->id . ',\'' . $FlightConnection->CategoryMaster->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="NewAdType[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" >';
                            $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                            foreach ($AdvertisementType as $Ads) {
                                $htmlField .= '<option value="' . $Ads->id . '">' . $Ads->name . '</option>';
                            }
                            $htmlField .= '</select>';

                            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
                            $htmlField .= '<input required type="number" value="" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                            $htmlData .= '<input required type="date" value="" name="NewAdDate[' . $Flight->id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte id="DueToPublisher" />';
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlData'] = $htmlData;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['categoryName'] = $CategoryName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlFieldName'] = $htmlFieldName;
                            $html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]['htmlField'] = $htmlField;
                            $htmlFieldName = "";
                            $htmlField = "";
                            $htmlData = "";
                            $CategoryName = "";
                            $temp++;
                        }
                        // dd($html[$Flight->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->CategoryMaster->id]);
                        // dd($html);
                    }
                }
            }
        }

        return view('asset.edit', compact('CampaignData', 'html', 'id', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id = '')
    {
        $Campaigns = Campaign::with("Flight.FlightConnection.CategoryMaster", 'Flight.FlightConnection.Assets')->where('id', $id)->first();
        $id = $request->CampaignId;

        foreach ($request->AdType as $FlightKey => $FlightsData) {
            foreach ($FlightsData as $FlightConnectionKey => $FlightConnectionData) {
                foreach ($FlightConnectionData as $languageKey => $languageData) {
                    foreach ($languageData as $typeKey => $typeData) {
                        foreach ($typeData as $categoryKey => $categoryDate) {
                            foreach ($categoryDate as $AssetKey => $AssetData) {
                                foreach ($AssetData as $indexKey => $Data) {
                                    $Assets = Assets::where('id', $AssetKey)->update([

                                        'campaign_id' => $request->CampaignId,
                                        'flight_id' => $FlightKey,
                                        'flight_connection_id' => $FlightConnectionKey,
                                        'category_id' => $categoryKey,
                                        'publisher_id' => $request->AdPublisher[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'advertisement_id' => $request->AdType[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_format' => $request->AdFormate[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_size' => $request->AdSize[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_bleed' => $request->AdBleed[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_colour' => $request->AdColour[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_kbs' => $request->AdKbs[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_duration' => $request->AdDuration[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_filetype' => $request->AdFileType[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_version' => $request->AdVersion[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_publisher_specs' => $request->AdPublisherSpecs[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'due_to_publisher' => $request->AdDate[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            $success = 'Successfully Updated';
        }

        // dd($success);
        if (isset($request->NewAdType)) {
            foreach ($request->NewAdType as $FlightKey => $FlightsData) {

                foreach ($FlightsData as $FlightConnectionKey => $FlightConnectionData) {

                    foreach ($FlightConnectionData as $languageKey => $languageData) {

                        foreach ($languageData as $typeKey => $typeData) {

                            foreach ($typeData as $categoryKey => $categoryDate) {

                                foreach ($categoryDate as $indexKey => $Data) {
                                    $Assets = new Assets([

                                        'campaign_id' => $request->CampaignId,
                                        'flight_id' => $FlightKey,
                                        'flight_connection_id' => $FlightConnectionKey,
                                        'category_id' => $categoryKey,
                                        'publisher_id' => $request->NewAdPublisher[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'advertisement_id' => $Data ?? NULL,
                                        'ad_format' => $request->NewAdFormate[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_size' => $request->NewAdSize[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_bleed' => $request->NewAdBleed[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_colour' => $request->NewAdColour[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_kbs' => $request->NewAdKbs[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_duration' => $request->NewAdDuration[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_filetype' => $request->NewAdFileType[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_version' => $request->NewAdVersion[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_publisher_specs' => $request->NewAdPublisherSpecs[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'due_to_publisher' => $request->NewAdDate[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                    ]);

                                    $Assets->save();
                                }
                            }
                        }
                    }
                }
            }
        }

        // processAssets($request->NewAdType);

        // return view('campaign.dashboard', compact('Campaigns', 'id', 'success'));
        // return redirect()->action([TeamController::class, 'managePeople'], compact('success'));
        return redirect()->route('campaign-show', ['id' => $id, 'success' => $success]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getPublisherAdType(Request $request)
    {
        // $categoryId = $request->input('categoryId');
        $AdvertisementType = AdvertisementType::where('publisher_master_id', $request->publisher_Id)->get();

        // dd($request->publisher_Id);

        return response()->json($AdvertisementType);
    }

    public function getInputFields(Request $request)
    {
        $htmlFieldName = '';
        $htmlField = '';
        $AdvertisementType = AdvertisementType::where('id', $request->ad_type_id)->first();


        $FlightConnection = FlightConnection::where('id', $request->flightConnectionId)->first();



        // dd($FlightConnection);


        $Category = CategoryMaster::where('id', $AdvertisementType->category_master_id)->first();


        if (strtolower($Category->name) == 'print') {
            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                <p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >Bleed</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Versions</p>
                <p class="text-base font-normal w-32" >Publisher Specs</p>
                ';

            $htmlField .= '<input placeholder="eg. 1/4p, 1/2p, Full Page" type="text" value="" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Width x Height (inches/mm) @Resolution" type="text" value="" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. 0125", N/A" type="text" value="" name="AdBleed[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. CMYK, K" type="text" value="" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="AdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'broadcast') {
            if (strtolower($AdvertisementType->name) == 'tv :30s' || strtolower($AdvertisementType->name) == 'tv :15s' || strtolower($AdvertisementType->name) == 'tv :05s' || strtolower($AdvertisementType->name) == 'tv other') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                <p class="text-base font-normal w-32" >Ad Size</p>';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="16:9">16:9</option>
                                    <option value="4:3">4:3</option>
                                    <option value="N/A">N/A</option>
                                </select>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                <option value="1080p">1080p</option>
                                <option value="2160p">2160p</option>
                                <option value="4320p">4320p</option>
                            </select>';
            } else {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                <p class="text-base font-normal w-32" >Ad Size</p>';
                $htmlField .= '<input readonly type="text" value="N/A" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input readonly type="text" value="N/A" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>';

            $htmlField .= '<input type="text" placeholder="eg. AIFF, MP4, MOV" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input required placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input required  placeholder="Provide link to specs" type="text" name="AdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'radio') {
            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Version</p>
            ';
            $htmlField .= '<input type="text" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'television') {
            $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>
            <p class="text-base font-normal w-32" >Resolution</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Version</p>
            ';
            $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="metric">metric</option>
                            <option value="imperial">imperial</option>
                            <option value="etc">etc</option>
                        </select>';

            $htmlField .= '<input type="text" name="AdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'outdoor') {

            if (strtolower($AdvertisementType->name) == 'posters') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Vertical, Digital" type="text" value="" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'large format') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Super Board, Digital" type="text" value="" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'street furniture') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Transit, Street, Digital" type="text" value="" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'transit') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Bus Wrap, Subway Interior" type="text" value="" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'place based') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Stadium, Airport" type="text" value="" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >Ad Size</p>
            <p class="text-base font-normal w-32" >Bleed</p>
            <p class="text-base font-normal w-32" >Colour</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>
            ';

            $htmlField .= '<input placeholder="Width x Height (inches/mm/px) @Resolution" type="text" value="" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. 2"", N/A" type="text" value="" name="AdBleed[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. CMYK, RGB" type="text" value="" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="AdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'display') {

            if (strtolower($AdvertisementType->name) == 'billboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x250">970x250</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 250">Initial 250</option>
                    <option value="Subload 500">Subload 500</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'smartphone banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x50">300x50</option>
                        <option value="320x50">320x50</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 50">Initial 50</option>
                    <option value="Subload 100">Subload 100</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'leaderboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="728x90">728x90</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 150">Initial 150</option>
                    <option value="Subload 300">Subload 300</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'pushdown') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x90">970x90</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 200">Initial 200</option>
                    <option value="Subload 400">Subload 400</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'portrait') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x1050">300x1050</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 250">Initial 250</option>
                    <option value="Subload 500">Subload 500</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'skyscraper') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="160x600">160x600</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                     <option value="Initial 150">Initial 150</option>
                    <option value="Subload 300">Subload 300</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'medium rectangle') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x250">300x250</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                     <option value="Initial 150">Initial 150</option>
                    <option value="Subload 300">Subload 300</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == '120x60') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x60">120x60</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 50">Initial 50</option>
                    <option value="Subload 100">Subload 100</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'mobile interstitial') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="640x1136">640x1136</option>
                        <option value="750x1334">750x1334</option>
                        <option value="1080x1920">1080x1920</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 300">Initial 300</option>
                    <option value="Subload 600">Subload 600</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone small banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x20">120x20</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial Load 5">Initial Load 5</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone med banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="168x28">168x28</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial Load 5">Initial Load 5</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone Lrg banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="216x36">216x36</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial Load 5">Initial Load 5</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'other') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<input placeholder="Width x Height px" type="text" value="" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input placeholder="Initial Load/Subload" type="text" value="" name="AdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>
                    <p class="text-base font-normal w-32" >Version</p>
                <p class="text-base font-normal w-32" >Publisher Specs</p>';

            $htmlField .= '<input placeholder="eg. JPEG, PNG, GIF" type="text" value="" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="AdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'social') {

            $PublisherMaster = PublisherMaster::where('id', $AdvertisementType->publisher_master_id)->first();

            if (strtolower($PublisherMaster->name) == 'meta') {
                if (strtolower($AdvertisementType->name) == 'fb feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb video feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="4:5">4:5</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb stories') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb reels') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb ads on reels') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta profile feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta stories') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta reels') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'collection') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'pinterest') {

                if (strtolower($AdvertisementType->name) == 'standard image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="2:3"> 2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'standard video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'max video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="16:9">16:9</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'carousel ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="2:3">2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'shopping ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="2:3">2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'collections ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="2:3">2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'lead ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="2:3">2:3</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'tiktok') {
                if (strtolower($AdvertisementType->name) == 'image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'spark') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'pangle') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'playable') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'topview') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'dynamic showcase') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'snapchat') {

                if (strtolower($AdvertisementType->name) == 'image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'collection') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'story') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'linkedin') {
                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'conversation') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'event') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'follower') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'lead gen') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'message') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'ingle image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'spotlight') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'text') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'x') {

                if (strtolower($AdvertisementType->name) == 'text') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option selected value="N/A">N/A</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="16:09">16:09</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'moment') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >Duration</p>
            <p class="text-base font-normal w-32" >Versions</p>
            ';

            $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="" name="AdDuration[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';



            //  else {
            //     $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
            //     $htmlField .= '<input type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            // }
        }
        if (strtolower($Category->name) == 'podcast') {
            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >Duration</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>
            ';

            $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="" name="AdDuration[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="AdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'influencer') {
            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >Duration</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>
            ';

            $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="" name="AdDuration[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="AdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }


        $result['htmlFieldName'] = $htmlFieldName;
        $result['htmlField'] = $htmlField;
        echo json_encode($result);
    }

    public function getEditInputFields(Request $request)
    {
        $htmlFieldName = '';
        $htmlField = '';
        $AdvertisementType = AdvertisementType::where('id', $request->ad_type_id)->first();


        $FlightConnection = FlightConnection::where('id', $request->flightConnectionId)->first();



        // dd($FlightConnection);


        $Category = CategoryMaster::where('id', $AdvertisementType->category_master_id)->first();


        if (strtolower($Category->name) == 'print') {
            $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                <p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >Bleed</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Versions</p>
                <p class="text-base font-normal w-32" >Publisher Specs</p>
                ';

            $htmlField .= '<input placeholder="eg. 1/4p, 1/2p, Full Page" type="text" value="" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Width x Height (inches/mm) @Resolution" type="text" value="" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. 0125", N/A" type="text" value="" name="NewAdBleed[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. CMYK, K" type="text" value="" name="NewAdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="NewAdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'broadcast') {
            if (strtolower($AdvertisementType->name) == 'tv :30s' || strtolower($AdvertisementType->name) == 'tv :15s' || strtolower($AdvertisementType->name) == 'tv :05s' || strtolower($AdvertisementType->name) == 'tv other') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                <p class="text-base font-normal w-32" >Ad Size</p>';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="16:9">16:9</option>
                                    <option value="4:3">4:3</option>
                                    <option value="N/A">N/A</option>
                                </select>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                <option value="1080p">1080p</option>
                                <option value="2160p">2160p</option>
                                <option value="4320p">4320p</option>
                            </select>';
            } else {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>
                <p class="text-base font-normal w-32" >Ad Size</p>';
                $htmlField .= '<input readonly type="text" value="N/A" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input readonly type="text" value="N/A" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>';

            $htmlField .= '<input type="text" placeholder="eg. AIFF, MP4, MOV" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input required placeholder="[# value]" type="text" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input required  placeholder="Provide link to specs" type="text" name="NewAdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'radio') {
            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Version</p>
            ';
            $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input type="text" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'television') {
            $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>
            <p class="text-base font-normal w-32" >Resolution</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Version</p>
            ';
            $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="metric">metric</option>
                            <option value="imperial">imperial</option>
                            <option value="etc">etc</option>
                        </select>';

            $htmlField .= '<input type="text" name="NewAdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input required type="number" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'outdoor') {

            if (strtolower($AdvertisementType->name) == 'posters') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Vertical, Digital" type="text" value="" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'large format') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Super Board, Digital" type="text" value="" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'street furniture') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Transit, Street, Digital" type="text" value="" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'transit') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Bus Wrap, Subway Interior" type="text" value="" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'place based') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                $htmlField .= '<input placeholder="eg. Stadium, Airport" type="text" value="" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >Ad Size</p>
            <p class="text-base font-normal w-32" >Bleed</p>
            <p class="text-base font-normal w-32" >Colour</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>
            ';

            $htmlField .= '<input placeholder="Width x Height (inches/mm/px) @Resolution" type="text" value="" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. 2"", N/A" type="text" value="" name="NewAdBleed[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. CMYK, RGB" type="text" value="" name="NewAdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="NewAdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'display') {

            if (strtolower($AdvertisementType->name) == 'billboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x250">970x250</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 250">Initial 250</option>
                    <option value="Subload 500">Subload 500</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'smartphone banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x50">300x50</option>
                        <option value="320x50">320x50</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 50">Initial 50</option>
                    <option value="Subload 100">Subload 100</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'leaderboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="728x90">728x90</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 150">Initial 150</option>
                    <option value="Subload 300">Subload 300</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'pushdown') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x90">970x90</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 200">Initial 200</option>
                    <option value="Subload 400">Subload 400</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'portrait') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x1050">300x1050</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 250">Initial 250</option>
                    <option value="Subload 500">Subload 500</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'skyscraper') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="160x600">160x600</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                     <option value="Initial 150">Initial 150</option>
                    <option value="Subload 300">Subload 300</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'medium rectangle') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x250">300x250</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                     <option value="Initial 150">Initial 150</option>
                    <option value="Subload 300">Subload 300</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == '120x60') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x60">120x60</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 50">Initial 50</option>
                    <option value="Subload 100">Subload 100</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'mobile interstitial') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="640x1136">640x1136</option>
                        <option value="750x1334">750x1334</option>
                        <option value="1080x1920">1080x1920</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial 300">Initial 300</option>
                    <option value="Subload 600">Subload 600</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone small banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x20">120x20</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial Load 5">Initial Load 5</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone med banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="168x28">168x28</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial Load 5">Initial Load 5</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone Lrg banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="216x36">216x36</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="Initial Load 5">Initial Load 5</option>
                </select>';
            }
            if (strtolower($AdvertisementType->name) == 'other') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Size</p>
                <p class="text-base font-normal w-32" >kB/s</p>';
                $htmlField .= '<input placeholder="Width x Height px" type="text" value="" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input placeholder="Initial Load/Subload" type="text" value="" name="NewAdKbs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>
                    <p class="text-base font-normal w-32" >Version</p>
                <p class="text-base font-normal w-32" >Publisher Specs</p>';

            $htmlField .= '<input placeholder="eg. JPEG, PNG, GIF" type="text" value="" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="AdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'social') {

            $PublisherMaster = PublisherMaster::where('id', $AdvertisementType->publisher_master_id)->first();

            if (strtolower($PublisherMaster->name) == 'meta') {
                if (strtolower($AdvertisementType->name) == 'fb feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb video feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="4:5">4:5</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb stories') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb reels') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'fb ads on reels') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta profile feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta feed') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta stories') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'insta reels') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'collection') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'pinterest') {

                if (strtolower($AdvertisementType->name) == 'standard image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="2:3"> 2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'standard video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'max video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="16:9">16:9</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'carousel ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="2:3">2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'shopping ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="2:3">2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'collections ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                            <option value="2:3">2:3</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'lead ads') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="2:3">2:3</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'tiktok') {
                if (strtolower($AdvertisementType->name) == 'image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'spark') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'pangle') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'playable') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'topview') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'dynamic showcase') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'snapchat') {

                if (strtolower($AdvertisementType->name) == 'image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'collection') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'story') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'linkedin') {
                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name=New"AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'conversation') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'event') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'follower') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'lead gen') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'message') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'ingle image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'spotlight') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'text') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="9:16">9:16</option>
                        </select>';
                }
            }

            if (strtolower($PublisherMaster->name) == 'x') {

                if (strtolower($AdvertisementType->name) == 'text') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option selected value="N/A">N/A</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'image') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="16:09">16:09</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'video') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'carousel') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }

                if (strtolower($AdvertisementType->name) == 'moment') {
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Format</p>';

                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="1:1">1:1</option>
                        </select>';
                }
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >Duration</p>
            <p class="text-base font-normal w-32" >Versions</p>
            ';

            $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="" name="NewAdDuration[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';



            //  else {
            //     $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
            //     $htmlField .= '<input type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            // }
        }
        if (strtolower($Category->name) == 'podcast') {
            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >Duration</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>
            ';

            $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="" name="NewAdDuration[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="NewAdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'influencer') {
            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >Duration</p>
            <p class="text-base font-normal w-32" >File Type</p>
            <p class="text-base font-normal w-32" >Versions</p>
            <p class="text-base font-normal w-32" >Publisher Specs</p>
            ';

            $htmlField .= '<input placeholder="eg. 6s, 15s, static" type="text" value="" name="NewAdDuration[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="eg. PDF, JPEG, PNG" type="text" value="" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="[# value]" type="text" name="NewAdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input placeholder="Provide link to specs" type="text" name="NewAdPublisherSpecs[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }


        $result['htmlFieldName'] = $htmlFieldName;
        $result['htmlField'] = $htmlField;
        echo json_encode($result);
    }
}
