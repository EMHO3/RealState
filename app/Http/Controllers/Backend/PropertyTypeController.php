<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function AllType(){
        $types=PropertyType::latest()->get();
        return view('backend.type.all_type',compact('types'));
    }

    public function AddType()  {
        return view('backend.type.add_type');
    }

    public function StoreType(Request $request)  {
        $request->validate([
            'type_name'=>'required|unique:property_types|max:200',
            'type_icon'=>'required'
        ]);
        PropertyType::insert([
            'type_name'=>$request->type_name,
            'type_icon'=>$request->type_icon,
        ]);
        $notificacion=array(
            'message'=>'Property Typer created succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.type')->with($notificacion);
    }

    public function EditType($id)  {
        $types=PropertyType::findOrFail($id);
        return view('backend.type.edit_type',compact('types'));
    }

    public function UpdateType(Request $request)  {
        $pid=$request->id;
        PropertyType::findOrFail($pid)->update([
            'type_name'=>$request->type_name,
            'type_icon'=>$request->type_icon,
        ]);
        $notificacion=array(
            'message'=>'Property Typer Update succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.type')->with($notificacion);
    }

    public function DeleteType($id)  {
        PropertyType::findOrFail($id)->delete();

        $notificacion=array(
            'message'=>'Property Typer Deleted succesfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);
    }

    ////////ALLL AMENITIES METHODSS///////
    public function AllAmenitie()  {
        $amenities=Amenities::latest()->get();
        return view('backend.amenities.all_amenities',compact('amenities'));
    }

    public function AddAmenitie()  {
        return view('backend.amenities.add_amenities');

    }
    public function StoreAminitie(Request $request)  {
       
        Amenities::insert([
            'aminities_name'=>$request->aminities_name,
        ]);
        $notificacion=array(
            'message'=>'Amenitie created succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.amenitie')->with($notificacion);
    }

    public function EditAmenitie($id) {
        $amenities=Amenities::findOrFail($id);
        return view('backend.amenities.edit_amenities',compact('amenities'));
    }

    public function UpdateAmenitie(Request $request)  {
        $ame_id=$request->id;
        Amenities::findOrFail($ame_id)->update([
            'aminities_name'=>$request->aminities_name,
        ]);
        $notificacion=array(
            'message'=>'Amenities Updated succesfully',
            'alert-type'=>'success'
        );
        return redirect()->route('all.amenitie')->with($notificacion);
    }

    public function DeleteAmenitie($id)  {
        Amenities::findOrFail($id)->delete();
        $notificacion=array(
            'message'=>'Aminitie Deleted succesfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notificacion);
    }
}
