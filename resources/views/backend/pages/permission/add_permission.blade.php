@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">

    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          
        </div>
      </div>
    </div>
    <div class="row profile-body">
      <!-- left wrapper start -->
     
      <!-- left wrapper end -->
      <!-- middle wrapper start -->
      <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
            <div class="card">
                <div class="card-body">
  
                    <h6 class="card-title"> Add Permissions </h6>
                    <form id="myForm" method="POST" action="{{route('store.permission')}}" class="forms-sample" >
                        @csrf
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1" class="form-label">Permission Name</label>
                            <input type="text" name="name" class="form-control " >                          
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1" class="form-label">Group Name</label>
                            <select name="group_name" class="form-select" id="exampleFormControlSelect1">
                                <option selected="" disabled="">Selected Group</option>
                                <option value="type" >Property Type</option>
                                <option value="state" >State</option>
                                <option value="amenities" >Amenities</option>
                                <option value="property" >Property</option>
                                <option value="history" >Package history</option>
                                <option value="Message" >Property Message</option>
                                <option value="testimonios" > Testimonios</option>
                                <option value="agent" >Managge agent</option>
                                <option value="category" >Blog category</option>
                                <option value="post" >Blog Post</option>
                                <option value="setting" >SMPT setting</option>
                                <option value="site" >site setting</option>
                                <option value="role" >Role y Permisssion</option>
                            </select>    
                        </div>
                        
                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                    </form>
                </div>
              </div>
        </div>
      </div>
      <!-- middle wrapper end -->
      <!-- right wrapper start -->
      
      <!-- right wrapper end -->
    </div>

        </div>
          

    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    aminities_name: {
                        required : true,
                    },                
                },
                messages :{
                    aminities_name: {
                        required : 'Please Enter Aminities Name',
                    }, 
                        
    
                },
                errorElement : 'span', 
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection