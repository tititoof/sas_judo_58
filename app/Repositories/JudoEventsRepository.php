<?php
/**
 * Created by PhpStorm.
 * User: tititoof
 * Date: 23/02/17
 * Time: 08:39
 */

namespace App\Repositories;

use App\Models\Judoevent;
use App\Helpers\Answer;
use Illuminate\Http\Request;

/**
 * Class JudoEventsRepository
 * @package App\Repositories
 */
class JudoEventsRepository
{
    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        return $this->update($request, new Judoevent);
    }

    /**
     * @param Request $request
     * @param Judoevent $judoevent
     * @return array
     */
    public function update(Request $request, Judoevent $judoevent)
    {
        try {
            $judoevent->type        = $request->input('type');
            $judoevent->name        = $request->input('name');
            $judoevent->description = $request->input('description');
            $judoevent->start_at    = $this->setDateTime(
                new \DateTime($request->input('start_at')), $request->input('start_time_at'));
            $judoevent->end_at      = $this->setDateTime(
                new \DateTime($request->input('end_at')), $request->input('end_time_at'));
            $judoevent->save();
            return Answer::success(200, $judoevent);
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
    }

    /**
     * @param Judoevent $judoevent
     * @return array
     */
    public function delete(Judoevent $judoevent)
    {
        try {
            $judoevent->delete();
            return Answer::success(200);
        } catch(\Exception $exception) {
            return Answer::error($exception);
        }
    }

    /**
     * @return array
     */
    public function getCalendar()
    {
        $events = Judoevent::All();
        $list   = $events->map(function($event) {
            $cal = new \stdClass;
            $cal->id    = $event->id;
            $cal->title = $event->name;
            $cal->start = $event->start_at;
            $cal->end   = $event->end_at;
            return $cal;
        });
        return $list->all();
    }

    /**
     * @param \DateTime $inDate
     * @param array $inTime
     * @return \DateTime
     */
    private function setDateTime(\DateTime $inDate, Array $inTime)
    {
        $inDate->setTime($inTime['HH'], $inTime['mm']);
        return $inDate;
    }
}
