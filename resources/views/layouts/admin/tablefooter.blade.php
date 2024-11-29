  <!-- Control Sidebar -->

  <aside class="control-sidebar control-sidebar-dark">

    <!-- Control sidebar content goes here -->

  </aside>

  <!-- /.control-sidebar -->

</div>

<!-- ./wrapper -->



<!-- jQuery -->



<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('adminlte/loader.js')}}"></script>



<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>



<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>

<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>



<script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>



<script src="{{asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>

<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>



<script src="{{asset('adminlte/dist/js/demo.js')}}"></script>





<!-- <script src="{{asset('adminlte/dist/jquery/jquery.min.js')}}"></script>



<script src="{{asset('adminlte/dist/bootstrap/js/bootstrap.bundle.min.js')}}"></script>



<script src="{{asset('adminlte/dist/sweetalert2/sweetalert2.min.js')}}"></script>



<script src="{{asset('adminlte/dist/toastr/toastr.min.js')}}"></script>



<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>



<script src="{{asset('adminlte/dist/js/demo.js')}}"></script> -->









<script>

  $(function () {

    $("#example1").DataTable();

    $('#example2').DataTable({

      "paging": true,

      "lengthChange": false,

      "searching": false,

      "ordering": true,

      "info": true,

      "autoWidth": false,

    });

  });

</script>

<script>

  $(function () {

    $(".example1").DataTable();

    $('.example2').DataTable({

      "paging": true,

      "lengthChange": false,

      "searching": false,

      "ordering": true,

      "info": true,

      "autoWidth": false,
       // select: {
       //      style: 'multi'
       //  }

    });

  });

</script>
<script>
function showLoading() {
  document.querySelector('#loading').classList.add('loading');
  document.querySelector('#loading-content').classList.add('loading-content');
}

function hideLoading() {
  document.querySelector('#loading').classList.remove('loading');
  document.querySelector('#loading-content').classList.remove('loading-content');
}
</script>

