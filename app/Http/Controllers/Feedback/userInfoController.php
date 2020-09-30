<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class userInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $enquiry = Enquiry::paginate(20);
            return $enquiry;
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
        }
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
    public function store(Request $request)
    {
        try {
            $validatedData =Validator::make($request->all(),[
                'email' => 'required|max:255',
                'subject' => 'required',
                'message' => 'required',
            ]);
            
    
            if ($validatedData->fails()) {
                return ([
                    'code'=> -1,
                    'msg'=>$validatedData->errors()
                ]);
            }

            $enquiry = Enquiry::create([
                "email" => $request->email,
                "subject" => $request->subject,
                "message" => $request->message,
            ]);
    
            if ($enquiry) {
                $maildata = array('name' => "ResearchBrisk Team", 'request' => $request);
                Mail::send('enquiry_mail', $maildata, function ($message) use ($request) {
                    $message->to('info@researchbrisk.com', 'New Enquiry')->subject('New Enquiry');
                    $message->from($request->email, $request->email);
                });
                return ([
                    'code'=> 1,
                    'msg'=>"Request went Successfully",
                    'body' => $enquiry
                ]);
            }
    
            return ([
                'code'=> -1,
                'msg'=>"Request Failed",
                'body' => $enquiry
            ]);
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
            
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data =  Enquiry::find($id);
        // $data->user;
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $count_orderpricing = Enquiry::where('id',$id)->count();
            if ($count_orderpricing < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Update",
                    'body' =>""
                ]);
            }
            
            Enquiry::where('id',$id)->update([
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Updated",
                'body' => Enquiry::find($id)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
            
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $count_orderpricing = Enquiry::where('id',$id)->count();
            if ($count_orderpricing < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Delete",
                    'body' =>""
                ]);
            }
            
            Enquiry::where('id',$id)->delete();
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Deleted",
                'body' => Enquiry::find($id)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
            
            return $th;
        }
    }
}
