<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="application/javascript">
	(function ($) {
		'use strict';
		$(function () {
			let datatable = $('.datatable');
			$(document).ready(function () {
				<?php //DISPLAY TABLE USING JQUERY DATATABLE LIBRARY ?>
				var dt = $('body').find('.datatable').DataTable({
					bPaginate: true,
					bLengthChange: true,
					bFilter: true,
					bSort: true,
					bInfo: true,
					bAutoWidth: false,
					serverSide: true,
					processing: true,
					ajax: '<?=site_url('sepeda_motor/publish?dt=true')?>',
					columnDefs: [
						{
							'searchable': false,
							'filterable': false,
							'sortable': false,
							'targets': 0,
						}
					],
					columns: [
						{'data': 'id_motor'},
						{'data': 'merek'},
						{'data': 'tipe'},
						{'data': 'harga'},
						{'data': 'tangki'},
						{'data': 'kecepatan'},
						{'data': 'transmisi'},
						{'data': 'bagasi'},
						{'data': 'berat'},
						{'data': 'warna'},
					],
					aLengthMenu: [
						[5, 10, 15, -1],
						[5, 10, 15, "Semua"]
					],
					iDisplayLength: 10,
					language: {
						search: ""
					},
					dom: 'Blfrtip',
					buttons: [{
						extend: 'excelHtml5',
						title: '<?=$judul_laporan?>',
						footer: true,
						exportOptions: {
							columns: 'th:not(.hidden-print)'
						}
					}, {
						extend: 'pdfHtml5',
						title: '<?=$judul_laporan?>',
						footer: true,
						exportOptions: {
							columns: 'th:not(.hidden-print)'
						}
					}, {
						extend: 'print',
						footer: true,
						title: '<?=$judul_laporan?>',
						exportOptions: {
							columns: 'th:not(.hidden-print)'
						}
					}]
				});

				<?php //RENDER ROW NUMBER ?>
				dt.on('order.dt search.dt draw.dt', function () {
					dt.column(0, {
						search: 'applied',
						order: 'applied',
						draw: 'applied'
					}).nodes().each(function (cell, i) {
						let info = dt.page.info();
						let page = info.page;
						let len = info.length;
						cell.innerHTML = (page * len) + (i + 1);
					});
				});

				<?php //DATATABLE TOOLS DISPLAY ?>
				datatable.each(function () {
					let datatable = $(this);
					// SEARCH - Add the placeholder for Search and Turn this into in-line form control
					let search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
					search_input.attr('placeholder', 'Cari');
					search_input.addClass('mx-5');
					search_input.removeClass('form-control-sm');
					// LENGTH - Inline-Form control
					let length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
					length_sel.removeClass('form-control-sm');
					datatable.closest('.dataTables_wrapper').find('.dataTables_length').addClass('position-relative');
					datatable.closest('.dataTables_wrapper').find('.dataTables_length').addClass('float-right');
					datatable.closest('.dataTables_wrapper').find('.dataTables_length').addClass('mx-auto');
					datatable.closest('.dataTables_wrapper').find('.dataTables_length').addClass('mx-auto');
				});
			});
		});
	})(jQuery);
</script>
