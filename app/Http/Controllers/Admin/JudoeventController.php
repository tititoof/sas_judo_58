<?php

namespace App\Http\Controllers\Admin;

use App\Models\Judoevent;
use App\Repositories\JudoEventsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\JudoEventRequest;

class JudoeventController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JudoEventRequest $request)
    {
        $repo = new JudoEventsRepository;
        return response()->json($repo->save($request));
    }

    /**
     * @param Judoevent $judoevent
     * @return mixed
     */
    public function show(Judoevent $judoevent)
    {
        return response()->json(['entity' => $judoevent]);
    }

    /**
     * @param Judoevent $judoevent
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Judoevent $judoevent)
    {
        return response()->json(['entity' => $judoevent]);
    }

    /**
     * @param Request $request
     * @param Judoevent $judoevent
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(JudoEventRequest $request, Judoevent $judoevent)
    {
        $repo = new JudoEventsRepository;
        return response()->json($repo->update($request, $judoevent));
    }

    /**
     * @param Judoevent $judoevent
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Judoevent $judoevent)
    {
        $repo = new JudoEventsRepository;
        return response()->json($repo->delete($judoevent));
    }
}
