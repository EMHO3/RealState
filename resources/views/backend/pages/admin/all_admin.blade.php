@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{route('add.admin')}}" class="btn btn-inverse-info">Add Admin</a>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Admin All</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alladmin as $key=>$item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <img src="{{(!empty($item->photo)) ? url('upload/admin_images/'.$item->photo):url('upload/no_image.png')}}" style="width:70px;height:40px">
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td>Role</td>
                                        <td>
                                            <a href="{{route('edit.roles',$item->id)}}" class="btn-btn-inverse-warning" title="Edit"><i data-feather="edit"></i></a>
                                            <a href="{{route('edit.roles',$item->id)}}" class="btn-btn-inverse-danger" title="Delete"><i data-feather="delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection