<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::when(request()->has('username'), function ($query) {
            $query->where('username', 'like', '%'.request()->input('username').'%')->get();
        }
        )->when(request()->has('email'), function ($query) {
            $query->where('email', 'like', '%'.request()->input('email').'%')->get();
            })
        ->paginate(request()->per_page);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Str::random(8); // Le colocamos una contraseña por defecto

        $user = User::create($data);
        
        return response()->json(UserResource::make($user), 201);
    }

    public function show(User $user)
    {

        return response()->json(UserResource::make( $user));

    }

    public function update(StoreUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);

        return response()->json(UserResource::make($user));
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(
            [
                'message' => 'El usuario ha sido eliminado correctamente.'
            ]
        );
    }


}