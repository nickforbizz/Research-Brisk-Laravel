<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\OrderFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class orderFormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $order_cat = OrderFormat::paginate(20);
            return $order_cat;
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
                'name' => 'required|max:255',
                'description' => 'required',
            ]);
            
    
            if ($validatedData->fails()) {
                return ([
                    'code'=> -1,
                    'msg'=>$validatedData->errors()
                ]);
            }
            $user =  Auth::guard('api')->user();

            $cat = OrderFormat::create([
                "user_id" => $user->id,
                "name" => $request->name,
                "description" => $request->description
            ]);
    
            if ($cat) {
                return ([
                    'code'=> 1,
                    'msg'=>"Request went Successfully",
                    'body' => $cat
                ]);
            }
    
            return ([
                'code'=> -1,
                'msg'=>"Request Failed",
                'body' => $cat
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
        return OrderFormat::find($id);
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
            $count_ordercat = OrderFormat::where('id',$id)->count();
            if ($count_ordercat < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Update",
                    'body' =>""
                ]);
            }
            
            OrderFormat::where('id',$id)->update([
                'name' => $request->name,
                'description' => $request->description
            ]);
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Updated",
                'body' => OrderFormat::find($id)
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
            $count_ordercat = OrderFormat::where('id',$id)->count();
            if ($count_ordercat < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Delete",
                    'body' =>""
                ]);
            }
            
            OrderFormat::where('id',$id)->delete();
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Deleted",
                'body' => OrderFormat::find($id)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
            
            return $th;
        }
    }
}
