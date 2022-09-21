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

		button:active {
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
									<h2 class="panel-title"><strong>USER GROUP PERMISSIONS</strong></h2>
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

											</div>
											<div class="col-md-3">

											</div>
											<div class="col-md-3">

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
														<th>User Group ID</th>
														<th>Group Name</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>User Group ID</th>
														<th>Group Name</th>
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
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h3 class="modal-title" id="exampleModalLabel">
							<i class="fa fa-user-plus"></i>
							ADD GROUP 
						</h3>
					</div>
					<div class="modal-body">
						<form id="user_form" autocomplete="off">
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">User Group Name *</label>
								<input type="text" id="user_group_name" class="form-control" name="user_group_name" value="" />
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary submit">ADD GROUP</button>
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
	<script src="<?php echo assets_url(); ?>/js/form_validations-add_users.js"></script>

	<script>
		$(document).ready(function() {
			FormValidator.init();
			users_load();
			$('.submit').on('click', function() {
				$('#user_form').submit();
			});
		});

		function users_load() {
			req = $('#data_table').DataTable({
				dom: 'Blfrtip',
				//lengthMenu: [[10, 25, 50, -1 ], [10, 25, 50, "All"]],
				buttons: [{
						extend: 'copy',
						text: '<i class="fa fa-copy fa-2x"></i>',
						footer: true,
						exportOptions: [0, 1, 2, 3]
					},
					{
						extend: 'print',
						text: '<i class="fa fa-print fa-2x"></i>',
						footer: true,
						exportOptions: {
							columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
						},
						title: "<center>User Groups</center>"
					},
					{
						extend: 'excel',
						text: '<i class="far fa-file-excel fa-2x"></i>Excel',
						footer: true,
						exportOptions: {
							columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
						},
						title: "User Groups"
					},
					{
						extend: 'pdf',
						text: '<i class="far fa-file-pdf fa-2x"></i>PDF',
						footer: true,
						exportOptions: {
							columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
						},
						title: "User Groups"
					},

				],
				"serverSide": false,
				"ajax": "<?php echo base_url('users/get_list_user_group') ?>",
				"bDestroy": true,
				"iDisplayLength": 10
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
					url: "<?php echo base_url('users/save_user_group'); ?>", // Url to which the request is send
					type: "POST", // Type of request to be send, called as method
					data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false, // The content type used when sending data to the server.
					cache: false, // To unable request pages to be cached
					processData: false, // To send DOMDocument or non processed data file it is set to false
					dataType: "JSON",
					success: function(data) // A function to be called if request succeeds
					{
						if (data.status) {
							toastr.success("User Group Added Successfully!");
							setTimeout(() => {
								window.location.reload();
							}, 2000);
						}else{
							bootbox.alert(data.validation);
							toastr.warning("Check data");
						}
					},
					error: function(data) {
						toastr.error(data.responseText);
					}
				});
			}, 1000);
		}

		function loadGrid() {
			$('#products_table').DataTable({
				"ajax": "<?php echo base_url('users/get_list_user_group') ?>",
				"bDestroy": true,
				"iDisplayLength": 10
			});
		}
	</script>

</body>

</html>