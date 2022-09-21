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
		#products_table_length {
			margin-bottom: -35px;
		}

		tr:nth-of-type(even) {
			background-color: #f9f9f9;
		}

		.table>tbody>tr>td,
		.table>tbody>tr>th,
		.table>tfoot>tr>td,
		.table>tfoot>tr>th,
		.table>thead>tr>td,
		.table>thead>tr>th {
			padding: 5px;
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
									<h2 class="panel-title text-center"><strong>JOURNEYS</strong></h2>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<!-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> -->
									</div>
								</div>
								<div class="panel-body no-padding">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-3">
												<div class="metric">
													CATEGORY
													<select class="form-control search-select" id="category" name="category">
														<option value="">&nbsp;</option>
														<?php foreach ($main_category as $key => $category) { ?>
															<option value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="metric">
													DATE
													<input type="date" id="date" class="form-control" value="<?php echo date("Y-m-d") ?>">
												</div>
											</div>
											<div class="col-md-3">
												<div class="metric">
													BRANCH *
													<select id="branch_id" name="branch_id" class="form-control search-select variable">
														<?php foreach ($warehouse as $key => $wh) {
															$sel = "";
															echo '<option value="' . $wh->id . '" ' . $sel . '"> ' . $wh->name . '</option>';
														} ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="">
											<table id="products_table" class="table table-striped table-bordered table-hover" style="width:100%">
												<thead>
													<tr>
														<th>Added Date Time</th>
														<th>Start Time</th>
														<th>End Time</th>
														<th>Status</th>
														<th>Vehicle Category</th>
														<th>Customer</th>
														<th>Driver</th>
														<th>Price</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody></tbody>
												<tfoot>
													<tr>
														<th>Added Date Time</th>
														<th>Start Time</th>
														<th>End Time</th>
														<th>Status</th>
														<th>Customer</th>
														<th>Driver</th>
														<th>Price</th>
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
			products_load();
		});

		function products_load() {
			$('#products_table').DataTable({
				"dom": 'Blfrtip',
				"ajax": {
					url: "<?php echo base_url('journeys/get_list') ?>",
					type: "POST",
					data: {
						"cat_id": $('#category').val(),
						"date": $('#date').val(),
						"branch_id": $('#branch_id').val()
					}
				},
				"bDestroy": true,
				"serverSide": true,
				"iDisplayLength": 10,
				"order": [
					[0, "desc"]
				],
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
		/* $('select#category').on('change', function() {
			var category_id = $(this).val();
			$.ajax({
				type: "post",
				async: false,
				url: "<?php echo base_url('products/get_sub_category_by_id'); ?>",
				data: {
					category_id: category_id
				},
				dataType: "html",
				success: function(data) {
					if (data != "") {
						$('#subcat_data').empty();
						$('#subcat_data').html(data);
					} else {
						$('#subcat_data').empty();
						var default_data = '<select name="subcategory" id="subcategory" onchange="products_load()" class="form-control search-select" data-placeholder="Select Category to load Subcategories"></select>';
						$('#subcat_data').html(default_data);
					}
					products_load();
				},
				error: function() {
					bootbox.alert('Error occured while getting data from server.');
				}
			});
		}); */
	</script>

</body>

</html>