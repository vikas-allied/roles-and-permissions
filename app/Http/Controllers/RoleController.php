<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name','ASC')->paginate(10);
            return view('roles.list',[
                'roles' => $roles
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create',[
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|unique:roles|min:3'
            ]);

            if($validator->passes())
            {
                $data = $validator->validated();
                $role = Role::create($data);

                if(!empty($request->permission)){
                    foreach($request->permission as $name){
                        $role->givePermissionTo($name);
                    }
                }

                return redirect()->route('roles.index')->with('success','Role is created successfully.');
            }
            else
            {
                return redirect()->route('roles.create')->withInput()->withErrors($validator);
            }
        }catch(\Exception $e)
        {
            return redirect()->route('roles.create')->with('error','Somthing went wrong Try Again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
            $role = Role::findOrFail($id);
            $hasPermissions = $role->permissions->pluck('name');
            $permissions = Permission::orderBy('name','ASC')->get();

            return view('roles.edit',[
                'role' => $role,
                'permissions' => $permissions,
                'hasPermissions' => $hasPermissions
            ]);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       try{

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|unique:roles,name,'.$id.',id',  //This checks if the entered role is not present in table except for current one
        ]);

        if($validator->passes())
        {
            $data = $validator->validated();
            $role = Role::findOrFail($id);

            $role->name = $data['name'];
            $role->save();

            if(!empty($request->permission)){

                $role->syncPermissions($request->permission);
            }
            else {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success','Role is updated successfully.');
        }
        else
        {
            return redirect()->route('roles.edit', ['role' => $id])->withInput()->withErrors($validator);
        }
    }catch(\Exception $e)
    {
        return redirect()->route('roles.edit', ['role' => $id])->with('error','Somthing went wrong Try Again!');
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $role = Role::find($id);

       if($role == null)
       {
            session()->flash('error','Role not found');
            return response()->json([
                'status' => false,
            ]);
       }

       $role->delete();

       session()->flash('success','Role deleted successfully');
       return response()->json([
           'status' => true,
       ]);

    }
}
