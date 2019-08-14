<?php

namespace App\Repositories;

use App\Models\Member;
use App\Helpers\Answer;
use Illuminate\Http\Request as Request;

/**
 * Member data management
 */
class MembersRepository
{
    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        return $this->update($request, new Member);
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param Memmber $member
     * @return array
     */
    public function update(Request $request, Member $member)
    {
        try {
            $member->firstname      = $request->input('firstname');
            $member->lastname       = $request->input('lastname');
            $member->sexe           = $request->input('sexe');
            $member->birthday       = new \DateTime($request->input('birthday'));
            $member->address        = $request->input('address');
            $member->postal_code    = $request->input('postal_code');
            $member->city           = $request->input('city');
            $member->phone          = $request->input('phone');
            $member->red_list       = $request->input('red_list');
            $member->mobile         = $request->input('mobile');
            $member->email          = $request->input('email');
            $member->save();
        } catch(\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200, $member);
    }

    /**
     * @param Member $member
     * @return array
     */
    public function delete(Member $member)
    {
        try {
            $member->delete();
        } catch(\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200);
    }

    /**
     * @param string $firstname
     * @param string $lastname
     * @return Collection
     * @throws \Exception
     */
    public function find($firstname, $lastname)
    {
        try {
            $member = Member::where([ ['firstname', '=', $firstname], ['lastname', '=', $lastname],])->get();
            if (null == $member) {
                return new Member;
            }
        } catch(\Exception $exception) {
            return $exception;
        }
        return $member;
    }
}
