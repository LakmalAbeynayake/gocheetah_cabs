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
		.panel .panel-heading button {
			padding: 5px;
			margin-left: 5px;
			background-color: #6e746e59;
			border: none;
			outline: none;
			border-radius: 26px;
			width: 30px;
		}
		button:active{
			color: #ccc;
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
									<h2 class="panel-title"><strong>CUSTOMERS</strong></h2>
									<div class="right">
										<button type="button" class="btn-toggle-collapses" data-toggle="modal" data-target="#add_user_model"><i class="fa fa-user-plus"></i></button>
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<!-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> -->
									</div>
								</div>
								<div class="panel-body no-padding">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-3">
												<div class="metric">
													BRANCH
													<select id="srh_warehouse_id" name="srh_warehouse_id" class="form-control search-select">
														<option value=""></option>
														<?php foreach ($warehouse_list as $key => $wh) {
															$sel = "";
															echo '<option value="' . $wh->id . '" ' . $sel . '"> ' . $wh->name . '</option>';
														} ?>
													</select>
												</div>
											</div>
											<div class="col-md-12 metric">
												<div class="pull-right">
													<button class="btn btn-info submit">
														SEARCH
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="">
											<table id="data_table" class="table table-striped table-bordered" style="width:100%">
												<thead>
													<tr>
														<th>Code</th>
														<th>Name</th>
														<th>Email</th>
														<th>Phone</th>
														<th>Address</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Code</th>
														<th>Name</th>
														<th>Email</th>
														<th>Phone</th>
														<th>Address</th>
														<th>Action</th>
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

		<!-- modal -->
		<div class="modal fade bd-example-modal-lg" id="add_user_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLabel">ADD CUSTOMER <i class="fa fa-user-plus"></i></h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="user_form">
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Name *</label>
								<input type="text" id="user_first_name" class="form-control" name="cus_name" value="" />
							</div>
							<!-- <div class="form-group">
								<label for="recipient-name" class="col-form-label">Last Name *</label>
								<input type="text" id="user_last_name" class="form-control" name="user_last_name" value="" />
							</div> -->
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Email *</label>
								<input type="email" id="cus_email" class="form-control" name="cus_email" value="" />
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Phone *</label>
								<input type="text" id="cus_phone" class="form-control" name="cus_phone" value="" />
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Gender *</label>
								<select class="form-control" name="cus_gender" id="cus_gender">
									<option value=""></option>
									<option value="male">Male</option>
									<option value="male">Female</option>
								</select>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary submit">ADD CUSTOMER</button>
					</div>
				</div>
			</div>
		</div>
		<!-- end modal -->
		<?php $this->load->view('common/footer'); ?>
	</div>
	<!-- END WRAPPER -->

	<!-- Javascript -->
	<?php $this->load->view('common/js') ?>
	<script src="<?php echo assets_url(); ?>/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="<?php echo assets_url(); ?>/vendor/chartist/js/chartist.min.js"></script>
	<script src="<?php echo assets_url(); ?>/scripts/klorofil-common.js"></script>
	<?php $this->load->view('common/datatable_js') ?>
	<script type="text/javascript" src="<?php echo assets_url(); ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="<?php echo assets_url(); ?>/js/form_validations-add_customer.js"></script>

	<script>
		$(document).ready(function() {
			FormValidator.init();
			users_load();
			$('.submit').on('click', function() {
				$('#user_form').submit();
			});
		});

		function users_load() {
			$('#data_table').DataTable({
				"dob": "Blftrip",
				"ajax": {
					url: "<?php echo base_url('customers/get_list') ?>",
					type: "POST",
					data: {
						"branch_id": $('#srh_warehouse_id').val()
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
					for (var i = 0; i < aaData.length; i++) {
						/*p = (aaData[aiDisplay[i]][2]).split('__');*/
						console.log(parseFloat(aaData[[i]][3]));
					}
					//var nCells = nRow.getElementsByTagName('th');
					//nCells[3].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot1, "", 2, ",", ".") + ' </div>';
				}
			});
		}

		function encodeImageFileAsURL(element, target) {
			var file = element.files[0];
			var size = file.size;
			if (size > 1000000) {
				bootbox.alert("ERROR! FIle size is larger than 1MB.");
				return false;
			}
			var reader = new FileReader();
			reader.onloadend = function() {
				$('#' + target + '_pv').attr('src', reader.result);
				$('#' + target).val(reader.result);
			}
			reader.readAsDataURL(file);
		}

		function save_user(form) {
			setTimeout(function() {
				$.ajax({
					url: "<?php echo base_url('customers/save_customer'); ?>", // Url to which the request is send
					type: "POST", // Type of request to be send, called as method
					data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false, // The content type used when sending data to the server.
					cache: false, // To unable request pages to be cached
					processData: false, // To send DOMDocument or non processed data file it is set to false
					dataType: "JSON",
					success: function(data) // A function to be called if request succeeds
					{
						if (data.success) {
							$('#add_user_model').hide();
							bootbox.alert("Customer Added Successfully!");
							setTimeout(() => {
								window.location.reload();
							}, 2000);
						}
					},
					error: function(data) {
						bootbox.alert(data);
					}
				});
			}, 1000);
		}
	</script>

</body>

</html>