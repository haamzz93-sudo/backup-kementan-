<style>
    .ctr{
        margin-top:25px;
    }
    table{
        width:100%
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
  
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css"/>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.4/dataRender/percentageBars.js"></script>


<div class="ctr">
    <h3 class="text-center" style="font-weight:bold">Tabel Progress Perbanyakan Benih</h3>
</div>
<table id="example" class="display" style="width:100%">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Provinsi</th>
			<th>Progress</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			      <td>1</td>
            <td>Nama Provinsi</td>
            <td>100%</td>
		</tr>
	</tbody>
</table>

<script>
    /* Parameters for percentageBars renderer:
1.string: square as default or round for a rounded bar.
2.string: A hex color for the text.
3.string: A hex color for the bar.
5.string: A hex color for the background.
6.integer: A number used to round the value.
7.string: A border style, default=ridge (solid, outset, groove, ridge)
*/

$(document).ready(function() {
  // DataTable initialisation
  $('#example').DataTable({
    "dom": '<"dt-buttons"Bf><"clear">irtp',
    "paging": true,
    "autoWidth": true,
    "columnDefs": [{
      targets: 2,
      render: $.fn.dataTable.render.percentBar('round','#fff', '#FF9CAB', '#FF0033', '#FF9CAB', 0, 'solid')
    }],
    "buttons": [
				'colvis',
				'copyHtml5',
        'csvHtml5',
				'excelHtml5',
        'pdfHtml5',
				'print'
			]
  });
});
</script>