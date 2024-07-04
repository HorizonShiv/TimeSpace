<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ManagePeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Teams = Team::with('TeamMember.User')->has('TeamMember')->get();
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
        $teamIdTeamType = $request->input('team_id');
        $exploded = explode('-', $teamIdTeamType);

        // Separate the exploded values
        $teamId = $exploded[0];
        $teamType = $exploded[1];

        $password = rand(100000, 999999);
        $User = new User([
            'name' => $request->name,
            'email' => $request->email,
            'team_id' => $teamId,
            'type' => $teamType,
            'invitation_note' => $request->invitation_note,
            'password' => Hash::make($password),
        ]);

        if ($User->save()) {
            $user_id = $User->id;
            $passwordUrl = route('authenticateWithEmail', ['email' => base64_encode($request->email)]);
            Mail::send('mails.registationMail', ['name' => $User->name ?? "Sir", 'password' => $password, 'email' => $User->email, 'passwordUrl' => $passwordUrl], function ($message) use ($User) {
                $message->to($User->email)
                    ->subject('Registration in Time Space');
            });
        }

        $TeamMember = new TeamMember([
            'user_id' => $user_id,
            'team_id' => $teamId,
            'type' => $teamType,
        ]);

        $TeamMember->save();
        return redirect()->route('manage-people');
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
