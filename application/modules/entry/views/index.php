<!--begin:: Widgets/Download Files-->
<?php

$action_stub = 3;
$combinations = pow(2, $condition_stub);
$half = $combinations;
$trueFlag = true;
$counter = 0;
$arr = array();
//main logic
for ($i = 0; $i < $condition_stub; $i++) {
	$half = $half / 2;
	for ($x = 0; $x < $combinations; $x++) {
		if ($trueFlag) {
			$arr[$i][$x] = true;
		} else {
			$arr[$i][$x] = false;
		}
		if ($counter == ($half - 1) && $trueFlag == true) {
			$trueFlag = false;
			$counter = 0;
		} elseif ($counter == ($half - 1) && $trueFlag == false) {
			$trueFlag = true;
			$counter = 0;
		} else {
			$counter++;
		}
	}
}
?>
<div class="kt-portlet kt-portlet--height-fluid">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
			<span class="ml-2">Action Entry Devisi <?= $nama_devisi ?></span>
			</h3>
		</div>
		<!-- <div class="kt-portlet__head-toolbar">
				<?php echo $this->sys->btn_dt_add('dt_add(this)', 'Tambah') ?>
			</div> -->
	</div>
	<div class="kt-portlet__body">
		<div class="mt-3 table-responsive">
			<h4>n = condition stub = <?= $condition_stub ?></h4>
			<h4>rule = 2<sup><?= $condition_stub ?></sup> = <?= $combinations ?></h4>
			<!-- write table -->
			<form action="<?= base_url('entry/submit') ?>" method="post">
			<input type="hidden" value="<?= $devisi ?>" name="devisi_id">
			<input type="hidden" value="<?= $combinations ?>" name="combinations">
				<button class="btn btn-success float-right mb-3" id="submit">Submit</button>
				<table class="table table-bordered table-inverse table-hover">
					<thead bgcolor="#1E1E2D" style="color: #fff">
						<?php for ($j = 0; $j < 1; $j++) : ?>
							<th class='text-center align-middle'>CONDITION STUB</th>
							<?php for ($k = 1; $k <= $combinations; $k++) : ?>
								<th class='text-center align-middle'> Rule <?= $k ?> </th>
							<?php endfor ?>
						<?php endfor; ?>
					</thead>
					<?php for ($x = 0; $x < $condition_stub; $x++) : ?>
						<tbody>
							<th><?= $condition[$x]->condition ?> </th>
							<?php for ($i = 0; $i < $combinations; $i++) : ?>
								<?php if ($arr[$x][$i]) : ?>
									<td class='text-center align-middle'><input type='text' name='cond[<?= $condition[$x]->id ?>][<?= $i ?>]' class='form-control border-0' value='1' readonly></td>
								<?php else : ?>
									<td class='text-center align-middle'><input type='text' name='cond[<?= $condition[$x]->id ?>][<?= $i ?>]' class='form-control border-0' value='0' readonly></td>
								<?php endif; ?>
							<?php endfor; ?>
						<?php endfor; ?>

						<thead bgcolor='#1E1E2D' style='color: #fff'>
							<?php for ($j = 0; $j < 1; $j++) : ?>
								<th class='text-center align-middle'>ACTION STUB</th>
								<?php for ($k = 1; $k <= $combinations; $k++) : ?>
									<th class='text-center align-middle'> Action <?= $k ?></th>
								<?php endfor; ?>
							<?php endfor; ?>
						</thead>
						<tbody>
							<?php for ($x = 0; $x < $count_action; $x++) : ?>
								<tr>
									<th><?= $action[$x]->action ?></th>
									<?php for ($i = 0; $i < $combinations; $i++) : ?>
										<td class='text-center'>
											<input type='text' class='form-control' id="act[<?=$action[$x]->id ?>][<?= $i ?>]" name='act[<?=$action[$x]->id ?>][<?= $i ?>]' onkeyup="cek()" width='10px'>
										</td>
									<?php endfor; ?>
								</tr>
							<?php endfor; ?>
							</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<!--end:: Widgets/Download Files-->

<!-- datatable utils -->

<div id="dt_btn_utils" class="d-none">
	<?php echo $this->sys->btn_dt_edit() ?>
	<?php echo $this->sys->btn_dt_delete() ?>
</div>

<!--begin::Modal Manage-->
<div class="modal fade" id="modal_md" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form id="form-md-manage" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div id="modal-body-md">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" id="btn-add" class="btn btn-success">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--end::Modal Manage-->

<!--begin::Modal Delete-->
<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel2">Delete Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form id="form-md-delete" method="post">
				<div class="modal-body">
					<div id="modal-body-delete">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-google">Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--end::Modal Delete-->

<script type="text/javascript">
	$(document).ready(function() {
		// var tabel = $('#tabel-data');
		var tabel = $('#tabel-data').DataTable();
		// ajax: {
		// 	url: "<?php //echo base_url('conditionwd/fetch') 
								?>",
		// 	dataSrc: "data",
		// 	"type": "POST",
		// 	'dataType': 'json',
		// },
		// 	processing: true,
		// 	serverSide: true,
		// 	columns: [{
		// 			data: null,
		// 			render: function(data, row, columns, meta) {
		// 				return meta.row + 1;
		// 			},

		// 		},
		// 		{
		// 			data: 'condition'
		// 		},
		// 		{
		// 			data: null,
		// 			render: function(data, row, columns, meta) {
		// 				var dt_btn_utils = $('#dt_btn_utils').clone();
		// 				dt_btn_utils.find('.dt-edit').attr({
		// 					'target-id': data.id,
		// 					'onclick': 'dt_edit(this)'
		// 				});
		// 				dt_btn_utils.find('.dt-delete').attr({
		// 					'target-id': data.id,
		// 					'onclick': 'dt_delete(this)'
		// 				});
		// 				return dt_btn_utils.html();
		// 			},
		// 			searchable: false
		// 		},
		// 	],
		// });
		
		$('#form-md-manage').submit(function(event) {
			$.post('<?php echo base_url('condition/save') ?>', $(this).serialize(), function(response, textStatus, xhr) {

				// tabel.reload();
				if (response.status == true) {
					toastr.success(response.msg);
					setTimeout(function() {
						window.location.reload();
					}, 2000);
					// $('#modal_md').modal('hide');
				} else {
					toastr.error(response.msg);

				}
			}, "json");
			return false;
		});

		$('#form-md-delete').submit(function(event) {
			$.post('<?php echo base_url('condition/delete') ?>', $(this).serialize(), function(response, textStatus, xhr) {
				tabel.ajax.reload();
				if (response.status == true) {
					toastr.success(response.msg);
					$('#modal_delete').modal('hide');
				} else {
					toastr.error(response.msg);
				}
			}, "json");
			return false;
		});
	});


	function dt_add(t) {
		$.get('<?php echo base_url('conditionwd/modal/add') ?>').done(function(data) {
			$('#exampleModalLabel').html('Tambah Data');
			$('#modal-body-md').html(data);
			$('#modal_md').modal('show');
		});
	}

	function dt_edit(t) {
		$.get('<?php echo base_url('/conditionwd/modal/edit') ?>', {
			'id': $(t).attr('target-id')
		}).done(function(data) {
			$('#exampleModalLabel').html('Edit Data');
			$('#modal-body-md').html(data);
			$('#modal_md').modal('show');
		});
	}

	function dt_delete(t) {
		$.get('<?php echo base_url('conditionwd/modal/delete') ?>', {
			'id': $(t).attr('target-id')
		}).done(function(data) {
			$('#modal-body-delete').html(data);
			$('#modal_delete').modal('show');
		});
	}
</script>