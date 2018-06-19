<!--data tables JS-->
<script src="../application/assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="../application/assets/js/datatables/dataTables.bootstrap.min.js"></script>
<script src="../application/assets/js/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="../application/assets/js/datatables/jszip.min.js"></script>
<script src="../application/assets/js/datatables/pdfmake.min.js"></script>
<script src="../application/assets/js/datatables/vfs_fonts.js"></script>
<script src="../application/assets/js/datatables/extensions/Buttons/js/buttons.html5.js"></script>
<script src="../application/assets/js/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
<script>
	$(document).ready(function () {
		$('.dataTables-example').DataTable({
			dom: '<"html5buttons" B>lTfgitp',
			buttons: [
				{
					extend: 'copyHtml5',
					exportOptions: {
						columns: [ 0, ':visible' ]
					}
				},
				{
					extend: 'excelHtml5',
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'pdfHtml5',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				},
				'colvis'
			]
		});
	});
</script>
