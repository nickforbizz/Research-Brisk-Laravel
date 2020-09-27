<?php

namespace App\Http\Controllers\apiAuth;

use auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{

    public function login(Request $request)
    {

        $loginData = Validator::make($request->all(),[
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($loginData->fails()) {
            return ([
                'code'=> -1,
                "msg" => $loginData->errors()
            ]);
        }
        $loginData = $request->toArray();
        // return $request;
        if (!auth()->attempt($loginData)) {
            return response([
                "code" => -1,
                'msg' => 'Invalid Credentials'
                ]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        auth()->user()->access_token =  $accessToken;
        return response([
            'code' => 1,
            'msg' => 'Logged in successfully',
            'user' => auth()->user(),
            'access_token' => $accessToken
         ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::paginate(20);

        return UserResource::collection($users);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
