<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected User $user
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->user->newQuery()->paginate();
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
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('public/images');
        }
        $user = $this->user->newQuery()->create($data);
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
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('public/images');
        }
        $user->update($data);
        return redirect()->action([self::class, 'show'], $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('users.index'));
    }

    public function delete(string $id)
    {
        $user= $this->user->newQuery()->onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect(route('users.trashed'));
    }

    public function trashed()
    {
        $data = $this->user->newQuery()->onlyTrashed()->paginate();
        return view('users.trashed', compact('data'));
    }

    public function restore(string $id)
    {
        $user= $this->user->newQuery()->onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->action([self::class, 'show'], $user);
    }
}
