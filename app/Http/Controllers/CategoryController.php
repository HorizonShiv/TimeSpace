<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryMaster;
use App\Models\PublisherMaster;
use App\Models\AdvertisementType;

class CategoryController extends Controller
{
    //
    public function index()
    {

        $Categories = PublisherMaster::with('AdvertisementType','CategoryMaster')->get();
        // $Categories = CategoryMaster::all();
        // $Publishers = PublisherMaster::all();
        // $AdvertisementTypes = AdvertisementType::all();
        // return view('category', compact("Categories"));

        // dd($Categories->toArray());
        return view('category', compact("Categories"));
    }

    public function getCategoryName(Request $request)
    {

        $AdvertisementType = AdvertisementType::with('CategoryMaster')->where('id', $request->ad_id)->first();
        // dd($AdvertisementType);
        $result['name'] = $AdvertisementType->CategoryMaster->name;
        echo json_encode($result);
    }
    public function AddCategory(Request $request)
    {
        if ($request->Category) {
            $Category = new CategoryMaster([
                'name' => $request->Category,
            ]);
            if ($Category->save()) {
                $success = 'Successfully Added';
                return redirect()->action([CategoryController::class, 'index'], compact('success'));
            } else {
                $error = 'Failed';
                return redirect()->action([CategoryController::class, 'index'], compact('error'));
            }
        }
    }

    public function AddPublisher(Request $request)
    {
        if ($request->publisher) {
            $Publisher = new PublisherMaster([
                'category_id' => $request->CategoryPublisher,
                'name' => $request->publisher,
            ]);
            if ($Publisher->save()) {
                $success = 'Successfully Added';
                return redirect()->action([CategoryController::class, 'index'], compact('success'));
            } else {
                $error = 'Failed';
                return redirect()->action([CategoryController::class, 'index'], compact('error'));
            }
        }
    }

    public function AddType(Request $request)
    {
        // dd($request->toArray());

        $addType = $request->addType;
        if (!empty($addType[0])) {
            foreach ($addType as $date) {
                $AdvertisementType = new AdvertisementType([
                    'category_master_id' => $request->selectCategory,
                    'publisher_master_id' => $request->selectPublisher,
                    'name' => $date,
                ]);
                $AdvertisementType->save();
            }
            $success = 'Successfully Added';
            return redirect()->action([CategoryController::class, 'index'], compact('success'));
        } else {
            $error = 'Failed';
            return redirect()->action([CategoryController::class, 'index'], compact('error'));
        }
    }
}
