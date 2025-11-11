<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\OurValue;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::where('status', 'active')->get();
        $ourvalues = OurValue::where('status', 1)->orderBy('order', 'asc')->get();
            return view('frontend.pages.about.index', compact('abouts', 'ourvalues'));
        }

    /**
     * Show the form for creating a new resource.
     */
   
}
