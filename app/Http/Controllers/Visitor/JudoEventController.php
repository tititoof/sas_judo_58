<?php

namespace App\Http\Controllers\Visitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\JudoEventsRepository;

class JudoEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repo   = new JudoEventsRepository;
        $events = $repo->getCalendar();
        return response()->json(['events' => $events]);
    }
}
