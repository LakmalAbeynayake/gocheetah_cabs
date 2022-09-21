<?php $cm = new common_model(); ?>
<!doctype html>
<html lang="en">

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- CSS -->
	<?php $this->load->view('common/css') ?>
	<!-- THIS PAGE SPECIFIC -->
	<link rel="stylesheet" href="<?php echo assets_url(); ?>/vendor/chartist/css/chartist-custom.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
	<style>
		#category_table_length {
			margin-bottom: -35px;
		}

		.table>tbody>tr>td,
		.table>tbody>tr>th,
		.table>tfoot>tr>td,
		.table>tfoot>tr>th,
		.table>thead>tr>td,
		.table>thead>tr>th {
			padding: 5px;
		}

		.panel .table>tbody>tr>td:last-child {
			text-align: center !important;
		}
	</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">

		<!-- NAVBAR TOP-->
		<?php $this->load->view('common/nav-bar-top') ?>
		<!-- END NAVBAR TOP -->

		<!-- LEFT SIDEBAR -->
		<?php $this->load->view('common/nav-bar-left') ?>
		<!-- END LEFT SIDEBAR -->

		<!-- MAIN -->
		<div class="main">

			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">

					<!-- ADVANCED FILTERS -->

					<div class="row">
						<div class="col-md-12">
							<!-- RECENT PURCHASES -->
							<div class="panel">
								<div class="panel-heading">
									<h2 class="panel-title text-center"><strong>CATEGORIES</strong></h2>
									<div class="right">
										<button type="button" class="btn-toggle-collapses" data-toggle="modal" data-target="#add_user_model"><i class="fa fa-plus"></i></button>
										<!--<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>-->
										<!-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> -->
									</div>
								</div>

								<div class="panel-footer">
									<div class="row">
										<div class="">
											<table id="category_table" class="table table-striped table-bordered table-hover" style="width:100%">
												<thead>
													<tr>
														<th>Icon</th>
														<th>Category Name</th>
														<th>Category Description</th>
														<th>Category Price</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody></tbody>
												<tfoot>
													<tr>
														<th>Icon</th>
														<th>Category Name</th>
														<th>Category Description</th>
														<th>Category Price</th>
														<th>Actions</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- END RECENT PURCHASES -->
						</div>
					</div>
					<!-- END ADVANCED FILTERS -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title">Category info</h4>
				</div>
				<div class="modal-body">
					<p>
						Do you want to change the status of category ?
					</p>
				</div>
				<div class="modal-footer">
					<button aria-hidden="true" data-dismiss="modal" class="btn btn-default">
						Close
					</button>
					<button class="btn btn-default" data-dismiss="modal" id="conf" cat-id="" status="">
						Confirm
					</button>
				</div>
			</div>
		</div>
		<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title">Categories info</h4>
				</div>
				<div class="modal-body">
					<p>
						Do you want to permanent delete the category?
					</p>
				</div>
				<div class="modal-footer">
					<button aria-hidden="true" data-dismiss="modal" class="btn btn-default">
						Close
					</button>
					<button class="btn btn-default" data-dismiss="modal" id="confdel">
						Confirm
					</button>
				</div>
			</div>
		</div>
		<div class="modal fade" id="add_user_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
				<form id="user_form">
					<input type="hidden" id="cat_id" name="cat_id" value="">
					<input type="hidden" id="url" value="category/save">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> CREATE CATEGORY</h3>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="cat_name" class="col-form-label">Category Name *</label>
								<input type="text" id="cat_name" class="form-control" name="cat_name" value="" />
							</div>
							<div class="form-group">
								<label for="cat_desc" class="col-form-label">Category Desc *</label>
								<textarea class="form-control" id="cat_desc" name="cat_desc" rows="4" cols="50"></textarea>
							</div>
							<div class="form-group">
								<label for="cat_price" class="col-form-label">Category Price</label>
								<input type="text" id="cat_price" class="form-control" name="cat_price" value="" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" id="button">SAVE CATEGORY</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>-->
		<?php $this->load->view('common/footer'); ?>
	</div>
	<!-- END WRAPPER -->

	<!-- Javascript -->
	<?php $this->load->view('common/js') ?>
	<script src="<?php echo assets_url(); ?>/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="<?php echo assets_url(); ?>/vendor/chartist/js/chartist.min.js"></script>
	<script src="<?php echo assets_url(); ?>/scripts/klorofil-common.js"></script>
	<?php $this->load->view('common/datatable_js') ?>
	<script>
		$(document).ready(function() {
			category_load();
		});

		function category_load() {
			$('#category_table').DataTable({
				"dom": 'Blfrtip',
				"ajax": {
					url: "<?php echo base_url('category/get_category') ?>",
					type: "POST",
					/*data: {
						"cat_id": $('#category').val(),
						"sub_cat_id": $('#subcategory').val(),
						"warehouse_id": $('#warehouse_id').val()
					}*/
				},
				"bDestroy": true,
				"serverSide": false,
				"iDisplayLength": 10,
				"order": [
					[0, "desc"]
				],
				rowReorder: {
					selector: 'td:nth-child(2)'
				},
				responsive: true,
				lengthMenu: [
					[10, 25, 50, -1],
					[10, 25, 50, "All"]
				],
				"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
					//for (var i = 0; i < aaData.length; i++) {
					/*p = (aaData[aiDisplay[i]][2]).split('__');*/
					//console.log(parseFloat(aaData[[i]][3]));
					//}
					//var nCells = nRow.getElementsByTagName('th');
					//nCells[3].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot1, "", 2, ",", ".") + ' </div>';
				}
			});
		}
		$('#add_user_model').on('hidden.bs.modal', function() {
			$('#url').val('category/save');
		})

		function category_edit(category_id) {
			$.ajax({
				url: "<?php echo base_url("category/edit_category/"); ?>" + category_id,
				type: "POST",
				data: {},
				dataType: "JSON",
				success: function(data) {
					if (data.cat_id) {
						$('#url').val('category/update');
						$('#cat_id').val(data.cat_id);
						$('#cat_name').val(data.cat_name);
						$('#cat_desc').val(data.cat_description);
						$('#cat_price').val(data.cat_price);
						$('#button').text("UPDATE CATEGORY");
						$('#add_user_model').modal();
					} else
						bootbox.alert("No category data available!");
				},
				error: function(data) {}
			});
		}
		$('#add_user_model').on('hidden.bs.modal', function(e) {
			$('#button').text("SAVE CATEGORY");
			$('#url').val('category/save');
			$('#cat_id').val("");
			$('#cat_name').val("");
			$('#cat_desc').val("");
		});
		$('#user_form').submit(function(e) {
			e.preventDefault();
			save_category();
		});

		function save_category() {
			var url = $('#url').val();
			$.ajax({
				url: "<?php echo base_url(); ?>" + url,
				method: "POST",
				data: {
					cat_id: $('#cat_id').val(),
					cat_name: $('#cat_name').val(),
					cat_price: $('#cat_price').val(),
					cat_desc: $('#cat_desc').val()
				},
				dataType: "JSON",
				success: function(data) // A function to be called if request succeeds
				{
					if (data.status) {
						toastr.success('Applied successfully!')
						$('#add_user_model').modal('hide');
						category_load();
					} else {
						bootbox.alert(data.validation);
					}
				},
				error: function(data) {
					bootbox.alert(data.responseText);
				}
			});
		}

		function change_status(category_id, status) {
			bootbox.confirm({
				title: "Change Status?",
				message: "Do you want change the status of category?",
				buttons: {
					cancel: {
						label: '<i class="fa fa-times"></i> Cancel'
					},
					confirm: {
						label: '<i class="fa fa-check"></i> Confirm'
					}
				},
				callback: function(result) {
					if (result) {
						$.ajax({
							url: "<?php echo base_url('category/category_change_status'); ?>",
							type: "POST",
							data: {
								cat_id: category_id,
								status: status
							},
							success: function(data) {
								var obj = jQuery.parseJSON(data);
								if (obj.status == 0) {
									$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');

								} else {
									toastr.success('Category status changed successfully')
									category_load();
								};
							}
						});
					}
				}
			});
		}
		/*jQuery("button#confdel").click(function() {
			$.ajax({
				url: "<?php echo base_url('category/category_permanent_delete'); ?>",
				type: "POST",
				data: {
					cat_id: $(this).attr("cat-id")
				},
				success: function(data) {
					var obj = jQuery.parseJSON(data);
					if (obj.status == 0) {
						$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
						$('body').modalmanager('removeLoading');
					} else {
						$('body').modalmanager('removeLoading');
						$('div#ajax-modal').modal('hide');
						set_message('categories notice!', 'Category permanent deleted successfully');
						category_load();
					};
				}
			});
		});*/
		function sub_perm_delete() {
			bootbox.alert("Not available yet!");
		}
	</script>

</body>

</html>