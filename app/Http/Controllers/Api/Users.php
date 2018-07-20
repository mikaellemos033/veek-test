<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Requests\Users\Create;
use App\Requests\Users\Update;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'All users',
            'data'    => User::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        
        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);

        }

        return response()->json([
            'success' => true,
            'message' => 'User found',
            'data'    => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $user = User::create($request->only['name', 'email']);
        return response()->json([
            'success' => true,
            'message' => 'User created',
            'data'    => $user
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $user = User::find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);

        }

        $user->name = $request->input('name');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated',
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) User::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfull'
        ]);
    }
}
