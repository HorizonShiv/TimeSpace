<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyAddress;

class CompanyController extends Controller
{
    public function index()
    {
        return view('account-settings');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-company');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'CompanyName' => 'required',
            'CompanyNumber' => 'required',
            'Email' => 'required',
            'Url' => 'required',
            'Address1' => 'required',
            'Country' => 'required',
            'State' => 'required',
            'PostalCode' => 'required',
        ]);

        $Company = new Company([
            'name' => $request->CompanyName,
            'number' => $request->CompanyNumber,
            'email' => $request->Email,
            'url' => $request->Url,
        ]);
        // dd($request->toArray());
        if ($Company->save()) {
            $CompanyId = $Company->id;

            $CompanyAddress = new CompanyAddress([
                'company_id' => $CompanyId,
                'address1' => $request->Address1,
                'address2' => $request->Address2,
                'country' => $request->Country,
                'state' => $request->State,
                'postal_code' => $request->PostalCode,
            ]);

            $CompanyAddress->save();
            $success='Successfully Added';

            return redirect()->action([CompanyController::class, 'index'], compact('success'));
        } else {
            $error = 'Failed';
            return redirect()->action([CompanyController::class, 'index'], compact('error'));
        }
    }
}
