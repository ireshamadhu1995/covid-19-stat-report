<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\APIHelper;
use App\Models\HelpGuide;

class HelpGuideController extends Controller
{
    public function index()
    {
        try {
            $help_guides = HelpGuide::with(['images','user'])->get();
            return APIHelper::makeAPIResponse(true, "Help Guides", $help_guides);
        } catch (\Exception $e) {
            report($e);
            return APIHelper::makeAPIResponse(false, "Internal server error", null, 500);
        }
    }
}
