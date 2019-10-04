<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()
                                 ->pluck('title', 'id')
        ;

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()
             ->sync($request->input('permissions', []))
        ;

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        if ($role['id'] == 7) {
            return back();
        } else {
            $permissions = Permission::all()
                                     ->pluck('title', 'id')
            ;
            $role->load('permissions');

            return view('admin.roles.edit', compact('permissions', 'role'));
        }
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()
             ->sync($request->input('permissions', []))
        ;

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        if ($role['id'] == 7) {
            return back();
        } else {
            $role->load('permissions');

            return view('admin.roles.show', compact('role'));
        }
    }

    public function destroy(Role $role)
    {
        if ($role['id'] == 7) {
            return back();
        } else {
            $role->delete();

            return back();
        }
    }
}
