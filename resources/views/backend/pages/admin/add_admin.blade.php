@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="page-content">
        <div class="row profile-body">
            <div class="col-md-8 col-xl-8 middle-wraper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Add Admin </h6>
                            <form id="myForm" method="POST" action="{{route('store.admin')}}" class="forms-sample">
                                @csrf
                                   <div class="form-group mb-3">
                                     <label for="exampleInputEmail" class="form-label">Admin User name</label>
                                     <input type="text" name="username" class="form-control">
                                   </div>
                                   <div class="form-group mb-3">
                                    <label for="exampleInputEmail" class="form-label">Admin  name</label>
                                    <input type="text" name="name" class="form-control">
                                   </div>
                                   <div class="form-group mb-3">
                                     <label for="exampleInputEmail"  class="form-label">Admin Email</label>
                                     <input type="email" name="email" class="form-control">   
                                   </div>
                                   <div class="form-group mb-3">
                                    <label for="exampleInputEmail"  class="form-label">Admin phone</label>
                                    <input type="text" name="phone" class="form-control">   
                                  </div>
                                  <div class="form-group mb-3">
                                    <label for="exampleInputEmail"  class="form-label">Admin address</label>
                                    <input type="text" name="address" class="form-control">   
                                  </div>
                                  <div class="form-group mb-3">
                                    <label for="exampleInputEmail"  class="form-label">Admin Password</label>
                                    <input type="password" name="password" class="form-control">   
                                  </div>
                                  <div class="form-group mb-3">
                                    <label for="exampleInputEmail"  class="form-label"> Role Name</label>
                                    <select name="roles" class="form-select" id="exampleFormControlSelect1">
                                        <option selected="" disabled="">Selected Role</option>
                                        @foreach ($roles as $role)                                    
                                          <option value="{{$role->id}}" >{{$role->name}}</option>
                                        @endforeach                             
                                    </select>                                    
                                  </div>
                                  <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection