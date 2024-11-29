<!DOCTYPE html>
<html>
@php
$administrationm = 'menu-open';
$amanagement = $mcourses = 'active';
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
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">List of Managing Partners</h2>
              <a type="button" href="{{ url('managingpartners/create') }}" class="btn btn-sm btn-primary float-right">Add New</a>
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

              <div class="table-responsive">
                <table id="managing-partners-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Heading</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach($managingpartners as $row)
                  <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $row->name }}</td>
                      <td>{{ $row->description }}</td>
                      <td>{{ $row->heading }}</td>
                      <td>
                        @if($row->image)
                          <img src="{{ asset('storage/'.$row->image) }}" alt="Image" style="width: 80px; height: 60px;">
                        @endif
                      </td>
                      <td>
                        <a type="button" class="btn btn-sm btn-primary" href="{{ route('managingpartners.edit', $row->id) }}">Edit</a>
                      </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
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

  <script>
  $(document).ready(function() {
    // Initialize DataTable on load
    $('#managing-partners-table').DataTable();
  });
  </script>
</body>
</html>
