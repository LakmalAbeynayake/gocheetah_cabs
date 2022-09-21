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
		input[type=checkbox] {
			width: 20px;
			height: 20px;
		}

		.tab-right {
			padding-left: 30px;
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
								<form role="form" class="form-horizontal" id="edit_prem_form" name="edit_prem_form" action="#" method="post">
									<div class="panel-heading">
										<h2 class="panel-title"><strong>EDIT GROUP PERMISSIONS : <span style="text-transform: uppercase;"><?php echo $user_group_group_info['user_group_name']; ?></span> </strong></h2>
										<div class="right">
											<a href="<?php echo base_url() ?>users/permissions">User Permissions</a> / Edit Navigation
											<!-- <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button> -->
											<!-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> -->
										</div>
									</div>
									<div class="panel-body">
									</div>
									<div class="panel-footer">
										<div class=" no-padding">
											<input name="user_group_id" type="hidden" value="<?php echo $user_group_id ?>">
											<div class="">
												<div class="">
													<table id="data_table" class="table table-striped table-bordered table-hover" style="width:100%">
														<thead>
															<tr>
																<th class="text-center">Module Name </th>
																<th class="text-center">Has Access</th>
															</tr>
														</thead>
														<tbody>
															<?php
															foreach ($perm_and_page_list as $row) {
																$has_permission = $this->common_model->check_permission($row['id'], $user_group_id, 1);
															?>
																<tr>
																	<td>
																		<?php echo $row['display_name'] ?>
																	</td>
																	<td class="text-center">
																		<label style="width:100%" for="row_view_<?php echo $row['id']; ?>">
																			<input type="checkbox" class="square-teal" value="1" <?php if ($has_permission) echo 'checked="checked"'; ?> name="row_view_<?php echo $row['id']; ?>" id="row_view_<?php echo $row['id']; ?>">
																		</label>
																	</td>
																</tr>

																<!-- subs -->
																<?php
																if (!empty($row['subs']))
																	foreach ($row['subs'] as $subs) {
																		$has_sub_permission = $this->common_model->check_permission($subs['id'], $user_group_id, 1);
																?>
																	<tr>
																		<td>
																			<span class="tab-right">
																				<?php echo $subs['display_name'] ?>
																			</span>
																		</td>
																		<td class="text-center">
																			<label class="" style="padding-left: 0px; width:100%" for="row_view_<?php echo $subs['id']; ?>">
																				<input type="checkbox" class="square-teal" id="row_view_<?php echo $subs['id']; ?>" value="1" <?php if ($has_sub_permission) echo 'checked="checked"'; ?> name="row_view_<?php echo $subs['id']; ?>">
																			</label>
																		</td>
																	</tr>
																<?php } ?>
																<!-- end subs -->
															<?php } ?>
														</tbody>
														<tfoot>
															<tr>
																<th class="text-center">Module Name </th>
																<th class="text-center">Has Access</th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>

										<div class="text-right">
											<input type="submit" value="UPDATE" class="btn btn-primary submit">
										</div>
									</div>
								</form>
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
	<!-- <script type="text/javascript" src="<?php echo assets_url(); ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="<?php echo assets_url(); ?>/js/form_validations-edit_permission.js"></script> -->

	<script>
		$(document).ready(function() {
			/* FormValidator.init(); */
			$('#edit_prem_form').submit(function(e) {
				e.preventDefault();
				update_permission();
			});
		});

		function update_permission() {
			var form = $('#edit_prem_form').serialize()

			setTimeout(function() {
				$.ajax({
					url: "<?php echo base_url('users/save_user_group_permissions'); ?>?" + form, // Url to which the request is send
					type: "POST", // Type of request to be send, called as method
					dataType: "JSON",
					//data: form, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false, // The content type used when sending data to the server.
					cache: false, // To unable request pages to be cached
					processData: false, // To send DOMDocument or non processed data file it is set to false
					success: function(data) // A function to be called if request succeeds
					{
						if (data.status == 1) {
							toastr.success("Edited successfully!");
							setTimeout(function() {
								window.location.reload();
							}, 2000);
						} else {
							toastr.error("Error!");
						}
						/* var obj = jQuery.parseJSON(data);
						if (obj.status == 0) {
							$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
							$('body').modalmanager('removeLoading');
							$('body').attr('class', '');
						} else {
							$('body').modalmanager('removeLoading');
							$('body').attr('class', '');
							set_message('Apdated!', 'Group Permission has been updated successfully!');
							document.getElementById("create_user_form").reset();
						}; */

					}
				});
			}, 1000);
		}
	</script>

</body>

</html>