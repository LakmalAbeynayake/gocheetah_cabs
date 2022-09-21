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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.form-group {
			margin-bottom: 15px;
			padding-bottom: 35px;
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
									<h2 class="panel-title"><strong>EDIT USER</strong></h2>
									<div class="right">
										<a href="<?php echo base_url() ?>users/view_list">Users</a> / Edit
									</div>
								</div>
								<form action="" id="user_form">
									<input type="hidden" id="user_id" name="user_id" value="<?php echo $user['user_id'] ?>">
									<div class="panel-body">
										<!-- <pre>
										<?php
										print_r($user)
										?>
										</pre> -->
										<div class="form-group">
											<label class="col-sm-2 control-label" for="user_first_name"> Firt Name
												*</label>
											<div class="col-sm-9">

												<input type="text" id="user_first_name" class="form-control" name="user_first_name" value="<?php echo $user['user_first_name'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="user_last_name"> Last Name
												*</label>
											<div class="col-sm-9">
												<input type="text" id="user_last_name" class="form-control" name="user_last_name" value="<?php echo $user['user_last_name'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="user_email"> Email
												*</label>
											<div class="col-sm-9">
												<input type="email" id="user_email" class="form-control" name="user_email" value="<?php echo $user['user_email'] ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="recipient-name" class="col-sm-2">Phone *</label>
											<div class="col-sm-9">
												<input type="text" id="user_phone" class="form-control" name="user_phone" value="<?php echo $user['user_phone'] ?>" />
											</div>
										</div>
										<div class="form-group">
											<label for="recipient-name" class="col-sm-2">Gender *</label>
											<div class="col-sm-9">
												<select class="form-control" name="user_gender" id="user_gender">
													<option value=""></option>
													<option value="Male" <?php echo $user['user_gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
													<option value="Female" <?php echo $user['user_gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="recipient-name" class="col-sm-2">User Group *</label>
											<div class="col-sm-9">
												<select class="form-control" name="group_id" id="group_id">
													<option value=""></option>
													<?php foreach ($user_group_list as $key => $wh) {
														$sel = $user['group_id'] == $wh->user_group_id ? 'selected' : '';
														echo '<option value="' . $wh->user_group_id . '" ' . $sel . '> ' . $wh->user_group_name . '</option>';
													} ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="recipient-name" class="col-sm-2">Branch *</label>
											<div class="col-sm-9">
												<select class="form-control" name="branch_id" id="branch_id">
													<option value=""></option>
													<?php foreach ($warehouse_list as $key => $wh) {
														$sel = $user['branch_id'] == $wh->id ? 'selected' : '';
														echo '<option value="' . $wh->id . '" ' . $sel . '> ' . $wh->name . '</option>';
													} ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2"> User Image </label>
											<div class="col-sm-9">
												<img id="user_image_pv" src="<?php echo $user['user_image'] ? $user['user_image'] : $default_image; ?>" alt="" style="max-width: 100px;" alt="no-image">
												<label for="user_image_select">
													<a class="btn btn-sm btn-success">SELECT</a>
													<input style="display: none;" id="user_image_select" type="file" onchange="encodeImageFileAsURL(this,'user_image')">
												</label>
												<button class="btn btn-sm btn-info" id="reset_image"><i class="fa fa-times"></i></button>
												<input type="hidden" name="user_image" id="user_image" class="form-control auto" value="<?php echo $user['user_image'] ? $user['user_image'] : $default_image; ?>">
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<button id="submit" disabled class="btn btn-primary btn-squared pull-right" type="submit"> SAVE CHANGES </button>
											</div>
										</div>
								</form>
							</div>
						</div>
						<!-- END RECENT PURCHASES -->
					</div>
				</div>
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo assets_url(); ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="<?php echo assets_url(); ?>/js/form_validations-edit_users.js"></script>
	<script>
		$(document).ready(function() {
			FormValidator.init();
		}).change(function() {
			$('#submit').removeAttr('disabled');
		});

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

		function update_user(form) {
			$.ajax({
				url: "<?php echo base_url('users/update_user'); ?>",
				type: "POST",
				data: new FormData(form),
				dataType: "JSON",
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false, // To send DOMDocument or non processed data file it is set to false
				success: function(data) // A function to be called if request succeeds
				{
					if (data.success) {
						bootbox.alert("Changes Applied!");
						setTimeout(() => {
							window.location.href = "<?php echo base_url('users/view_list'); ?>";
						}, 2000);
					} else alert("Data Error");
				},
				error: function(data) {
					bootbox.alert("ERROR!");
					console.log(data.responseText);
				}
			});
		}
		$('#reset_image').on('click', function(event) {
			event.preventDefault();
			$('#user_image').val("<?php echo $default_image ?>");
			$('#user_image_pv').attr("src", "<?php echo $default_image ?>");
		});
	</script>
</body>

</html>