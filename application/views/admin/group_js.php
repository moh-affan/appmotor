<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="application/javascript">
	(function ($) {
		'use strict';
		$(function () {
			let datatable = $('.datatable');
			let formCreate = $('#form-create');
			let formEdit = $('#form-edit');
			let formRemove = $('#form-remove');
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
					ajax: '<?=site_url('admin/pengguna/publish_group?dt=true')?>',
					columnDefs: [
						{
							'searchable': false,
							'filterable': false,
							'sortable': false,
							'targets': 0,
						}, {
							'render': function (data, type, row) {
								return '<div class="text-center"><div class="btn-group" role="group" aria-label="Action Buttons">' +
									'<a class="btn btn-outline-primary edit-button btn-sm" data-toggle="modal" data-target="#edit" data-groupid="' + row.id + '" href="#"><span class="text-small fa fa-pencil-square-o"></span></a>' +
									'<a class="btn btn-outline-danger remove-button btn-sm" data-groupid="' + row.id + '" href="#"><span class="text-small fa fa-trash-o"></span></a>' +
									'</div></div>';
							},
							'targets': 3
						}
					],
					columns: [
						{'data': 'id'},
						{'data': 'name'},
						{'data': 'description'},
						{'data': ''},
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
				dt.on('order.dt search.dt', function () {
					dt.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
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

				<?php //EDIT BUTTON ?>
				datatable.on('click', '.edit-button', function () {
					let that = $(this);
					let id = that.data('groupid');
					$.get('<?=site_url('admin/pengguna/publish_group?id=')?>' + id)
						.done(function (d) {
							$('.edit-progress').addClass('d-none');
							formEdit.find('#e_group_name').val(d.name);
							formEdit.find('#e_description').val(d.description);
							formEdit.find('#edit').val(d.id);
						});
				});

				<?php //ON MODAL HIDDEN, RESET FORM ?>
				$('#edit').on('hidden.bs.modal', function () {
					$('.edit-progress').removeClass('d-none');
					formEdit.trigger('reset');
				});

				<?php //ON CLICK REMOVE BUTTON ?>
				datatable.on('click', '.remove-button', function () {
					let that = $(this);
					let id = that.data('groupid');
					formRemove.find('#remove_id').val(id);
					swal({
						title: 'Apa Anda yakin ingin menghapus ?',
						text: '',
						icon: 'warning',
						buttons: {
							cancel: {
								text: "Tidak",
								value: null,
								visible: true,
								className: "btn btn-danger",
								closeModal: true,
							},
							confirm: {
								text: "Ya",
								value: true,
								visible: true,
								className: "btn btn-primary",
								closeModal: true
							}
						}
					}).then(function (isConfirm) {
						if (isConfirm) {
							formRemove.find('#remove_id').val(id);
							let data = formRemove.serialize();
							$.post(formRemove.attr('action'), data)
								.done(function (d) {
									console.log(d);
									window.location.reload(false);
								})
								.fail(function (d) {
									console.log(d);
									swal({
										title: "Gagal!",
										text: "Gagal menghapus data pengguna",
										icon: "warning",
										timer: 3000
									});
								})
								.always(function () {
									formRemove.find('#remove_id').val('');
								});
							formRemove.trigger('reset');
						}
					})
				});

				<?php //VALIDATE FORM CREATE ?>
				let rules = {
					group_name: "required",
				};
				let errorMessage = {
					group_name: "Masukkan nama grup yang akan dibuat",
				};

				let errPlacement = function (label, element) {
					label.addClass('mt-2 text-danger');
					label.insertAfter(element);
				};

				let valitaionHighlight = function (element, errorClass) {
					$(element).parent().addClass('has-danger');
					$(element).addClass('form-control-danger');
				};

				let validationUnhighlight = function (element, errorClass) {
					$(element).parent().removeClass('has-danger');
					$(element).removeClass('form-control-danger');
				};

				<?php //SUBMIT CREATE NEW USER ?>
				let createSubmitHandler = function (form) {
					let frm = $(form);
					let data = frm.serialize();
					let url = frm.attr('action');
					$('.create-progress').removeClass('d-none');
					$.post(url, data).done(function (d) {
						console.log(d);
						if (d.success)
							swal({
								title: "Berhasil!",
								text: "Data berhasil ditambah.",
								icon: "success",
								timer: 2000,
								button: false
							}).then(function () {
								window.location.reload(false);
							}, function (dismiss) {
								if (dismiss === 'timer')
									window.location.reload(false);
							});
						else
							swal({
								title: "Gagal!",
								text: d.message,
								icon: "warning",
								timer: 3000
							});
					}).fail(function (d) {
						swal({
							title: "Gagal!",
							text: "Gagal melakukan transaksi",
							icon: "warning",
							timer: 3000
						});
						console.log(d);
					}).always(function (d) {
						$('.create-progress').addClass('d-none');
						console.log(d);
					});
				};

				<?php //SUBMIT EDIT USER ?>
				let editSubmitHandler = function (form) {
					let frm = $(form);
					let data = frm.serialize();
					let url = frm.attr('action');
					$('.edit-progress').removeClass('d-none');
					$.post(url, data).done(function (d) {
						console.log(d);
						if (d.success)
							swal({
								title: "Berhasil!",
								text: "Data berhasil diubah.",
								icon: "success",
								timer: 2000,
								button: false
							}).then(function () {
								window.location.reload(false);
							}, function (dismiss) {
								if (dismiss === 'timer')
									window.location.reload(false);
							});
						else
							swal({
								title: "Gagal!",
								text: d.message,
								icon: "warning",
								timer: 3000
							});
					}).fail(function (d) {
						swal({
							title: "Gagal!",
							text: "Gagal melakukan transaksi",
							icon: "warning",
							timer: 2000
						});
						console.log(d);
					}).always(function (d) {
						$('.edit-progress').addClass('d-none');
						console.log(d);
					});
				};

				<?php //VALIDATE FORM CREATE ?>
				formCreate.validate({
					submitHandler: createSubmitHandler,
					rules: rules,
					messages: errorMessage,
					errorPlacement: errPlacement,
					highlight: valitaionHighlight,
					unhighlight: validationUnhighlight
				});

				<?php //VALIDATE FORM EDIT ?>
				formEdit.validate({
					submitHandler: editSubmitHandler,
					rules: rules,
					messages: errorMessage,
					errorPlacement: errPlacement,
					highlight: valitaionHighlight,
					unhighlight: validationUnhighlight
				});
			});
		});
	})(jQuery);
</script>
