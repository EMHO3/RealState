<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;


class RoleController extends Controller
{
    //
    public function AllPermission()  {
        $permissions=Permission::all();
        return view('backend.pages.permission.all_permission',compact('permissions'));
    }

    public function AddPermission()  {
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request)  {
        $permission=Permission::create([
            'name'=>$request->name,
            'group_name'=>$request->group_name,
        ]);
        $notificacion=array(
            'message'=>'Permission Created succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.permission')->with($notificacion);
    }

    public function EditPermission($id)  {
        $permission=Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission',compact('permission'));
    }

    public function UpdatePermission(Request $request)  {
        $perm_id=$request->id;
        Permission::findOrFail($perm_id)->update([
            'name'=>$request->name,
            'group_name'=>$request->group_name,
        ]);
        $notificacion=array(
            'message'=>'Permission Updated succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.permission')->with($notificacion);
    }

    public function DeletePermission($id)  {
        Permission::findOrFail($id)->delete();
        $notificacion=array(
            'message'=>'Permission Delted succesfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);
    }

    public function ImportPermission()  {
        return view('backend.pages.permission.import_permission');
    }

    public function Export() {
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request)  {
        Excel::import(new PermissionImport, $request->file('import_file'));
        $notificacion=array(
            'message'=>'Permission Imported succesfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);        
    }
}
