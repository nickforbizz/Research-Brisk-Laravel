<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Models\BlogsComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class blogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $blog_cat = BlogsComment::paginate(20);
            return $blog_cat;
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
                'comment' => 'required',
                'blog_id' => 'required|exists:blogs,id',
            ]);
            
    
            if ($validatedData->fails()) {
                return ([
                    'code'=> -1,
                    'msg'=>$validatedData->errors()
                ]);
            }
            $user =  Auth::guard('api')->user();

            $blog_comment = BlogsComment::create([
                "user_id" => $user->id,
                "blog_id" => $request->blog_id,
                "comment" => $request->comment
            ]);
    
            if ($blog_comment) {
                return ([
                    'code'=> 1,
                    'msg'=>"Request went Successfully",
                    'body' => $blog_comment
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
        $comment = BlogsComment::where('blog_id',$id)->get();

        return $comment;
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
            DB::beginTransaction();
            $count_blog_comment = BlogsComment::where('id',$id)->count();
            if ($count_blog_comment < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Update",
                    'body' =>""
                ]);
            }
            
            BlogsComment::where('id',$id)->update([
                'comment' => $request->comment,
            ]);
            DB::commit();
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Updated",
                'body' => BlogsComment::find($id)
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
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
            $count_blog_comment = BlogsComment::where('id',$id)->count();
            if ($count_blog_comment < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Delete",
                    'body' =>""
                ]);
            }
            
            BlogsComment::where('id',$id)->delete();
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Deleted",
                'body' => BlogsComment::find($id)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
            
            return $th;
        }
    }
}
