<script src="{{ asset('template-admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('template-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('template-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('template-admin/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('template-admin/vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('template-admin/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('template-admin/js/demo/chart-pie-demo.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js
"></script>
{{-- <script src="{{ asset('template-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
<script src="{{ asset('template-admin/js/demo/datatables-demo.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- JSZip dan pdfmake untuk export Excel/PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script>
    $(document).ready(function() {
    var interval = setInterval(function() {
        var momentNow = moment();
        let tanggal = momentNow.format("DD ")
        let bulan = momentNow.format("MMMM YYYY")
        let jam = momentNow.format("hh:mm:ss A")
        let realtimedate = `${tanggal} ${bulan} ${jam}`
        console.log(realtimedate)
        $("#realtime_date").html(`${realtimedate}`)
        // $("#date-part").html();
        // $("#day-part").html(
        // momentNow
        //     .format("dddd")
        //     .substring(0, 3)
        //     .toUpperCase()
        // );
        // $("#month-part").html();
        // $("#time-part").html();
    }, 100);
    });
</script>
<script>
    @if(session()-> has('success'))
        swal({
            type: "success",
            icon: "success",
            title: "BERHASIL!",
            text: "{{ session('success') }}",
            timer: 3500,
            showConfirmButton: false,
            showCancelButton: false,
            buttons: false,
        });
        @elseif(session()-> has('error'))
        swal({
            type: "error",
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            
            showConfirmButton: true,
            showCancelButton: false,
            buttons: true,
        });
        @endif
</script>

@stack('scripts')