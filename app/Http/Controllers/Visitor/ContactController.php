<?php

namespace App\Http\Controllers\Visitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Answer;
use App\Mail\PresidentContacted;

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {
        
        Mail::to('chartmann.35@gmail.com')->send(
            new PresidentContacted([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'text' => $request->input('text'),
        ]));
        
        return response()->json(
            Answer::success(200, ['data' => $request->all() ])
        );
    }
}
