<!DOCTYPE html>
<html>
@php
$userm='menu-open';
$umanagement=$muser='active';
@endphp
@include('layouts.admin.tableheader')
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
@include('layouts.admin.nav')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
@include('layouts.admin.aside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
    
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h2 class="card-title">List Of All Users</h2>
              <a type="button"  href="{{url('user_add')}}"class="btn btn-sm btn-primary float-right">add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  {!! session('error') !!}
                </div>
             @endif
            @if (Session::has('feedback'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  {!! session('feedback') !!}
                </div>
             @endif
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <!-- <th>Phone</th> -->
                  <th>Email</th>
                  <th>Role(s)</th>
              
                  <th>Action</th>
                </tr>
                </thead>
                <tbody> 
                @foreach($users as $row)
                <tr>
                  <td>{{$row->id}}</td>
                  <td>{{$row->name}}
                  </td>
                  <!-- <td>{{$row->phone}}</td> -->
                  <td> {{$row->email}}</td>
             
                 <td>  
                 @if(!empty($row->getRoleNames()))
                    @foreach($row->getRoleNames() as $v)
                      <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                  @endif
                  </td>
                 
    
                  <td>  <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-primary">Action</button>
                    <button type="button" class="btn btn-sm  btn-primary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown"></button>
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="dropdown-menu" role="menu">
                        <!-- <a type="button" class="dropdown-item btn btn-danger" data-toggle="modal" value="<?php echo $row->id; ?>" onclick='f1(<?php echo $row->id; ?>)' data-target="#modal-danger">
                           Edit</a> -->
                           <form method='post' action='{{url("user_edit")}}'>
                           @csrf
                           <input type='hidden' name='user_id' value='{{$row->id}}'>
                           <input type='submit' class="dropdown-item btn btn-danger"  name='Edit' value='Edit'>

                           </form>
                           <!-- <a type="button" class="dropdown-item btn btn-danger">
                           Edit</a> -->
                      
                      
                      </div>
                    </div></td>
                </tr>
                @endforeach
                </tbody>
                <!-- <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot> -->
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@include('layouts.admin.foot')

@include('layouts.admin.tablefooter')
</body>
</html>
