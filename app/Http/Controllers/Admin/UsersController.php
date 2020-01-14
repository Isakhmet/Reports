<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserActiveRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all()
                     ->pluck('title', 'id')
        ;

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()
             ->sync($request->input('roles', []))
        ;
        if ($user['roles'][0]['id'] == 1) {
            return back();
        } else {
            return redirect()->route('admin.users.index');
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all()
                     ->pluck('title', 'id')
        ;
        $user->load('roles');
        if ($user['roles'][0]['id'] == 1) {
            return back();
        } else {

            return view('admin.users.edit', compact('roles', 'user'));
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request['roles'][0] == 1) {
            return back();
        } else {
            $user->update($request->all());
            $user->roles()
                 ->sync($request->input('roles', []))
            ;
            if ($user['roles'][0]['id'] == 1) {
                return back();
            } else {

                return redirect()->route('admin.users.index');
            }
        }
    }

    public function show(User $user)
    {
        $user->load('roles');
        if ($user['roles'][0]['id'] == 1) {
            return back();
        } else {
            return view('admin.users.show', compact('user'));
        }
    }

    public function destroy(User $user)
    {
        if ($user['roles'][0]['id'] == 1) {
            return back();
        } else {
            $user->delete();

            return back();
        }
    }
}
