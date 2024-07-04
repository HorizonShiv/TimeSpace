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
use App\Models\PublisherMaster;

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

                    $Assets = new Assets([
                        'campaign_id' => $request->CampaignId,
                        'flight_id' => $FlightId,
                        'flight_connection_id' => $Connection->id,
                        'category_id' => $AdtypeId,
                        'publisher_id' => $data,
                        'advertisement_id' => $request->AdType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_format' => $request->AdFormate[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'ad_size' => $request->AdSize[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'colour' => $request->AdColour[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'resolution' => $request->AdResolution[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'file_type' => $request->AdFileType[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'technical' => $request->AdTechnical[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'social_spec_1' => $request->AdSocialSpec1[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'social_spec_2' => $request->AdSocialSpec2[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'social_spec_3' => $request->AdSocialSpec3[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'conversion' => $request->AdConversion[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'due_to_publisher' => $request->AdDate[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? NULL,
                        'version' => $request->AdVersion[$FlightId][$ConnectionId][$lang][$type][$AdtypeId][$indexKey] ?? 1,
                    ]);
                    $Assets->save();
                    $success = 'Successfully Added';
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
            foreach ($Flights->FlightConnection as $Connection) {
                $AdvertisementType = AdvertisementType::where('category_master_id', $Connection->category_id)->get();
                // dd($AdvertisementType->toArray());
                $tags[$Flights->id][$Connection->language][$Connection->type][$Connection->tag][] = $Connection->CategoryMaster->name . '_' . $Connection->CategoryMaster->id;

                if (strtolower($Connection->CategoryMaster->name) == 'social') {

                    $CategoryName = 'social';

                    $PublisherMaster = PublisherMaster::where('category_id', $Connection->category_id)->get();
                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                    // $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';
                    $htmlField .= '<select id="publisher_' . $Connection->id . '" onchange="getPublisherAdType(' . $Connection->id . ')" class="select select-primary w-32 rounded-md" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" >';
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
                    // dd($FlightConnection->Assets->isNotEmpty());
                    if ($FlightConnection->Assets->isNotEmpty()) {
                        $t++;
                        foreach ($FlightConnection->Assets as $Asset) {
                            $Category = CategoryMaster::where('id', $Asset->category_id)->first();
                            $AdvertisementTypeSelected = AdvertisementType::where('id', $Asset->advertisement_id)->first();
                            $FlightConnection = FlightConnection::where('id', $Asset->flight_connection_id)->first();


                            $AllPublisherCategory = PublisherMaster::where('category_id', $Asset->category_id)->get();
                            $AdvertisementType = AdvertisementType::where('category_master_id', $Asset->category_id)->get();


                            // dd($PublisherMaster);
                            if (strtolower($Category->name) == 'social') {
                                if (is_numeric($Asset->publisher_id)) {
                                    $PublisherMaster = PublisherMaster::where('id', $Asset->publisher_id)->first();
                                }
                                $CategoryName = 'social';
                                if (strtolower($PublisherMaster->name) == 'meta') {

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

                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                                        <p class="text-base font-normal w-32" >Size WxH</p>
                                        <p class="text-base font-normal w-32" >File Type</p>
                                        <p class="text-base font-normal w-32" >Social Spec 1</p>
                                        <p class="text-base font-normal w-32" >Social Spec 2</p>
                                        <p class="text-base font-normal w-32" >Social Spec 3</p>
                                        <p class="text-base font-normal w-32" >Conversion</p>
                                        <p class="text-base font-normal w-32" >Version</p>
                                        ';


                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->ad_format == '1:1' ? 'selected' : '')  . ' value="1:1">1:1</option>
                                                    </select>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->ad_size == '1080x1080' ? 'selected' : '')  . ' value="1080x1080">1080x1080</option>
                                                    </select>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->file_type == 'JPEG' ? 'selected' : '')  . ' value="JPEG">JPEG</option>
                                                        <option ' . ($Asset->file_type == 'PNG' ? 'selected' : '')  . ' value="PNG">PNG</option>
                                                    </select>';


                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_1 . '" name="AdSocialSpec1[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_2 . '" name="AdSocialSpec2[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_3 . '" name="AdSocialSpec3[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->conversion . '" name="AdConversion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb video feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                                    <p class="text-base font-normal w-32" >Size WxH</p>
                                    <p class="text-base font-normal w-32" >File Type</p>
                                    <p class="text-base font-normal w-32" >Technical</p>
                                    <p class="text-base font-normal w-32" >Social Spec 1</p>
                                    <p class="text-base font-normal w-32" >Social Spec 2</p>
                                    <p class="text-base font-normal w-32" >Social Spec 3</p>
                                    <p class="text-base font-normal w-32" >Conversion</p>
                                    <p class="text-base font-normal w-32" >Version</p>
                                    ';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_format == '1:1' ? 'selected' : '')  . ' value="1:1">1:1</option>
                                            <option ' . ($Asset->ad_format == '4:5' ? 'selected' : '')  . ' value="4:5">4:5</option>
                                        </select>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option ' . ($Asset->ad_size == '1080x1080' ? 'selected' : '')  . ' value="1080x1080">1080x1080</option>
                                        <option ' . ($Asset->ad_size == '1080x1350' ? 'selected' : '')  . ' value="1080x1350">1080x1350</option>
                                    </select>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option ' . ($Asset->file_type == 'MP4' ? 'selected' : '')  . ' value="MP4">MP4</option>
                                        <option ' . ($Asset->file_type == 'MOV' ? 'selected' : '')  . ' value="MOV">MOV</option>
                                        <option ' . ($Asset->file_type == 'GIF' ? 'selected' : '')  . ' value="GIF">GIF</option>
                                    </select>';


                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                        <option ' . ($Asset->technical == '1s-241min' ? 'selected' : '')  . ' value="1s-241min">1s-241min</option>
                                        <option ' . ($Asset->technical == '4GB' ? 'selected' : '')  . ' value="4GB">4GB</option>
                                    </select>';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_1 . '" name="AdSocialSpec1[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_2 . '" name="AdSocialSpec2[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_3 . '" name="AdSocialSpec3[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->conversion . '" name="AdConversion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb stories') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_format == '9:16' ? 'selected' : '')  . '  value="9:16">9:16</option>
                                        </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb reels') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_format == '9:16' ? 'selected' : '')  . '  value="9:16">9:16</option>
                                        </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'fb ads on reels') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_format == '9:16' ? 'selected' : '')  . '  value="9:16">9:16</option>
                                        </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta profile feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->ad_format == '1:1' ? 'selected' : '')  . '  value="1:1">1:1</option>
                                                    </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta feed') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->ad_format == '1:1' ? 'selected' : '')  . '  value="1:1">1:1</option>
                                                    </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta stories') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_format == '9:16' ? 'selected' : '')  . '  value="9:16">9:16</option>
                                        </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'insta reels') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_format == '9:16' ? 'selected' : '')  . '  value="9:16">9:16</option>
                                        </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'carousel') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->ad_format == '1:1' ? 'selected' : '')  . '  value="1:1">1:1</option>
                                                    </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
                                    if (strtolower($AdvertisementTypeSelected->name) == 'collection') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p><p class="text-base font-normal w-32" >Version</p>';
                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->ad_format == '1:1' ? 'selected' : '')  . '  value="1:1">1:1</option>
                                                    </select>';

                                        $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    }
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
                                } elseif (strtolower($PublisherMaster->name) == 'pinterest') {
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

                                    if (strtolower($AdvertisementType->name) == 'standard image') {
                                        $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                                    <p class="text-base font-normal w-32" >Size WxH</p>
                                    <p class="text-base font-normal w-32" >File Type</p>
                                    <p class="text-base font-normal w-32" >Social Spec 1</p>
                                    <p class="text-base font-normal w-32" >Social Spec 2</p>
                                    <p class="text-base font-normal w-32" >Social Spec 3</p>
                                    ';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_format == '1:1' ? 'selected' : '')  . ' value="1:1">1:1</option>
                                        </select>';

                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '1080x1080' ? 'selected' : '')  . ' value="1080x1080">1080x1080</option>
                                        </select>';


                                        $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                        <option ' . ($Asset->file_type == 'JPEG' ? 'selected' : '')  . ' value="JPEG">JPEG</option>
                                                        <option ' . ($Asset->file_type == 'PNG' ? 'selected' : '')  . ' value="PNG">PNG</option>
                                                    </select>';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_1 . '" name="AdSocialSpec1[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_2 . '" name="AdSocialSpec2[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';

                                        $htmlField .= '<input type="text" value="' . $Asset->social_spec_3 . '" name="AdSocialSpec3[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md" />';
                                    }

                                    $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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
                                } elseif (strtolower($PublisherMaster->name) == 'tiktok') {
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


                                    $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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
                                } elseif (strtolower($PublisherMaster->name) == 'snapchat') {
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


                                    $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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
                                } elseif (strtolower($PublisherMaster->name) == 'x/twitter') {
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


                                    $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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
                                } elseif (strtolower($PublisherMaster->name) == 'podcast') {
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


                                    $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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
                                } elseif (strtolower($PublisherMaster->name) == 'influencer') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Publisher</p>';
                                    // $htmlField .= '<input type="text" value="" name="AdPublisher[' . $Flights->id . '][' . $Connection->id . '][' . $Connection->language . '][' . $Connection->type . '][' . $Connection->CategoryMaster->id . '][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher"  />';
                                    $htmlField .= '<select required id="publisher_' . $Asset->flight_connection_id . '" onchange="getPublisherAdType(' . $Asset->flight_connection_id . ')" class="select select-primary w-32 rounded-md" name="AdPublisher[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                    foreach ($AllPublisherCategory as $Publisher) {
                                        $htmlField .= '<option ' . ($Asset->publisher_id == $Publisher->id ? 'selected' : '')  . ' value="' . $Publisher->id . '">' . $Publisher->name . '</option>';
                                    }
                                    $htmlField .= '</select>';

                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Ad Type</p>';
                                    $htmlField .= '<select id="AdType_' . $temp . '" onchange="getInputFields(' . $Asset->flight_id . ',' . $Asset->flight_connection_id . ',\'' . $FlightConnection->language . '\',\'' . $FlightConnection->type . '\',' . $FlightConnection->category_id . ',\'' . $Category->name . '\',' . $temp . ')" class="select select-primary w-32 rounded-md" name="AdType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >';
                                    $htmlField .= '<option disabled selected data-astro-cid-jf5gi763>Select Adverstiment Type</option>';
                                    foreach ($AdvertisementType as $Ads) {
                                        $htmlField .= '<option ' . ($Asset->advertisement_id == $Ads->id ? 'selected' : '')  . ' value="' . $Ads->id . '">' . $Ads->name . '</option>';
                                    }
                                    $htmlField .= '</select>';


                                    $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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

                                if (strtolower($AdvertisementTypeSelected->name) !== 'other') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                                <p class="text-base font-normal w-32" >Size WxH</p>
                                <p class="text-base font-normal w-32" >Colour</p>
                                <p class="text-base font-normal w-32" >Resolution</p>
                                <p class="text-base font-normal w-32" >File Type</p>
                                <p class="text-base font-normal w-32" >Technical</p>
                                <p class="text-base font-normal w-32" >Version</p>
                                ';

                                    $htmlField .= '<input type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    // $htmlField .= '<input type="text" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->ad_size == 'metric' ? 'selected' : '')  . ' value="metric">metric</option>
                                                    <option ' . ($Asset->ad_size == 'imperial' ? 'selected' : '')  . ' value="imperial">imperial</option>
                                                    <option ' . ($Asset->ad_size == 'etc' ? 'selected' : '')  . ' value="etc">etc</option>
                                                </select>';

                                    // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdColour[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->colour == '4c' ? 'selected' : '')  . ' value="4c">4c</option>
                                                    <option ' . ($Asset->colour == '1c' ? 'selected' : '')  . ' value="1c">1c</option>
                                                    <option ' . ($Asset->colour == 'K' ? 'selected' : '')  . ' value="K">K</option>
                                                </select>';

                                    $htmlField .= '<input type="text" value="' . $Asset->resolution . '" name="AdResolution[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    $htmlField .= '<input type="text" value="' . $Asset->file_type . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->technical == 'bleed' ? 'selected' : '')  . ' value="bleed">Bleed</option>
                                                    <option ' . ($Asset->technical == 'safety' ? 'selected' : '')  . ' value="safety">Safety</option>
                                                </select>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                } else {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                                <p class="text-base font-normal w-32" >Colour</p>
                                <p class="text-base font-normal w-32" >Resolution</p>
                                <p class="text-base font-normal w-32" >File Type</p>
                                <p class="text-base font-normal w-32" >Technical</p>
                                <p class="text-base font-normal w-32" >Version</p>
                                ';

                                    $htmlField .= '<input type="text" value="' . $Asset->ad_format . '" name="AdFormate[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdColour[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->colour == '4c' ? 'selected' : '')  . ' value="4c">4c</option>
                                                    <option ' . ($Asset->colour == '1c' ? 'selected' : '')  . ' value="1c">1c</option>
                                                    <option ' . ($Asset->colour == 'K' ? 'selected' : '')  . ' value="K">K</option>
                                                </select>';

                                    $htmlField .= '<input type="text" value="' . $Asset->resolution . '" name="AdResolution[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    $htmlField .= '<input type="text" value="' . $Asset->file_type . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->technical == 'bleed' ? 'selected' : '')  . ' value="bleed">Bleed</option>
                                                    <option ' . ($Asset->technical == 'safety' ? 'selected' : '')  . ' value="safety">Safety</option>
                                                </select>';
                                    $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                                }




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
                                $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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

                                $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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
                                dd($AdvertisementType);
                                if (strtolower($AdvertisementType[0]->name) == 'posters') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                                <option ' . ($Asset->ad_format == 'Hor' ? 'selected' : '') . ' value="Hor">Hor</option>
                                                <option ' . ($Asset->ad_format == 'Vert' ? 'selected' : '') . '  value="Vert">Vert</option>
                                                <option ' . ($Asset->ad_format == 'Digital' ? 'selected' : '') . '  value="Digital">Digital</option>
                                            </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'large format') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                                <option ' . ($Asset->ad_format == 'Spec' ? 'selected' : '') . '  value="Spec">Spec</option>
                                                <option ' . ($Asset->ad_format == 'Super' ? 'selected' : '') . '  value="Super">Super</option>
                                                <option ' . ($Asset->ad_format == 'Wall' ? 'selected' : '') . '  value="Wall">Wall</option>
                                                <option ' . ($Asset->ad_format == 'Digital' ? 'selected' : '') . '  value="Digital">Digital</option>
                                            </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'street furniture') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                                <option ' . ($Asset->ad_format == 'Transit' ? 'selected' : '') . '  value="Transit">Transit</option>
                                                <option ' . ($Asset->ad_format == 'Bench' ? 'selected' : '') . '  value="Bench">Bench</option>
                                                <option ' . ($Asset->ad_format == 'Street' ? 'selected' : '') . '  value="Street">Street</option>
                                                <option ' . ($Asset->ad_format == 'Digital' ? 'selected' : '') . '  value="Digital">Digital</option>
                                            </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'transit') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                                <option ' . ($Asset->ad_format == 'Ext' ? 'selected' : '') . '  value="Ext">Ext</option>
                                                <option ' . ($Asset->ad_format == 'Int' ? 'selected' : '') . '  value="Int">Int</option>
                                                <option ' . ($Asset->ad_format == 'Bus' ? 'selected' : '') . '  value="Bus">Bus</option>
                                                <option ' . ($Asset->ad_format == 'Wrap' ? 'selected' : '') . '  value="Wrap">Wrap</option>
                                                <option ' . ($Asset->ad_format == 'Station' ? 'selected' : '') . '  value="Station">Station</option>
                                            </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'place based') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                                <option ' . ($Asset->ad_format == 'Stadium' ? 'selected' : '') . '  value="Stadium">Stadium</option>
                                                <option ' . ($Asset->ad_format == 'Airport' ? 'selected' : '') . '  value="Airport">Airport</option>
                                                <option ' . ($Asset->ad_format == 'etc' ? 'selected' : '') . '  value="etc">etc</option>
                                            </select>';
                                }

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->ad_format == 'metric' ? 'selected' : '')  . ' value="metric">metric</option>
                                                    <option ' . ($Asset->ad_format == 'imperial' ? 'selected' : '')  . ' value="imperial">imperial</option>
                                                    <option ' . ($Asset->ad_format == 'etc' ? 'selected' : '')  . ' value="etc">etc</option>
                                                </select>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Color</p>';
                                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdColour[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                <option ' . ($Asset->colour == '4c' ? 'selected' : '')  . ' value="4c">4c</option>
                                <option ' . ($Asset->colour == '1c' ? 'selected' : '')  . ' value="1c">1c</option>
                                <option ' . ($Asset->colour == 'K' ? 'selected' : '')  . ' value="K">K</option>
                                <option ' . ($Asset->colour == 'RGB' ? 'selected' : '')  . ' value="RGB">RGB</option>
                                    </select>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Resolution</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->resolution . '" name="AdResolution[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->file_type . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                if (strtolower($AdvertisementTypeSelected->name) !== 'place based') {
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                                    <option ' . ($Asset->technical == 'bleed' ? 'selected' : '')  . ' value="bleed">Bleed</option>
                                                    <option ' . ($Asset->technical == 'safety' ? 'selected' : '')  . ' value="safety">Safety</option>
                                                </select>';
                                }

                                $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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

                                if (strtolower($AdvertisementType->name) == 'billboard') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '970x250' ? 'selected' : '')  . ' value="970x250">970x250</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'smartphone banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '300x50' ? 'selected' : '')  . ' value="300x50">300x50</option>
                                            <option ' . ($Asset->ad_size == '320x50' ? 'selected' : '')  . ' value="320x50">320x50</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'leaderboard') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '728x90' ? 'selected' : '')  . ' value="728x90">728x90</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'pushdown') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '970x90' ? 'selected' : '')  . ' value="970x90">970x90</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'portrait') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '300x1050' ? 'selected' : '')  . ' value="300x1050">300x1050</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'skyscraper') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '160x600' ? 'selected' : '')  . ' value="160x600">160x600</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'medium rectangle') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '300x250' ? 'selected' : '')  . ' value="300x250">300x250</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == '120x60') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '120x60' ? 'selected' : '')  . ' value="120x60">120x60</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'mobile interstitial') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '640x1136' ? 'selected' : '')  . ' value="640x1136">640x1136</option>
                                            <option ' . ($Asset->ad_size == '750x1334' ? 'selected' : '')  . ' value="750x1334">750x1334</option>
                                            <option ' . ($Asset->ad_size == '1080x1920' ? 'selected' : '')  . ' value="1080x1920">1080x1920</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'feature phone small banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '120x20' ? 'selected' : '')  . ' value="120x20">120x20</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'feature phone med banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '168x28' ? 'selected' : '')  . ' value="168x28">168x28</option>
                                        </select>';
                                }
                                if (strtolower($AdvertisementType->name) == 'feature phone Lrg banner') {
                                    $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                                    $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" >
                                            <option ' . ($Asset->ad_size == '216x36' ? 'selected' : '')  . ' value="216x36">216x36</option>
                                        </select>';
                                }

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Resolution</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->resolution . '" name="AdResolution[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >File Type</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->file_type . '" name="AdFileType[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlFieldName .= '<p class="text-base font-normal w-32" >Technical</p>';
                                $htmlField .= '<input type="text" value="' . $Asset->technical . '" name="AdTechnical[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                                $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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

                                $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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


                                $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
                                $htmlField .= '<input required type="number" value="" name="AdVersion[' . $Asset->flight_id . '][' . $Asset->flight_connection_id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][' . $Asset->id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

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


                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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

                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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


                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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

                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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


                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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


                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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

                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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

                            $htmlFieldName = '<p class="text-base font-normal w-32" >Version</p>';
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

        return view('asset.edit', compact('CampaignData', 'html', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id = '')
    {
        $Campaigns = Campaign::with("Flight.FlightConnection.CategoryMaster", 'Flight.FlightConnection.Assets')->where('id', $id)->first();
        $id = $request->CampaignId;

        // $oldId = 0;
        // foreach ($Campaigns->Flight as $Flight) {
        //     $FlightId = $Flight->id;

        //     foreach ($Flight->FlightConnection as $FlightConnection) {
        //     }
        // }

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
                                        'advertisement_id' => $Data ?? NULL,
                                        'ad_format' => $request->AdFormate[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'ad_size' => $request->AdSize[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'colour' => $request->AdColour[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'resolution' => $request->AdResolution[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'file_type' => $request->AdFileType[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'technical' => $request->AdTechnical[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'social_spec_1' => $request->AdSocialSpec1[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'social_spec_2' => $request->AdSocialSpec2[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'social_spec_3' => $request->AdSocialSpec3[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
                                        'conversion' => $request->AdConversion[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$AssetKey][$indexKey] ?? NULL,
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

        if (isset($request->NewAdType)) {
            foreach ($request->NewAdType as $FlightKey => $FlightsData) {

                foreach ($FlightsData as $FlightConnectionKey => $FlightConnectionData) {

                    foreach ($FlightConnectionData as $languageKey => $languageData) {

                        foreach ($languageData as $typeKey => $typeData) {

                            foreach ($typeData as $categoryKey => $categoryDate) {

                                foreach ($categoryDate as $indexKey => $Data) {
                                    // dd($Data);
                                    $Assets = new Assets([
                                        'campaign_id' => $request->CampaignId,
                                        'flight_id' => $FlightKey,
                                        'flight_connection_id' => $FlightConnectionKey,
                                        'category_id' => $categoryKey,
                                        'publisher_id' => $request->NewAdPublisher[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'advertisement_id' => $Data ?? NULL,
                                        'ad_format' => $request->NewAdFormate[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'ad_size' => $request->NewAdSize[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'colour' => $request->NewAdColour[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'resolution' => $request->NewAdResolution[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'file_type' => $request->NewAdFileType[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'technical' => $request->NewAdTechnical[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'social_spec_1' => $request->NewAdSocialSpec1[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'social_spec_2' => $request->NewAdSocialSpec2[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'social_spec_3' => $request->NewAdSocialSpec3[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
                                        'conversion' => $request->NewAdConversion[$FlightKey][$FlightConnectionKey][$languageKey][$typeKey][$categoryKey][$indexKey] ?? NULL,
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

        // function processAssets($data)
        // {
        //     foreach ($data as $key => $value) {
        //         if (is_array($value)) {
        //             processAssets($value);
        //         } else {
        //             echo $value;
        //         }
        //     }
        // }
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
            if (strtolower($AdvertisementType->name) !== 'other') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';

                $htmlField .= '<input type="text" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                // $htmlField .= '<input type="text" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="metric">metric</option>
                                    <option value="imperial">imperial</option>
                                    <option value="etc">etc</option>
                                </select>';

                // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="4c">4c</option>
                                    <option value="1c">1c</option>
                                    <option value="K">K</option>
                                </select>';

                $htmlField .= '<input type="text" name="AdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input type="text" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="bleed">Bleed</option>
                                    <option value="safety">Safety</option>
                                </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            } else {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';

                $htmlField .= '<input type="text" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="4c">4c</option>
                                    <option value="1c">1c</option>
                                    <option value="K">K</option>
                                </select>';

                $htmlField .= '<input type="text" name="AdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input type="text" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';



                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="bleed">Bleed</option>
                                    <option value="safety">Safety</option>
                                </select>';

                $htmlField .= '<input required type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
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
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Hor">Hor</option>
                                    <option value="Vert">Vert</option>
                                    <option value="Digital">Digital</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'large format') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Spec">Spec</option>
                                    <option value="Super">Super</option>
                                    <option value="Wall">Wall</option>
                                    <option value="Digital">Digital</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'street furniture') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Transit">Transit</option>
                                    <option value="Bench">Bench</option>
                                    <option value="Street">Street</option>
                                    <option value="Digital">Digital</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'transit') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Ext">Ext</option>
                                    <option value="Int">Int</option>
                                    <option value="Bus">Bus</option>
                                    <option value="Wrap">Wrap</option>
                                    <option value="Station">Station</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'place based') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Stadium">Stadium</option>
                                    <option value="Airport">Airport</option>
                                    <option value="etc">etc</option>
                                </select>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                ';

            $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                <option value="metric">metric</option>
                <option value="imperial">imperial</option>
                <option value="pixel">pixel</option>
            </select>';

            // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                <option value="4c">4c</option>
                <option value="1c">1c</option>
                <option value="K">K</option>
                <option value="RGB">RGB</option>
            </select>';

            $htmlField .= '<input type="text" name="AdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            if (strtolower($AdvertisementType->name) !== 'place based') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Technical</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="bleed">Bleed</option>
                                    <option value="safety">Safety</option>
                                </select>';
            }
            $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
            $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'display') {

            if (strtolower($AdvertisementType->name) == 'billboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x250">970x250</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'smartphone banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x50">300x50</option>
                        <option value="320x50">320x50</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'leaderboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="728x90">728x90</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'pushdown') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x90">970x90</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'portrait') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x1050">300x1050</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'skyscraper') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="160x600">160x600</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'medium rectangle') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x250">300x250</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == '120x60') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x60">120x60</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'mobile interstitial') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="640x1136">640x1136</option>
                        <option value="750x1334">750x1334</option>
                        <option value="1080x1920">1080x1920</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone small banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x20">120x20</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone med banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="168x28">168x28</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone Lrg banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="216x36">216x36</option>
                    </select>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                <p class="text-base font-normal w-32" >Version</p>';

            $htmlField .= '<input type="text" name="AdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="AdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'social') {

            if (strtolower($AdvertisementType->name) == 'fb feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Conversion</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="JPEG">JPEG</option>
                    <option value="PNG">PNG</option>
                </select>';


                $htmlField .= '<input type="text" name="AdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdConversion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb video feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Conversion</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                        <option value="4:5">4:5</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                    <option value="1080x1350">1080x1350</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="MP4">MP4</option>
                    <option value="MOV">MOV</option>
                    <option value="GIF">GIF</option>
                </select>';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1s-241min">1s-241min</option>
                    <option value="4GB">4GB</option>
                </select>';

                $htmlField .= '<input type="text" name="AdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdConversion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb stories') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';

                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }

            if (strtolower($AdvertisementType->name) == 'fb ads on reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'insta profile feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'insta feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'insta stories') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'insta reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'carousel') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            if (strtolower($AdvertisementType->name) == 'collection') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Version</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }


            if (strtolower($AdvertisementType->name) == 'standard image') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Version</p>
                ';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="AdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="JPEG">JPEG</option>
                    <option value="PNG">PNG</option>
                </select>';


                $htmlField .= '<input type="text" name="AdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="AdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
                $htmlField .= '<input required type="number" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            }
            //  else {
            //     $htmlFieldName .= '<p class="text-base font-normal w-32" >Version</p>';
            //     $htmlField .= '<input type="text" name="AdVersion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            // }
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
            if (strtolower($AdvertisementType->name) !== 'other') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                ';

                $htmlField .= '<input type="text" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                // $htmlField .= '<input type="text" name="AdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="metric">metric</option>
                                    <option value="imperial">imperial</option>
                                    <option value="etc">etc</option>
                                </select>';

                // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="4c">4c</option>
                                    <option value="1c">1c</option>
                                    <option value="K">K</option>
                                </select>';

                $htmlField .= '<input type="text" name="NewAdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="bleed">Bleed</option>
                                    <option value="safety">Safety</option>
                                </select>';
            } else {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                ';

                $htmlField .= '<input type="text" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="4c">4c</option>
                                    <option value="1c">1c</option>
                                    <option value="K">K</option>
                                </select>';

                $htmlField .= '<input type="text" name="NewAdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="bleed">Bleed</option>
                                    <option value="safety">Safety</option>
                                </select>';
            }
        }
        if (strtolower($Category->name) == 'radio') {
            $htmlFieldName .= '
            <p class="text-base font-normal w-32" >File Type</p>
            ';
            $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'television') {
            $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>
            <p class="text-base font-normal w-32" >Resolution</p>
            <p class="text-base font-normal w-32" >File Type</p>
            ';
            $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                            <option value="metric">metric</option>
                            <option value="imperial">imperial</option>
                            <option value="etc">etc</option>
                        </select>';

            $htmlField .= '<input type="text" name="NewAdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }

        if (strtolower($Category->name) == 'outdoor') {

            if (strtolower($AdvertisementType->name) == 'posters') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Hor">Hor</option>
                                    <option value="Vert">Vert</option>
                                    <option value="Digital">Digital</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'large format') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Spec">Spec</option>
                                    <option value="Super">Super</option>
                                    <option value="Wall">Wall</option>
                                    <option value="Digital">Digital</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'street furniture') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Transit">Transit</option>
                                    <option value="Bench">Bench</option>
                                    <option value="Street">Street</option>
                                    <option value="Digital">Digital</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'transit') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Ext">Ext</option>
                                    <option value="Int">Int</option>
                                    <option value="Bus">Bus</option>
                                    <option value="Wrap">Wrap</option>
                                    <option value="Station">Station</option>
                                </select>';
            }

            if (strtolower($AdvertisementType->name) == 'place based') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="Stadium">Stadium</option>
                                    <option value="Airport">Airport</option>
                                    <option value="etc">etc</option>
                                </select>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >Colour</p>
                <p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                ';

            $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                <option value="metric">metric</option>
                <option value="imperial">imperial</option>
                <option value="pixel">pixel</option>
            </select>';

            // $htmlField .= '<input type="text" name="AdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
            $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdColour[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                <option value="4c">4c</option>
                <option value="1c">1c</option>
                <option value="K">K</option>
                <option value="RGB">RGB</option>
            </select>';

            $htmlField .= '<input type="text" name="NewAdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            if (strtolower($AdvertisementType->name) !== 'place based') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Technical</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                                    <option value="bleed">Bleed</option>
                                    <option value="safety">Safety</option>
                                </select>';
            }
        }
        if (strtolower($Category->name) == 'display') {

            if (strtolower($AdvertisementType->name) == 'billboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x250">970x250</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'smartphone banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x50">300x50</option>
                        <option value="320x50">320x50</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'leaderboard') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="728x90">728x90</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'pushdown') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="970x90">970x90</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'portrait') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x1050">300x1050</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'skyscraper') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="160x600">160x600</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'medium rectangle') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="300x250">300x250</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == '120x60') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x60">120x60</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'mobile interstitial') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="640x1136">640x1136</option>
                        <option value="750x1334">750x1334</option>
                        <option value="1080x1920">1080x1920</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone small banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="120x20">120x20</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone med banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="168x28">168x28</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'feature phone Lrg banner') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Size WxH</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="216x36">216x36</option>
                    </select>';
            }

            $htmlFieldName .= '<p class="text-base font-normal w-32" >Resolution</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>';

            $htmlField .= '<input type="text" name="NewAdResolution[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';

            $htmlField .= '<input type="text" name="NewAdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" class="input input-bordered input-primary w-32 rounded-md"/>';
        }
        if (strtolower($Category->name) == 'social') {

            if (strtolower($AdvertisementType->name) == 'fb feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Conversion</p>
                ';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="JPEG">JPEG</option>
                    <option value="PNG">PNG</option>
                </select>';


                $htmlField .= '<input type="text" name="NewAdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdConversion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
            }

            if (strtolower($AdvertisementType->name) == 'fb video feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Technical</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                <p class="text-base font-normal w-32" >Conversion</p>
                ';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                        <option value="4:5">4:5</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                    <option value="1080x1350">1080x1350</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="MP4">MP4</option>
                    <option value="MOV">MOV</option>
                    <option value="GIF">GIF</option>
                </select>';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdTechnical[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1s-241min">1s-241min</option>
                    <option value="4GB">4GB</option>
                </select>';

                $htmlField .= '<input type="text" name="NewAdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdConversion[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
            }

            if (strtolower($AdvertisementType->name) == 'fb stories') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
            }

            if (strtolower($AdvertisementType->name) == 'fb reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
            }

            if (strtolower($AdvertisementType->name) == 'fb ads on reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'insta profile feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'insta feed') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'insta stories') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'insta reels') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="9:16">9:16</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'carousel') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
            }
            if (strtolower($AdvertisementType->name) == 'collection') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>';
                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';
            }


            if (strtolower($AdvertisementType->name) == 'standard image') {
                $htmlFieldName .= '<p class="text-base font-normal w-32" >Format</p>
                <p class="text-base font-normal w-32" >Size WxH</p>
                <p class="text-base font-normal w-32" >File Type</p>
                <p class="text-base font-normal w-32" >Social Spec 1</p>
                <p class="text-base font-normal w-32" >Social Spec 2</p>
                <p class="text-base font-normal w-32" >Social Spec 3</p>
                ';


                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFormate[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                        <option value="1:1">1:1</option>
                    </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdSize[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="1080x1080">1080x1080</option>
                </select>';

                $htmlField .= '<select class="select select-primary w-32 rounded-md" name="NewAdFileType[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]" >
                    <option value="JPEG">JPEG</option>
                    <option value="PNG">PNG</option>
                </select>';


                $htmlField .= '<input type="text" name="NewAdSocialSpec1[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdSocialSpec2[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';

                $htmlField .= '<input type="text" name="NewAdSocialSpec3[' . $FlightConnection->flight_id . '][' . $FlightConnection->id . '][' . $FlightConnection->language . '][' . $FlightConnection->type . '][' . $FlightConnection->category_id . '][]"" class="input input-bordered input-primary w-32 rounded-md" />';
            }
        }


        $result['htmlFieldName'] = $htmlFieldName;
        $result['htmlField'] = $htmlField;
        echo json_encode($result);
    }
}
