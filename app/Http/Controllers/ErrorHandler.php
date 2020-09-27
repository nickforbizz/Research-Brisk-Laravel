<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ErrorHandler extends Controller
{
    //

    public function LogError($error="", $process="U")
    {
        $data = array('name'=>"Virat Gandhi");
    
        Mail::send(['text'=>'mail'], $data, function($message) {
            $message->to('lykkc3+30ysg1ijdd1hs@sharklasers.com', 'Tutorials Point')->subject
                ('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com','Virat Gandhi');
        }); 
        return [
            'err'=> $error,
            'process' => $process
        ];


    }
}
