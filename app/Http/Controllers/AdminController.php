<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function AdminDashboard(){
        return view('admin.index');
    }
    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }// FIN DEL METODO

    public function AdminLogin(){
        return view('admin.admin_login');
    }// FIN DEL METODO

    public function AdminProfile(){
        $id=Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view',compact('profileData'));
    }// FIN DEL METODO

    public function AdminProfileStore(Request $request){
        $id=Auth::user()->id;
        $data = User::find($id);
        $data->username=$request->username;
        $data->name=$request->name;
        $data->email=$request->email;
        $data->phone=$request->phone;
        $data->address=$request->address;

        if ($request->file('photo')) {
            $file=$request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo']=$filename;
        }
        $data->save();
        $notificacion=array(
            'message'=>'Admin Profile Updated Seccessfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);

    }//fin del metodo AdminProfileStore

    public function AdminChangePassword(){
        $id=Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password',compact('profileData'));
    }// FIN DEL METODO

    public function AdminUpdatePassword (Request $request) {
        //validacion
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|confirmed'
        ]);

        //coincide con la contraseña anterior
        if (!Hash::check($request->old_password,auth::user()->password)) {
            $notificacion=array(
                'message'=>'Old Password Does not match',
                'alert-type'=>'error'
            );
            return back()->with($notificacion);
        }

        //actualizacion de la nueva contraseña
        User::whereId(auth()->user()->id)->update([
            'password'=>Hash::make($request->new_password)
        ]);
        $notificacion=array(
            'message'=>'Password change successfully',
            'alert-type'=>'success'
        );
        return back()->with($notificacion);

    }
    // FIN DEL METODO

    ///////////////ADMIN USER ALL METHODS///////////////////
    public function AllAdmin(){
        $alladmin=User::where('role','admin')->get();
        return view('backend.pages.admin.all_admin',compact('alladmin'));
    }

    public function AddAdmin()  {
        $roles=Role::all();
        return view('backend.pages.admin.add_admin',compact('roles'));
    }

    public function StoreAdmin (Request $request) {
        $user=new User();
        $user->username=$request->username;
        $user->name=$request->name;
        $user->email =$request->email ;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->password= Hash::make($request->password);
        $user->role='admin';
        $user->status='active';
        $user->save();

        // if ($request->roles) {
        //     $user->assignRole($request->roles);
        // }
        if ($request->roles) {
            // Busca el rol por ID y asigna el nombre del rol
            $role = Role::findById($request->roles);
            if ($role) {
                $user->assignRole($role->name);
            } else {
                // Maneja el caso en que el rol no existe
                return redirect()->back()->withErrors(['roles' => 'El rol seleccionado no existe.']);
            }
        }
        $notificacion=array(
            'message'=>'Adimn Added successfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.admin')->with($notificacion);

    }

    public function EditAdmin($id){
        $user=User::findOrFail($id);
        $roles= Role::all();
        return view('backend.pages.admin.edit_admin',compact('user','roles'));
    }

    public function UpdateAdmin(Request $request,$id){
        $user= User::findOrFail($id);
        $user->username=$request->username;
        $user->name=$request->name;
        $user->email =$request->email ;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->role='admin';
        $user->status='active';
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            // Busca el rol por ID y asigna el nombre del rol
            $role = Role::findById($request->roles);
            if ($role) {
                $user->assignRole($role->name);
            } else {
                // Maneja el caso en que el rol no existe
                return redirect()->back()->withErrors(['roles' => 'El rol seleccionado no existe.']);
            }
        }
        $notificacion=array(
            'message'=>'Adimn User Updated successfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.admin')->with($notificacion);
    }

    public function  DeleteAdmin($id)  {
        $user=User::findOrFail($id);
        if (!is_null($user)) {
            $user->delete();
        }
        $notificacion=array(
            'message'=>'Adimn User Deleted successfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);
    }
}
