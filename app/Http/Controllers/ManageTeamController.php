<?php

namespace App\Http\Controllers;

use App\Models\ManageTeam;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManageTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manage-team');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manage-people');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ManageTeam $manageTeam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManageTeam $manageTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManageTeam $manageTeam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManageTeam $manageTeam)
    {
        //
    }
}
