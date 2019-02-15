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
			let formAct = $('#form-act');
			let formReset = $('#form-reset');
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
					ajax: '<?=site_url('admin/pengguna/publish?dt=true')?>',
					columnDefs: [
						{
							'searchable': false,
							'filterable': false,
							'sortable': false,
							'targets': 0,
						}, {
							'render': function (data, type, row) {
								let act = 'Aktifkan';
								if (row.active === '1')
									act = 'Non Aktifkan';
								let ret = '<div class="text-center"><div class="btn-group" role="group" aria-label="Action Buttons">' +
									'<a class="btn btn-outline-primary edit-button btn-sm" data-toggle="modal" data-target="#edit" data-userid="' + row.id + '" href="#"><span class="text-small fa fa-pencil-square-o"></span></a>' +
									'<a class="btn btn-outline-danger remove-button btn-sm" data-userid="' + row.id + '" href="#"><span class="text-small fa fa-trash-o"></span></a>' +
									'</div></div>';
								ret += '<div class="text-center"><div class="btn-group-vertical" role="group" aria-label="Action Buttons">';
								ret += '<a class="btn btn-outline-danger btn-block btn-xs act-button" data-userid="' + row.id + '" href="#">' + act + '</a>';
								ret += '<a class="btn btn-outline-secondary btn-block btn-xs mt-0 reset-button" data-userid="' + row.id + '" href="#"> Reset Password</a>';
								ret += '</div></div>';
								return ret;
							},
							'targets': 6
						},
						{
							'render': function (data) {
								let ret = '<div class="badge mx-auto badge-success badge-pill status" data-active="' + data + '">AKTIF</div>';
								if (data !== '1')
									ret = '<div class="badge mx-auto badge-dark badge-pill status" data-active="' + data + '">NON AKTIF</div>';
								return ret;
							},
							'targets': 5
						}
					],
					columns: [
						{'data': 'id'},
						{'data': 'first_name'},
						{'data': 'email'},
						{'data': 'phone'},
						{'data': 'username'},
						{'data': 'active'},
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
					let id = that.data('userid');
					$.get('<?=site_url('admin/pengguna/publish?id=')?>' + id)
						.done(function (d) {
							$('.edit-progress').addClass('d-none');
							formEdit.find('#e_firstname').val(d.first_name);
							formEdit.find('#e_username').val(d.username);
							formEdit.find('#e_email').val(d.email);
							formEdit.find('#e_phone').val(d.phone);
							formEdit.find('#edit').val(d.id);
							Object.keys(d.groups).forEach(function (k) {
								const dd = d.groups[k];
								$('#' + dd.name).attr('checked', 'checked');
							});
						});
				});

				<?php //ON MODAL HIDDEN, RESET FORM ?>
				$('#edit').on('hidden.bs.modal', function () {
					$('.edit-progress').removeClass('d-none');
					formEdit.find('input[type=checkbox]').removeAttr('checked');
					formEdit.trigger('reset');
				});

				<?php //ON CLICK REMOVE BUTTON ?>
				datatable.on('click', '.remove-button', function () {
					let that = $(this);
					let id = that.data('userid');
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
					first_name: "required",
					identity: {
						required: true,
						minlength: 6
					},
					password: {
						required: true,
						minlength: 8
					},
					confirm_password: {
						required: true,
						minlength: 8,
						equalTo: "#password"
					},
					email: {
						required: true,
						email: true
					},
					phone: {
						required: true,
						minlength: 10,
						maxlength: 15,
						digits: true
					}
				};
				let errorMessage = {
					first_name: "Masukkan nama Anda",
					identity: {
						required: "Masukkan username",
						minlength: "Username minimal 6 karakter"
					},
					password: {
						required: "Masukkan password",
						minlength: "Password minimal 8 karakter"
					},
					confirm_password: {
						required: "Ulangi password",
						minlength: "Password minimal 8 karakter",
						equalTo: "Password tidak sama"
					},
					email: "Masukkan alamat email yang valid",
					phone: "Masukkan nomor hp yang valid",
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

				<?php //ACTIVATE/DEACTIVATE BUTTON ?>
				datatable.on('click', '.act-button', function () {
					let that = $(this);
					let active = that.parents('tr').find('.status').data('active');
					let strActive = 'mengaktifkan';
					if (active === 1)
						strActive = 'menon-aktifkan';
					let id = that.data('userid');
					formAct.find('#act_id').val(id);
					formAct.find('#act_id').attr('name', 'activate_id');
					if (active === 1)
						formAct.find('#act_id').attr('name', 'deactivate_id');
					swal({
						title: 'Apa Anda yakin ingin ' + strActive + ' user ini ?',
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
							formAct.find('#act_id').val(id);
							let data = formAct.serialize();
							console.log(data);
							$.post(formAct.attr('action'), data)
								.done(function (d) {
									console.log(d);
									window.location.reload(false);
								})
								.fail(function (d) {
									console.log(d);
									swal({
										title: "Gagal!",
										text: "Gagal " + strActive + " data pengguna",
										icon: "warning",
										timer: 3000
									});
								})
								.always(function () {
									formAct.find('#act_id').val('');
								});
							formAct.trigger('reset');
						}
					});
				});

				<?php //RESET PASSWORD BUTTON ?>
				datatable.on('click', '.reset-button', function () {
					let that = $(this);
					let id = that.data('userid');
					formReset.find('#reset_id').val(id);
					swal({
						title: 'Apa Anda yakin ingin mereset password user ini ?',
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
						formReset.find('#reset_id').val(id);
						if (isConfirm) {
							let data = formReset.serialize();
							$.post(formReset.attr('action'), data)
								.done(function (d) {
									console.log(d);
									swal({
										title: "Berhasil!",
										text: "Password telah direset menjadi:\n p@55w0Rd",
										icon: "success",
										timer: 2000,
										button: false
									}).then(function () {
										window.location.reload(false);
									}, function (dismiss) {
										if (dismiss === 'timer')
											window.location.reload(false);
									});
								})
								.fail(function (d) {
									console.log(d);
									swal({
										title: "Gagal!",
										text: "Gagal mereset password pengguna",
										icon: "warning",
										timer: 3000
									});
								})
								.always(function () {
									formReset.find('#reset_id').val('');
								});
							formReset.trigger('reset');
						}
					});
				});
			});
		});
	})(jQuery);
</script>
