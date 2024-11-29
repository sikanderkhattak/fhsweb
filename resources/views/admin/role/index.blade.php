<!DOCTYPE html>
<html>
@php
$userm='menu-open';
$umanagement=$mrole='active';
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
  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
    
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h2 class="card-title">List Of All Roles</h2>
              <a type="button"  href="{{url('role_add')}}"class="btn btn-sm btn-primary float-right">add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Role Name</th>
           
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $row)
                <tr>
                  <td>{{$row->id}}</td>
                  <td>{{$row->name}}
                  </td>
                  <td>  <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-primary">Action</button>
                    <button type="button" class="btn btn-sm  btn-primary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown"></button>
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="dropdown-menu" role="menu">
                      <a type="button" class="dropdown-item btn btn-danger" href='{{url("role-edit/".$row->id)}}'>
                           Role Edit</a>
                           <a type="button" class="dropdown-item btn btn-danger" href='{{url("role-permissions/".$row->id)}}'>
                           Role Permissions</a>
                      
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
