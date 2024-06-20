<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamMember;

class TeamController extends Controller
{
    //
    public function index()
    {
        $Teams = Team::all();
        // dd($Teams);
        return view('manage-team', compact("Teams"));
    }
    public function create()
    {
        return view('create-team');
    }

    public function store(Request $request)
    {
        // dd($request->toArray());
        $this->validate(request(), [
            'teamName' => 'required',
        ]);

        $Team = new Team([
            'team_type' => $request->TeamType,
            'name' => $request->teamName,
        ]);

        if ($Team->save()) {
            $success = 'Successfully Added';
            return redirect()->action([TeamController::class, 'index'], compact('success'));
        } else {
            $error = 'Failed';
            return redirect()->action([TeamController::class, 'index'], compact('error'));
        }
    }

    public function managePeople()
    {
        $Teams = Team::with('TeamMember.User')->has('TeamMember')->get();
        // $myTeams = Team::with(['TeamMember' => function ($query) {
        //     $query->where('type', 'Coworker');
        // }, 'TeamMember.user'])
        //     ->where('id', 3)
        //     ->has('TeamMember')
        //     ->get();
        return view('manage-people', compact("Teams"));
    }
}
