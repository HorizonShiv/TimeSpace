<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Flight;
use App\Models\FlightConnection;
use App\Models\AssetParameters;
use Illuminate\Http\Request;
use App\Models\CampaignLanguages;
use App\Models\CampaignMember;
use JetBrains\PhpStorm\Language;

class FlightController extends Controller
{


    public function create(Request $request)
    {
        if (!empty($request->id)) {
            $Campaign = Campaign::with("User")->where('id', $request->id)->first();
            $CampaignMember = CampaignMember::with("User")->where('campaign_id', $request->id)->get();
            $Language = CampaignLanguages::where('campaign_id', $request->id)->get();
            return view('add-flight', compact('Campaign', 'CampaignMember', 'Language'));
        } else {
            return redirect()->action([CampaignController::class, 'create']);
        }
    }

    public function store(Request $request)
    {
        //    dd($request->toArray());
        $flightcount = 1;
        $CampaignId = $request->CampaignId;
        $temp = 1;

        foreach ($request->startDate as $key => $startDate) {
            $Flight = new Flight([
                'campaign_id' => $request->CampaignId,
                'flight_count' => $flightcount,
                'in_market_start_date' => $startDate,
                'in_market_end_date' => $request->endDate[$key],
            ]);
            $Flight->save();
            $flightId = $Flight->id;

            $locationData = $request->location[$key];
            $categorynData = $request->category[$key];
            $typeData = $request->type[$key];

            foreach ($request->lang[$key] as $Datakey => $data) {
                $tag = 'F' . $temp;
                foreach ($categorynData[$Datakey] as $cateData) {
                    $FlightConnection = new FlightConnection([
                        'campaign_id' => $request->CampaignId,
                        'flight_id' => $flightId,
                        'language' => $data,
                        'type' => $typeData[$Datakey],
                        'location' => $locationData[$Datakey],
                        'category_id' => $cateData,
                        'tag' => $tag,
                    ]);
                    $FlightConnection->save();
                }
                $temp++;
                $success = 'Successfully Added';
            }
            $flightcount++;
            // dd($success);
        }
        $id = $request->CampaignId;
        // return redirect()->route('campaign-show', ['id' => $CampaignId]);
        return redirect()->action([AssetsController::class, 'AssetsSetup'], compact('id'));
    }

    public function edit($id)
    {
        $Flights = Flight::with('FlightConnection')->where('campaign_id', $id)->get();
        $Campaign = Campaign::with("User")->where('id', $id)->first();
        $CampaignMember = CampaignMember::with("User")->where('campaign_id', $id)->get();
        $Language = CampaignLanguages::where('campaign_id', $id)->get();
        return view('edit-flight', compact('Flights', 'Campaign', 'CampaignMember', 'Language'));
        // dd($id);

    }

    public function getFlightData(Request $request)
    {
        // Retrieve and debug the request data if necessary
        // dd($request->all());

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

        // Fetch the Flight along with its related FlightConnection and Assets
        $Flight = Flight::with('FlightConnection', 'Assets')->where('id', $request->flightId)->first();

        if ($Flight) {
            foreach ($Flight->FlightConnection as $Connection) {
                foreach ($Connection->Assets as $Asset) {
                    if ($Asset->flight_id == $Flight->id && $Asset->flight_connection_id == $Connection->id) {
                        switch ($Connection->language) {
                            case 'EN':
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
                                break;
                            case 'FR':
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
                                break;
                        }
                    }
                }
            }
        }

        // Prepare the result array
        // dd($enCounts);
        $result = [
            'enCounts' => $enCounts,
            'frCounts' => $frCounts,
        ];

        // dd($enCounts, $frCounts);

        // Output the result as a JSON response
        echo json_encode($result);
    }

    public function deleteConnection(Request $request)
    {
        // dd($request->flightconnectionId);
        $FlightConnection = FlightConnection::where('id', $request->flightconnectionId)->delete();

        if ($FlightConnection) {
            return response()->json(['success' => true, 'redirect' => 1]);
        } else {
            return response()->json(['success' => false, 'redirect' => 1]);
        }
    }
    public function delete(Request $request)
    {
        $FlightData = Flight::where('id', $request->flightId)->first();

        $Flight = Flight::where('id', $request->flightId)->delete();

        // FlightConnection::where('flight_id', $request->flightId)->each(function ($connection) {
        //     AssetParameters::where('flight_connection_id', $connection->id)->delete();
        // });
        $Flights = Flight::with('FlightConnection')->where('campaign_id', $FlightData->campaign_id)->first();

        if ($Flight) {
            $FlightConnection = FlightConnection::where('flight_id', $request->flightId)->delete();

            if (empty($Flights)) {
                // if (!isset($Flights) || $Flights === null || (is_array($Flights) && empty($Flights)) || (is_object($Flights) && method_exists($Flights, 'isNull') && $Flights->isNull())) {

                // return redirect()->route('flight-create', ['id' => $FlightData->campaign_id])->withSuccess('Successfully Done')->with(compact('Campaign', 'CampaignMember', 'Language'));
                return response()->json(['success' => true, 'redirect' => 1, 'campaign_id' => $FlightData->campaign_id]);
            } else {
                // return redirect()->route('flight-edit', ['id' => $FlightData->campaign_id])->withSuccess('Successfully Done')->with(compact('Flights', 'Campaign', 'CampaignMember', 'Language'));
                return response()->json(['success' => true, 'redirect' => 0]);
            }
        } else {
            // return redirect()->route('flight-edit', ['id' => $FlightData->campaign_id])->withSuccess('Successfully Done')->with(compact('Flights', 'Campaign', 'CampaignMember', 'Language'));
            return response()->json(['success' => false, 'redirect' => 0]);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $flightcount = 1;
        foreach ($request->startDate as $key => $startDate) {

            $flightId = $request->flightId;

            $locationData = $request->location[$key];
            $categorynData = $request->category[$key];
            $typeData = $request->type[$key];

            if (!empty($flightId[$key])) {
                // echo $request->flightConnectionId;
                $flightConnectionId = $request->flightConnectionId[$key];
                $Flight = Flight::where('id', $flightId[$key])->update([
                    'in_market_start_date' => $startDate,
                    'in_market_end_date' => $request->endDate[$key],
                ]);


                foreach ($request->lang[$key] as $Datakey => $data) {
                    // dd($Datakey);
                    // echo $request->flightConnectionId[$Datakey];
                    if (!empty($flightConnectionId[$Datakey])) {
                        // echo $flightConnectionId[$Datakey];
                        $FlightConnection = FlightConnection::where('id', $flightConnectionId[$Datakey])->update([
                            'language' => $data,
                            'type' => $typeData[$Datakey],
                            'location' => $locationData[$Datakey],
                            'category_id' => $categorynData[$Datakey],
                        ]);
                    } else {
                        $FlightConnection = new FlightConnection([
                            'campaign_id' => $request->CampaignId,
                            'flight_id' => $flightId[$key],
                            'language' => $data,
                            'type' => $typeData[$Datakey],
                            'location' => $locationData[$Datakey],
                            'category_id' => $categorynData[$Datakey],
                        ]);
                        $FlightConnection->save();
                    }
                }
                $flightcount++;
                // dd($flightcount);
            } else {
                $Flight = new Flight([
                    'campaign_id' => $request->CampaignId,
                    'flight_count' => $flightcount,
                    'in_market_start_date' => $startDate,
                    'in_market_end_date' => $request->endDate[$key],
                ]);
                $Flight->save();
                $newflightId = $Flight->id;

                foreach ($request->lang[$key] as $Datakey => $data) {

                    $FlightConnection = new FlightConnection([
                        'campaign_id' => $request->CampaignId,
                        'flight_id' => $newflightId,
                        'language' => $data,
                        'type' => $typeData[$Datakey],
                        'location' => $locationData[$Datakey],
                        'category_id' => $categorynData[$Datakey],
                    ]);
                    $FlightConnection->save();
                    $success = 'Successfully Added';
                }
                $flightcount++;
            }
        }

        return redirect()->route('campaign-show', ['id' => $request->CampaignId]);
    }
}
