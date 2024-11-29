<!DOCTYPE html>
<html>
@php
$userm='menu-open';
$umanagement=$mrole='active';
@endphp
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

    <section class="content">

      <div class="container-fluid">
      <form action="{{url('role_store')}}" method='post' enctype="multipart/form-data">
      @csrf
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
        
          <div class="card-header">
          <h2 class="card-title"><b>Role Details</b></h2>
              <a type="button" href='{{url("roles")}}' class="btn btn-sm btn-primary float-right">Roles List</a>
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
                  <label>Role Name: {{$role->name}}</label>
                 

                </div>
                <!-- /.form-group -->
               
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
        
              <!-- /.col -->
            </div>
            <!-- /.row -->

  
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label>Role Permissions</label>
                  <div class="select2-purple">
                  <div class="row">
                  @if(!empty($rolePermissions))
                  @foreach($rolePermissions as $v)
                    <div class="col-3"> 
                    <label class="label label-success"><b>{{ $v->name }}</b></label>
                    </div>
                 @endforeach
                  @endif
             
                  </div>
 
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
         
          </div>
      
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
@include('layouts.admin.formfooter')
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
