<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Campaign');
    }

    public function store(Request $request)
    {
        // $this->validate(request(), [
        //     'name' => 'required',
        //     'email' => 'required',
        // ]);
        // dd($request->toArray());

        $randomNumber = rand(10000000, 99999999);
        $password = Hash::make($randomNumber);

        $User = new User([
            'name' => $request->Name,
            'email' => $request->Email,
            'password' => $password,
            'type' => $request->userType,
            'team_id' => $request->belongsTo,
        ]);

        $UserResult = $User->save();

        if ($UserResult) {
            $UserId = $User->id;
            $TeamMember = new TeamMember([
                'user_id' => $UserId,
                'team_id' => $request->belongsTo,
                'type' => $request->userType,
            ]);

            $TeamMember->save();

            $success = 'Successfully Added';
            return redirect()->action([TeamController::class, 'managePeople'], compact('success'));
        } else {
            $error = 'Failed';
            return redirect()->action([TeamController::class, 'managePeople'], compact('error'));
        }
    }


}
