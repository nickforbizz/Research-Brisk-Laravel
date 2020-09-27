<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class blogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $blog = Blog::orderBy('created_at', 'desc')->paginate(20);
            return $blog;
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
    public function recentBlogs()
    {
        try {
            $blog = Blog::orderBy('created_at', 'desc')->paginate(10);
            return $blog;
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
        }
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
            DB::beginTransaction();
            $validatedData =Validator::make($request->all(),[
                'title' => 'required|max:255',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'description' => 'required',
                'featured_image' => 'required|file',
            ]);
            
    
            if ($validatedData->fails()) {
                return ([
                    'code'=> -1,
                    'msg'=>$validatedData->errors()
                ]);
            }
            $user =  Auth::guard('api')->user();
            $doc = $request->file('featured_image');
            $blog = Blog::create([
                "user_id" => $user->id,
                "title" => $request->title,
                "blog_category_id" => $request->blog_category_id,
                "rowid" => (string) Uuid::uuid4(),
                'media_name'=>$doc->getClientOriginalName(),
                'media_link'=>Storage::putFile('public/Blogs', $doc),
                'media_type'=>$doc->getClientOriginalExtension(),
                "body" => $request->body,
                "description" => $request->description
            ]);
            DB::commit();
            if ($blog) {
                return ([
                    'code'=> 1,
                    'msg'=>"Request went Successfully",
                    'body' => $blog
                ]);
            }
    
            return ([
                'code'=> -1,
                'msg'=>"Request Failed",
                'body' => $blog
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
        $blog = Blog::find($id); 
        if ($blog->count() > 0) {
            $blog->blogCategory;
            $blog->blogsComments;
            $blog->user;
        }

        return $blog;
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
            $validatedData =Validator::make($request->all(),[
                'title' => 'required|max:255',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'description' => 'required',
                'body' => 'required',
            ]);
            
    
            if ($validatedData->fails()) {
                return ([
                    'code'=> -1,
                    'msg'=>$validatedData->errors()
                ]);
            }

            $count_blog = Blog::where('id',$id)->count();
            if ($count_blog < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Update",
                    'body' =>""
                ]);
            }
            if($request->hasFile('featured_image')){
                $doc = $request->file('featured_image');
                Blog::where('id',$id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'blog_category_id' => $request->blog_category_id,
                    'body' => $request->body,
                    'media_name'=>$doc->getClientOriginalName(),
                    'media_link'=>Storage::putFile('public/Blogs', $doc),
                    'media_type'=>$doc->getClientOriginalExtension(),
                    'rowid' => (string) Uuid::uuid4(),
                ]);

            }else{
                Blog::where('id',$id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'blog_category_id' => $request->blog_category_id,
                    'body' => $request->body,
                    'rowid' => (string) Uuid::uuid4(),
                ]);
 
            }
            DB::commit();
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Updated",
                'body' => Blog::find($id)
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
            $count_ordercat = Blog::where('id',$id)->count();
            if ($count_ordercat < 1) {
                return ([
                    'code'=> -1,
                    'msg'=>"Request Failed to find Object to Delete",
                    'body' =>""
                ]);
            }
            
            Blog::where('id',$id)->delete();
            return ([
                'code'=> 1,
                'msg'=> "Request Successfully Deleted",
                'body' => Blog::find($id)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
            
            return $th;
        }
    }

    public function miscs(Request $request)
    {
        $misc_data = null;
        // $misc_data = ;
    }
}
