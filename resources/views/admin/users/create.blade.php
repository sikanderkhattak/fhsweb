@php
$userm='menu-open';
$umanagement=$muser='active';
@endphp
@include('layouts.admin.formheader');
<!DOCTYPE html>
<html>
@include('layouts.admin.formheader');
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

      <div class="container-fluid">
      @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
      <form action="{{url('user_store')}}" method='post' enctype="multipart/form-data">
      @csrf
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
        
          <div class="card-header">
          <h2 class="card-title"><b>User Add</b></h2>
              <a type="button" href='{{url("users")}}' class="btn btn-sm btn-primary float-right">Users List</a>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
         
          <div class="card-body">
        
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type='text' name='name' value='{{old("name")}}' required class='form-control'>
                  <!-- <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select> -->
                </div>
                <!-- /.form-group -->
               
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email</label>
                  <input type='email' required name='email' value='{{old("email")}}' required class='form-control'>
                </div>
                <!-- /.form-group -->
            
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

  
            <div class="row">

   
              <!-- /.col -->
              <div class="col-12 col-sm-6">
            
                <div class="form-group">
                  <label>Password</label>
                  <input type='password' required name='password' value='{{old("password")}}' required class='form-control'>
                </div>
                <!-- /.form-group -->
            
                <!-- /.form-group -->
              </div>
              <div class="col-6">
                <div class="form-group">

                  <label>Re-enter Password</label>
                  <div class="select2-purple">
                    <input type='password' name='password_confirmation' class='form-control' required>
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
        <div class='row'>

            <div class="col-6">
                <div class="form-group">

                  <label>Role</label>
                  <div class="select2-purple">
                  {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                  </div>
                </div>
                <!-- /.form-group -->
              </div>

              <div class="col-6">
                <div class="form-group">

                  <label>Status</label>
                  <div class="select2-purple">
                    <select class="select2" name='status_id' data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">
                      @foreach($statuses as $row)
                      <option value='{{$row->id}}'>{{$row->status_name}}</option>

                      @endforeach
                  
                    </select>
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              </div>
            <!-- /.row -->
            <input type='submit' class='btn btn-primary' value='submit'>
          </div>
          <!-- /.card-body -->
          <!-- <div class="card-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin.
          </div> -->
      
        </div>
        <!-- /.card -->

        <!-- SELECT2 EXAMPLE -->
    
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <!-- <div class="card-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin.
          </div> -->
        </div>
        <!-- /.card -->

   
        <!-- /.card -->

        <!-- /.row -->
       

        </form>
      </div><!-- /.container-fluid -->
    </section>
@include('layouts.admin.foot')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('layouts.admin.formfooter');
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
</body>
</html>
