
<!DOCTYPE html>
<html>
@php
$userm='menu-open';
$umanagement=$muser='active';
@endphp
@include('layouts.admin.tableheader')
<body class="hold-transition sidebar-mini">
<div class="wrapper">
@include('layouts.admin.nav')

@include('layouts.admin.aside')

  <div class="content-wrapper">
   
    <section class="content">
      <div class="row">
        <div class="col-12">
    

          <div class="card">
            <div class="card-header">
              <h2 class="card-title">List Of All sliders</h2>
              <a type="button"  href="{{url('slider_images-create')}}"class="btn btn-sm btn-primary float-right">add New</a>
            </div>
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
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </thead>
                <tbody>
                    @foreach($sliderImages as $image)
                        <tr>
                            <td>{{ $image->id }}</td>
                            <td><img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" style="width: 100px; height: auto;"></td>
                            <td>{{ $image->title ?? 'No title' }}</td>
                            <td>{{ $image->description ?? 'No description' }}</td>
                            
                            <td>
                                <a href="{{ route('slider_images.edit', $image->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('slider_images.destroy', $image->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
               
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
