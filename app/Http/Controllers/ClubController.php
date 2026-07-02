<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::withCount('events')->paginate(8);

        return view('clubs.index', compact('clubs'));
    }
}
