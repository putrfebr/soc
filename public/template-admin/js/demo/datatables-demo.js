// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
      'copy',
      {
        extend: 'csv',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdfHtml5',
        orientation: 'landscape', // landscape biar lebih lebar
        pageSize: 'A3', // A3 biar semua kolom muat, atau ganti ke ukuran manual
        exportOptions: {
          columns: ':visible'
        },
        customize: function (doc) {
          // Lebar otomatis semua kolom
          var colCount = doc.content[1].table.body[0].length;
          doc.content[1].table.widths = new Array(colCount).fill('*');

          // Styling tambahan
          doc.styles.tableHeader.alignment = 'left';
          doc.defaultStyle.fontSize = 9; // Bisa dikecilkan jadi 8 jika tetap kepotong
          doc.pageMargins = [20, 20, 20, 20]; // Margin PDF (kiri, atas, kanan, bawah)
        }
      },
      {
        extend: 'print',
        exportOptions: {
          columns: ':visible'
        },
        customize: function (win) {
          $(win.document.body).css('font-size', '10pt')
            .find('table')
            .addClass('compact')
            .css('font-size', 'inherit')
            .css('width', '100%');
        }
      }
    ]
  });
});
