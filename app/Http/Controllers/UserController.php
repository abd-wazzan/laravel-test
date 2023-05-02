<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserData;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\IUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected IUserService $userService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->userService->list();
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->store(UserData::fromRequest($request));
        return redirect()->action([self::class, 'show'], $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update(UserData::fromRequest($request));
        return redirect()->action([self::class, 'show'], $user->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return $this->userService->destroy($user->id) ? redirect()->route('users.index') :
            redirect()->route('users.index')->withErrors('Operation Failed!');
    }

    public function trashed()
    {
        $data = $this->userService->listTrashed();
        return view('users.trashed', compact('data'));
    }

    public function delete(string $id)
    {
        return $this->userService->delete($id) ? redirect()->route('users.trashed') :
            back()->withErrors('Operation Failed!');
    }

    public function restore(string $id)
    {
        return $this->userService->restore($id) ? redirect()->route('users.show', $id) :
            back()->withErrors('Operation Failed!');
    }
}
