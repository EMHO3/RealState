<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    ///////////////////////ROle all methods///////////////////////
    public function AllRoles() {
        $roles=Role::all();
        return view('backend.pages.roles.all_roles',compact('roles'));
    }

    public function AddRoles()  {
        return view('backend.pages.roles.add_role');

    }

    public function StoreRoles(Request $request)  {
        Role::create([
            'name'=>$request->name,
        ]);
        $notificacion=array(
            'message'=>'Role Created succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.roles')->with($notificacion);
    }

    public function EditRoles($id)  {
        $roles=Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles',compact('roles'));
    }

    public function UpdateRoles(Request $request) {
        $role_id=$request->id;
        Role::findOrFail($role_id)->update([
            'name'=>$request->name,
        ]);
        $notificacion=array(
            'message'=>'Role Updated succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.roles')->with($notificacion);
    }

    public function DeleteRoles($id)  {
        Role::findOrFail($id)->delete();
        $notificacion=array(
            'message'=>'Role Delted succesfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);
    }

    ////////Add ROLE pERMISSION ALLL METHODS////////////

    public function AddRolesPermission() {
        $roles=Role::all();
        $permissions=Permission::all();
        $permission_groups=User::getpermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission',compact('roles','permissions','permission_groups'));
    }

    public function RolesPermissionStore(Request $request){
        $data=array();
        $permissions=$request->permission;
        foreach($permissions as $key =>$item)  {
            $data['role_id']=$request->role_id;
            $data['permission_id']=$item;
            DB::table('role_has_permissions')->insert($data);
        }

        $notificacion=array(
            'message'=>'Role Permission Added succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.roles.permission')->with($notificacion);
    }

    public function AllRolesPermission()  {
        $roles =Role::all();
        return view('backend.pages.rolesetup.all_roles_permission',compact('roles'));
    }

    public function AdminEditRoles($id)  {
        $role=Role::findOrFail($id);
        $permissions=Permission::all();
        $permission_groups=User::getpermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission',compact('role','permissions','permission_groups'));
    }

    public function AdminRolesUpdate(Request $request,$id){
        $role=Role::findOrFail($id);
        $permissions=$request->permission;
        if (!empty($permissions)) {
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name');

            $role->syncPermissions($permissionNames);
        }
        $notificacion=array(
            'message'=>'Role Permission Updated succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.roles.permission')->with($notificacion);
    }

    public function AdminDeleteRoles($id){
        $role=Role::findOrFail($id);
        if (!is_null($role)) {
            $role->delete();
        }

        
        $notificacion=array(
            'message'=>'Role Permission Deleted succesfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);
    }
}
 