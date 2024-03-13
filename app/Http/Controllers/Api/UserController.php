<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::Search($request->Search)
            ->orderBy("lastname", "asc")
            ->orderBy("firstname", "asc")
            ->paginate($request->pageSize);

        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(UserRequest $request): JsonResponse
    {
        $input = $request->validated();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        return $this->successResponse(
            new UserResource($user),
            true
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $input = $request->validated();
        $temppassword = $input['password'];
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->sendEmailVerificationNotificationUser($temppassword);

        return $this->successResponse(
            new UserResource($user),
            true
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return $this->successResponse(
            new UserResource($user)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $input = $request->validated();

        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }

        DB::transaction(function () use ($user, $input) {
            $user->update($input);
        }, 2);

        return $this->successResponse(
            new UserResource($user)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        }, 2);

        return $this->deleteResponse();
    }

    /**
     * Get Authenticated user
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getAuthUser(Request $request): JsonResponse
    {
        return $this->successResponse(
            new UserResource($request->user())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateNotification(Request $request, User $user)
    {
        $user->update(['notification' => $request->notification]);

        return $this->successResponse(
            new UserResource($user)
        );
    }
}
