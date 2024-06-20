<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Helpers
{

    public static function getcampaignHeaderImage($id, $fileName)
    {
        $path = url('campaignHeaderImage/' . $id . '/' . $fileName);
        return $path;
    }

    public static function formateDate($date)
    {
        $readableDate = Carbon::createFromFormat('Y-m-d', $date)->format('F d, Y');
        return $readableDate;
    }


    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }
}
