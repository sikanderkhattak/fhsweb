@php
    $administrationm = 'menu-open';
    $amanagement = $mcourses = 'active';
@endphp

<!DOCTYPE html>
<html>
@include('layouts.admin.formheader')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.admin.nav')
        <!-- Main Sidebar Container -->
        @include('layouts.admin.aside')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Display -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Start -->
                    <form action="{{ isset($blog) ? url('blogs-update/' . $blog->id) : url('blogs-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-default">
                            <div class="card-header">
                                <h2 class="card-title"><b>{{ isset($blog) ? 'Edit Blog' : 'Add Blog' }}</b></h2>
                                <a type="button" href="{{ url('blogs') }}" class="btn btn-sm btn-primary float-right">
                                    Blogs List
                                </a>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-remove"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <div class="row">
                                    <!-- Blog Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Blog Name</label>
                                            <input type="hidden" name="id" value="{{ old('id') ?? $blog->id ?? '' }}">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') ?? $blog->name ?? '' }}" required>
                                        </div>
                                    </div>

                                    <!-- Blog Description -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" name="description">{{ old('description') ?? $blog->description ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Blog Image -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image">
                                            @if (isset($blog) && $blog->image)
                                                <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <input type="submit" class="btn btn-primary mt-2" value="{{ isset($blog) ? 'Update' : 'Submit' }}">
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                    <!-- Form End -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('layouts.admin.foot')
    </div>
    <!-- ./wrapper -->

    @include('layouts.admin.formfooter')
</body>
</html>
