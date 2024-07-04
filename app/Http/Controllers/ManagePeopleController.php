<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;

class ManagePeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Teams = Team::with('TeamMember.User')->has('TeamMember')->get();
        // $myTeams = Team::with(['TeamMember' => function ($query) {
        //     $query->where('type', 'Coworker');
        // }, 'TeamMember.user'])
        //     ->where('id', 3)
        //     ->has('TeamMember')
        //     ->get();
        // dd($Teams);
        return view('team.manage-people', compact("Teams"));
    }

    public function managePeople()
    {
       
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
        // dd($request->all());
        $teamIdTeamType = $request->input('team_id');
        $exploded = explode('-', $teamIdTeamType);
    
        // Separate the exploded values
        $teamId = $exploded[0];
        $teamType = $exploded[1];
        

        $User = new User([
            'name' => $request->name,
            'email' => $request->email,
            'team_id' => $teamId,
            'type' => $teamType,
            'invitation_note' => $request->invitation_note,
        ]);

        $User->save();

        $user_id = $User->id;
        // dd($user_id);

        $TeamMember = new TeamMember([
            'user_id' => $user_id,
            'team_id' => $teamId,
            'type' => $teamType,
        ]);

        $TeamMember->save();
        // dd($user_id);

        // $Teams = Team::with('TeamMember.User')->has('TeamMember')->get();
        // $myTeams = Team::with(['TeamMember' => function ($query) {
        //     $query->where('type', 'Coworker');
        // }, 'TeamMember.user'])
        //     ->where('id', 3)
        //     ->has('TeamMember')
        //     ->get();
        // dd($Teams);
        return redirect()->route('manage-people');
        // return view('team.manage-people');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
