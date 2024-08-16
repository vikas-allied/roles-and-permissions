<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {

            $permissions = Permission::orderBy('created_at','DESC')->paginate(10);
            return view('permission.list',[
                'permissions' => $permissions
            ]);

        }catch(\Exception $e)
        {
            Log::info('Error', $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|unique:permissions|min:3'
            ]);
    
            if($validator->passes())
            {
                
                $data = $validator->validated();
                Permission::create($data);
                
                return redirect()->route('permissions.index')->with('success','Permisson is created successfully.');
            }
            else
            {
                return redirect()->route('permissions.create')->withInput()->withErrors($validator);
            }
        }catch(\Exception $e)
        {
            return redirect()->route('permissions.create')->with('error','Somthing went wrong Try Again!');
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
        try
        {

            $permission = Permission::findOrFail($id);
            return view('permission.edit',[
                'permission' => $permission
            ]);

        }catch(\Exception $e)
        {
            Log::info('Error', $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
            ]);
    
            if($validator->passes())
            {
                
                $data = $validator->validated();
                $permission = Permission::findOrFail($id);
                $permission->name = $data['name'];
                $permission->save();
                
                return redirect()->route('permissions.index')->with('success','Permisson is Updated successfully.');
            }
            else
            {
                return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validator);
            }
        }catch(\Exception $e)
        {
            return redirect()->route('permissions.edit', $id)->with('error','Somthing went wrong Try Again!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        
        if($permission == null) {
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status' => false
            ]);
        }

        $permission->delete();
        session()->flash('success', 'Permission deleted successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
