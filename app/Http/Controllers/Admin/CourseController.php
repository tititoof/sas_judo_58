<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Repositories\CoursesRepository;
use App\Http\Requests\CourseFormRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseRepo = new CoursesRepository;
        return response()->json(['success' => true, 'objects' => $courseRepo->getCourses(), 'scheduler' => $courseRepo->getSchedulerCourses()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $courseRepo = new CoursesRepository;
      return response()->json($courseRepo->getFormOptions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseFormRequest $request)
    {
        $courseRepo = new CoursesRepository;
        return response()->json($courseRepo->save($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $courseRepo = new CoursesRepository;
        $edit       = $courseRepo->getFormOptions();
        $edit['data']['course'] = $course;
        return response()->json( $edit );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseFormRequest $request, Course $course)
    {
        $courseRepo   = new CoursesRepository;
        return response()->json($courseRepo->update($request, $course));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $courseRepo   = new CoursesRepository;
        return response()->json($courseRepo->destroy($course));
    }
}
