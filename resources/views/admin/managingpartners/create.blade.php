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
                    <form action="{{ isset($partner) ? url('managingpartners-update/' . $partner->id) : url('managingpartners-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-default">
                            <div class="card-header">
                                <h2 class="card-title"><b>{{ isset($partner) ? 'Edit Partner' : 'Add Partner' }}</b></h2>
                                <a type="button" href="{{ url('managingpartners') }}" class="btn btn-sm btn-primary float-right">
                                    Partner List
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
                                    <!-- Partner Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Partner Name</label>
                                            <input type="hidden" name="id" value="{{ old('id') ?? $partner->id ?? '' }}">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') ?? $partner->name ?? '' }}" required>
                                        </div>
                                    </div>

                                    <!-- Partner Description -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" name="description">{{ old('description') ?? $partner->description ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Partner Heading -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Heading</label>
                                            <input type="text" class="form-control" name="heading"
                                                value="{{ old('heading') ?? $partner->heading ?? '' }}">
                                        </div>
                                    </div>

                                    <!-- Partner Image -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image">
                                            @if (isset($partner) && $partner->image)
                                                <img src="{{ asset('storage/' . $partner->image) }}" alt="Partner Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <input type="submit" class="btn btn-primary mt-2" value="{{ isset($partner) ? 'Update' : 'Submit' }}">
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
