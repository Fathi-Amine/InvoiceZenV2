<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $search = request('search', false);
        $perPage = request('per_page', 5);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = User::query();
        $query->orderBy($sortField, $sortDirection);
        if ($search) {
            $query->where('User_name', 'like', "%{$search}%");
        }
        return UserResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        $data = $request->validated();
        $data['is_admin'] = true;
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return new UserResource($user);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //

        $data = $request->validated();
        if(!empty($data['password'])){

            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //

        $user->delete();

        return response()->noContent();
    }

}
