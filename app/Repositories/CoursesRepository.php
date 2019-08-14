<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Season;
use App\Repositories\UserRepository;
use App\Helpers\Answer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CoursesRepository
{
    /**
     * 
     */
    const WEEK_DAYS = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    
    const START_AT  = 'start_at';
    
    const END_AT    = 'end_at';
    
    public function save(Request $request)
    {
        return $this->update($request, new Course);
    }

    public function update(Request $request, Course $course)
    {
        try {
            $startAt            = $this->setDateTime(new \DateTime('now'), $request->input(self::START_AT));
            $endAt              = $this->setDateTime(new \DateTime('now'), $request->input(self::END_AT));
            $course->name       = $request->input('name');
            $course->day        = $request->input('day');
            $course->start_at   = $startAt->format('H:i');
            $course->end_at     = $endAt->format('H:i');
            $course->teacher_id = $request->input('teacher_id');
            $course->season_id  = $request->input('season_id');
            $course->color      = $request->input('color');
            $course->save();
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200, $course);
    }

    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return Answer::success(200);
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
    }
    
    /**
    * @param \DateTime $inDate
    * @param $inTime
    * @return \DateTime
    */
    private function setDateTime(\DateTime $inDate, $inTime)
    {
        if (is_string($inTime) ) {
            $heureMinute = explode(':', $inTime);
            $inDate->setTime($heureMinute[0], $heureMinute[1]);
        } else {
            $inDate->setTime($inTime['HH'], $inTime['mm']);
        }
        return $inDate;
    }

    public function getFormOptions()
    {
        $userRepo = new UserRepository;
        $teachers = $userRepo->getAllTeachers();
        $seasons  = Season::orderBy('id', 'desc')->get();
        $seasons  = $seasons->map(function($season) {
            return ['label' => $season->name, 'value' => $season->id];
        });
        return Answer::success(200, [
            'seasons'   => $seasons,
            'teachers'  => $teachers['data'],
            'days'      => $this->getDays(),
        ]);
    }

    public function getCourses()
    {
        $courses = Course::all();
        return $courses->map(function($course) {
            return [
                'id'            => $course->id,
                'season'        => $course->season->name,
                'day'           => $course->day,
                self::START_AT  => $course->start_at,
                self::END_AT    => $course->end_at,
                'teacher'       => $course->teacher->name,
            ];
        });
    }

    public function getSchedulerCourses()
    {
        $year   = Carbon::now();
        $season = Season::where(self::START_AT, '<=', $year)
                        ->where(self::END_AT, '>=', $year)
                        ->first()
                        ->get();
        $yearCourses = Course::where('season_id', '=', $season[0]->id)->get();
        $days = collect(self::WEEK_DAYS);
        return $days->map(function($day) use ($yearCourses) {
            return $yearCourses->map(function($item) use ($day) {
                $course = new \stdClass();
                if ($day == $item->day) {
                    $course->dateStart  = $item->start_at;
                    $course->dateEnd    = $item->end_at;
                    $course->title      = $item->name;
                    $course->color      = $item->color;
                }
                return $course;
            });
        });
    }

    private function getDays()
    {
        $days = collect(self::WEEK_DAYS);
        return $days->map(function($day) {
            return ['label' => $day, 'value' => $day];
        });
    }
}
