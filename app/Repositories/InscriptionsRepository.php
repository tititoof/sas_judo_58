<?php

namespace App\Repositories;

use App\Models\Inscription;
use App\Models\Season;
use App\Models\Member;
use App\Helpers\Answer;
use Illuminate\Http\Request;

/**
 * Inscriptions data management
 */
class InscriptionsRepository
{
    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        return $this->update($request, new Inscription);
    }

    /**
     * @param Request $request
     * @param Inscription $inscription
     * @return array
     */
    public function update(Request $request, Inscription $inscription)
    {
        try {
            $inscription->season_id                 = $request->input('season_id');
            $inscription->member_id                 = $request->input('member_id');
            $inscription->minor_go_alone            = $request->input('minor_go_alone');
            $inscription->major_take_off            = $request->input('major_take_off');
            $inscription->complementary_insurance   = $request->input('complementary_insurance');
            $inscription->save();
        } catch(\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200, $inscription);
    }

    /**
     * @param Inscription $inscription
     * @return array
     */
    public function delete(Inscription $inscription)
    {
        try {
            $inscription->delete();
        } catch(\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200);
    }

    /**
     * @param integer $member_id
     * @param integer $season_id
     * @return Inscription
     * @throws \Exception
     */
    public function find($member_id, $season_id)
    {
        try {
            $inscription = Inscription::where([
                ['member_id', '=', $member_id],
                ['season_id', '=', $season_id],
            ])->get();
        } catch(\Exception $exception) {
            return $exception;
        }
        return $inscription;
    }

    /**
     * @return array
     */
    public function getList()
    {
        try {
            $list = Inscription::all()->map(function($inscription) {
                return [
                    'season'    => $inscription->season->name,
                    'lastname'  => $inscription->member->lastname,
                    'firstname' => $inscription->member->firstname,
                ];
            });
        } catch(\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200, $list);
    }
}
