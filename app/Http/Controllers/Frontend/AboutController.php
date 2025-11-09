<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::where('status', 'active')->get();
        return view('frontend.pages.about.index', compact('abouts'));

    }

    /**
     * Show the form for creating a new resource.
     */
   
}
