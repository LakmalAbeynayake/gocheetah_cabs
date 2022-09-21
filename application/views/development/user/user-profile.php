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
	<link rel="stylesheet" href="<?php echo assets_url(); ?>/css/jquery-ui.css">
	<style>
		#products_table_length {
			margin-bottom: -35px;
		}

		#ui-id-1 {
			z-index: 10000;
		}
		#wrapper > div.main > div.main-content > div > div.panel.panel-profile > div > div.profile-left > div.profile-header > div.profile-main > img{
			max-width: 100px;
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

					<div class="panel">
						<div class="panel-heading">
							<h2 class="panel-title"><strong>USER INFO</strong></h2>
							<div class="right">
								<a href="<?php echo base_url() ?>users/view_list">Users</a> / Profile
							</div>
						</div>
					</div>

					<div class="panel panel-profile">
						<div class="clearfix">
							<!-- LEFT COLUMN -->
							<div class="profile-left">

								<!-- PROFILE HEADER -->
								<div class="profile-header">
									<div class="overlay"></div>
									<div class="profile-main">
										<img src="<?php echo $user['user_image'] ?>" class="img-circle" alt="Avatar">
										<h3 class="name"><?php echo $user['user_first_name'].' '.$user['user_last_name'] ?></h3>
										<span class="online-status status-available">Available</span>
									</div>
									<div class="profile-stat">
										<div class="row">
											<div class="col-md-4 stat-item">
											<?php echo $cus_count ?> <span>Customers</span>
											</div>
											<div class="col-md-4 stat-item">
												15 <span>Covered Cities</span>
											</div>
											<div class="col-md-4 stat-item">
												2174 <span>Average Sales Per Week</span>
											</div>
										</div>
									</div>
								</div>
								<!-- END PROFILE HEADER -->

								<!-- PROFILE DETAIL -->
								<div class="profile-detail">
									<div class="profile-info">
										<h4 class="heading">Basic Info</h4>
										<ul class="list-unstyled list-justify">
											<li>Birthdate <span><?php echo date("d M, Y", strtotime($user['date_of_birth'])) ?></span></li>
											<li>Mobile <span><?php echo $user['user_phone'] ?></span></li>
											<li>Email <span><?php echo $user['user_email'] ?></span></li>
											<li class="collapse">Website <span><a
														href="https://www.themeineed.com">www.themeineed.com</a></span>
											</li>
										</ul>
									</div>
									<div class="profile-info">
										<h4 class="heading">Social</h4>
										<ul class="list-inline social-icons">
											<li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
											<li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
											<li><a href="#" class="google-plus-bg"><i class="fa fa-google-plus"></i></a>
											</li>
											<li><a href="#" class="github-bg"><i class="fa fa-github"></i></a></li>
										</ul>
									</div>
									<div class="profile-info">
										<h4 class="heading">About</h4>
										<p>Interactively fashion excellent information after distinctive outsourcing.
										</p>
									</div>
									<div class="text-center"><a href="#" class="btn btn-primary">Edit Profile</a></div>
								</div>
								<!-- END PROFILE DETAIL -->
							</div>
							<!-- END LEFT COLUMN -->

							<!-- RIGHT COLUMN -->
							<div class="profile-right">
								<h4 class="heading"><?php echo $user['user_first_name'] ?>'s Awards</h4>

								<!-- AWARDS -->
								<div class="awards">
									<div class="row">
										<div class="col-md-3 col-sm-6">
											<div class="award-item">
												<div class="hexagon">
													<span class="lnr lnr-sun award-icon"></span>
												</div>
												<span>Most Bright Idea</span>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="award-item">
												<div class="hexagon">
													<span class="lnr lnr-clock award-icon"></span>
												</div>
												<span>Most On-Time</span>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="award-item">
												<div class="hexagon">
													<span class="lnr lnr-magic-wand award-icon"></span>
												</div>
												<span>Problem Solver</span>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="award-item">
												<div class="hexagon">
													<span class="lnr lnr-heart award-icon"></span>
												</div>
												<span>Most Loved</span>
											</div>
										</div>
									</div>
									<div class="text-center"><a href="#" class="btn btn-default">See all awards</a>
									</div>
								</div>
								<!-- END AWARDS -->

								<!-- TABBED CONTENT -->
								<div class="custom-tabs-line tabs-line-bottom left-aligned">
									<ul class="nav" role="tablist">
										<li class="active"><a href="#tab-bottom-left1" role="tab"
												data-toggle="tab">Recent Activity</a></li>
										<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Projects <span
													class="badge">7</span></a></li>
									</ul>
								</div>
								<div class="tab-content">
									<div class="tab-pane fade in active" id="tab-bottom-left1">
										<ul class="list-unstyled activity-timeline">
											<li>
												<i class="fa fa-comment activity-icon"></i>
												<p>Commented on post <a href="#">Prototyping</a> <span
														class="timestamp">2 minutes ago</span></p>
											</li>
											<li>
												<i class="fa fa-cloud-upload activity-icon"></i>
												<p>Uploaded new file <a href="#">Proposal.docx</a> to project <a
														href="#">New Year Campaign</a> <span class="timestamp">7 hours
														ago</span></p>
											</li>
											<li>
												<i class="fa fa-plus activity-icon"></i>
												<p>Added <a href="#">Martin</a> and <a href="#">3 others colleagues</a>
													to project repository <span class="timestamp">Yesterday</span></p>
											</li>
											<li>
												<i class="fa fa-check activity-icon"></i>
												<p>Finished 80% of all <a href="#">assigned tasks</a> <span
														class="timestamp">1 day ago</span></p>
											</li>
										</ul>
										<div class="margin-top-30 text-center"><a href="#" class="btn btn-default">See
												all activity</a></div>
									</div>
									<div class="tab-pane fade" id="tab-bottom-left2">
										<div class="table-responsive">
											<table class="table project-table">
												<thead>
													<tr>
														<th>Title</th>
														<th>Progress</th>
														<th>Leader</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><a href="#">Spot Media</a></td>
														<td>
															<div class="progress">
																<div class="progress-bar" role="progressbar"
																	aria-valuenow="60" aria-valuemin="0"
																	aria-valuemax="100" style="width: 60%;">
																	<span>60% Complete</span>
																</div>
															</div>
														</td>
														<td><img src="assets/img/user2.png" alt="Avatar"
																class="avatar img-circle"> <a href="#">Michael</a></td>
														<td><span class="label label-success">ACTIVE</span></td>
													</tr>
													<tr>
														<td><a href="#">E-Commerce Site</a></td>
														<td>
															<div class="progress">
																<div class="progress-bar" role="progressbar"
																	aria-valuenow="33" aria-valuemin="0"
																	aria-valuemax="100" style="width: 33%;">
																	<span>33% Complete</span>
																</div>
															</div>
														</td>
														<td><img src="assets/img/user1.png" alt="Avatar"
																class="avatar img-circle"> <a href="#">Antonius</a></td>
														<td><span class="label label-warning">PENDING</span></td>
													</tr>
													<tr>
														<td><a href="#">Project 123GO</a></td>
														<td>
															<div class="progress">
																<div class="progress-bar" role="progressbar"
																	aria-valuenow="68" aria-valuemin="0"
																	aria-valuemax="100" style="width: 68%;">
																	<span>68% Complete</span>
																</div>
															</div>
														</td>
														<td><img src="assets/img/user1.png" alt="Avatar"
																class="avatar img-circle"> <a href="#">Antonius</a></td>
														<td><span class="label label-success">ACTIVE</span></td>
													</tr>
													<tr>
														<td><a href="#">Wordpress Theme</a></td>
														<td>
															<div class="progress">
																<div class="progress-bar" role="progressbar"
																	aria-valuenow="75" aria-valuemin="0"
																	aria-valuemax="100" style="width: 75%;">
																	<span>75%</span>
																</div>
															</div>
														</td>
														<td><img src="assets/img/user2.png" alt="Avatar"
																class="avatar img-circle"> <a href="#">Michael</a></td>
														<td><span class="label label-success">ACTIVE</span></td>
													</tr>
													<tr>
														<td><a href="#">Project 123GO</a></td>
														<td>
															<div class="progress">
																<div class="progress-bar progress-bar-success"
																	role="progressbar" aria-valuenow="100"
																	aria-valuemin="0" aria-valuemax="100"
																	style="width: 100%;">
																	<span>100%</span>
																</div>
															</div>
														</td>
														<td><img src="assets/img/user1.png" alt="Avatar"
																class="avatar img-circle" /> <a href="#">Antonius</a>
														</td>
														<td><span class="label label-default">CLOSED</span></td>
													</tr>
													<tr>
														<td><a href="#">Redesign Landing Page</a></td>
														<td>
															<div class="progress">
																<div class="progress-bar progress-bar-success"
																	role="progressbar" aria-valuenow="100"
																	aria-valuemin="0" aria-valuemax="100"
																	style="width: 100%;">
																	<span>100%</span>
																</div>
															</div>
														</td>
														<td><img src="assets/img/user5.png" alt="Avatar"
																class="avatar img-circle" /> <a href="#">Jason</a></td>
														<td><span class="label label-default">CLOSED</span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- END TABBED CONTENT -->
							</div>
							<!-- END RIGHT COLUMN -->
						</div>
					</div>


				</div>
			</div>
			<!-- END MAIN CONTENT -->
			<!-- MODEL START -->
			<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="ModalScrollableTitle"><i class="fa fa-plus-square"></i> Add Raw Materials</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="">
								<div class="modal-body">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-barcode "></i></span>
										<input type="text" id="search_product" class="form-control" name="search_product" style="height: 100%;" placeholder="Search products here">
										<span class="input-group-addon">.00</span>
									</div>
									<table class="table items table-striped table-bordered table-condensed table-hover" id="raw_mat_table" style="margin-top: 20px;">
										<thead>
											<tr>
												<th class="col-md-10">Product Name (Product Code)</th>
												<th class="col-md-1">Quantity</th>
												<th class="col-md-1 text-center"><i class="fa fa-trash-o"></i></th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($recipe as $row) {
												echo	'<tr class="child" id="row_' . $row->product_id . '" data-product_id="' . $row->product_id . '">' .
													'<td>' . $row->product_name . ' (' . $row->product_code . ')' .
													'<input type="hidden"     name="product_id[]" value="' . $row->product_id . '" id="product_id_' . $row->product_id . '"></td>' .
													'<td>' .
													'<input type="text"   name="quantity[]" class="form-control text-center variable" value="' . $row->raw_mat_qty . '" id="quantity_' . $row->product_id . '" >' .
													'</td>' .
													'<td>' .
													'<a class="btn btn-danger delrow" onclick="delete_row(' . $row->raw_mat_id . ')"><i class="fa fa-times" style="cursor:pointer;"></i></a>' .
													'</td>' .
													'</tr>';
											}
											?>
										</tbody>
										<!-- <tfoot>
											<tr>
												<td colspan="5" id="total" class="text-right">
													0.00
												</td>
											</tr>
										</tfoot> -->
									</table>
								</div>
							</form>
						</div>
						<div class="modal-footer collapse">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>
			<!-- MODEL END -->
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
	<script src="<?php echo assets_url(); ?>/js/form_validations-assign_rawm.js"></script>
	<script type="text/javascript" src="<?php echo assets_url(); ?>/js/jquery-ui.min.js"></script>
	<?php $this->load->view('common/datatable_js') ?>
	<script>
		$(document).ready(function() {
			products_load();
		});

		function products_load() {
			$('#products_table').DataTable({
				"dom": 'Blfrtip',
				"ajax": {
					url: "<?php echo base_url('products/get_list') ?>",
					type: "POST",
					data: {
						"cat_id": $('#category').val(),
						"sub_cat_id": $('#subcategory').val(),
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
					for (var i = 0; i < aaData.length; i++) {
						/*p = (aaData[aiDisplay[i]][2]).split('__');*/
						console.log(parseFloat(aaData[[i]][3]));
					}
					//var nCells = nRow.getElementsByTagName('th');
					//nCells[3].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot1, "", 2, ",", ".") + ' </div>';
				}
			});
		}
		$('select#category').on('change', function() {
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
						/* $("#subcategory").select2({
							allowClear: true
						}); */
					} else {
						$('#subcat_data').empty();
						var default_data = '<select name="subcategory" id="subcategory" class="form-control search-select" data-placeholder="Select Category to load Subcategories"></select>';
						$('#subcat_data').html(default_data);
						/* $("#subcategory").select2({
							allowClear: true
						}); */
					}
				},
				error: function() {
					bootbox.alert('Error occured while getting data from server.');
				}

			});
		});
		/**
		 * scripts for search items
		 */
		$('#search_product').autocomplete({
			source: '<?php echo base_url(); ?>products/suggestions',
			minLength: 3,
			autoFocus: true,
			delay: 5,
			response: function(event, ui) {
				if (ui.content.length == 1 && ui.content[0].product_id != 0) {
					/* ui.item = ui.content[0];
					$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
					$(this).autocomplete('close');
					$(this).removeClass('ui-autocomplete-loading'); */
				} else if (ui.content.length == 0) {
					var noResult = {
						value: "",
						label: "No matching result found! Product might be out of stock in the selected warehouse."
					};
					ui.content.push(noResult);
				} else {

				}
			},
			select: function(event, data) {
				if (data.item.value) {
					var rowCount = $('#raw_mat_table > tbody > tr').length;
					var is_added = false;
					var prompt_msg = 'Enter quantity for :' + data.item.value.product_name;
					if (is_added_product(data.item.value.product_id)) {
						prompt_msg = 'Add quantity for <strong>' + data.item.value.product_name + '</strong>'
						is_added = true;
					}
					/* if ($('#quantity_' + data.item.value.product_id).length) {
						prompt_msg = 'Add quantity for <strong>' + data.item.value.product_name + '</strong>'
						is_added = true;
					} */
					bootbox.prompt({
						title: prompt_msg,
						/* centerVertical: true, */
						callback: function(result) {
							if (result != null && !isNaN(result)) {
								data.item.value.product_quantity = result;
								console.log(data.item.value);
								/* set package for db */
								var op_item = {
									product_id: data.item.value.product_id,
									quantity: data.item.value.product_quantity,
									price: data.item.value.product_cost,
									change_method: 'add'
								};
								set_purchase_items(op_item, data.item.value, is_added);
							} else {
								toastr.warning("Invalid quantity");
								setTimeout(() => {
									$('#search_product').val('').focus();
								}, 100);
							}
						}
					});
					return false;
				}
				$(this).autocomplete('close');
				$(this).removeClass('ui-autocomplete-loading');
			}
		});

		function is_added_product(product_id) {
			if ($('#quantity_' + product_id).length) {
				/* $('#quantity_' + product_id).focus(); */
				return true;
			} else return false;
		}

		function add_to_list(value) {
			var qty = value.product_quantity;
			var sub_total = qty * value.product_cost;
			$('#raw_mat_table tr:first').after(
				'<tr class="child" id="row_' + value.product_id + '" data-product_id="' + value.product_id + '">' +
				'<td>' + value.product_name + ' (' + value.product_code + ')' +
				'<input type="hidden"     name="product_id[]" value="' + value.product_id + '" id="product_id_' + value.product_id + '"></td>' +

				'<td>' +
				'<input type="text"   name="quantity[]" class="form-control text-center variable" value="' + qty + '" id="quantity_' + value.product_id + '" >' +
				'</td>' +
				'<td>' +
				'<a class="btn btn-danger delrow" onclick="delete_row(' + value.product_id + ')"><i class="fa fa-times" style="cursor:pointer;"></i></a>' +
				'</td>' +
				'</tr>');
			$('#search_product').focus();
		}

		function delete_row(raw_mat_id) {
			var product_id = $('#product_id').val();
			bootbox.confirm({
				message: "This is a confirm with custom button text and color! Do you like it?",
				buttons: {
					confirm: {
						label: 'Yes',
						className: 'btn-success'
					},
					cancel: {
						label: 'No',
						className: 'btn-danger'
					}
				},
				callback: function(result) {
					if (result) {
						$.ajax({
							url: "<?php echo base_url('products/delete_raw_mat') ?>",
							data: {
								product_id: product_id,
								raw_mat_id: raw_mat_id
							},
							method: "POST",
							dataType: "JSON",
							success: function(data) {
								if (data.success) {
									var row = '#row_' + product_id;
									$(row).remove();
									toastr.warning("Item Deleted");
								} else {
									toastr.info("Error");
									console.time('Delete Item');
									console.error(data.responseText);
								}
							},
							error: function(data) {
								bootbox.alert(data.responseText);
							}
						});
					}
				}
			});
		}

		function set_purchase_items(op_item, value, is_added) {
			if (!validations()) {
				return false;
			}
			var success = false;
			var product_id = $('#product_id').val();
			$.ajax({
				url: "<?php echo base_url('products/set_raw_materials') ?>",
				method: "POST",
				data: {
					product_id: product_id,
					raw_mat_id: value.product_id,
					raw_mat_qty: op_item.quantity
				},
				dataType: "JSON",
				success: function(data) {
					success = data.success;
					if (data.success) {
						if (!is_added) {
							add_to_list(value);
						} else {
							if (value.product_id > 0) {
								$('#quantity_' + data.product_id).val(data.current_quantity);
								$('#search_product').val("").focus();
							}
						}
						$('#search_product').val('');
					} else {
						toastr.error("Unable to cennect with server!");
						console.error(data.responseText);
					}
				},
				error: function(data) {
					toastr.error(data.responseText);
					$('#search_prouct').val("");
					//bootbox.alert(data.responseText);
				}
			});

			/* */
			return success;
		}

		function validations() {
			/* if (!$('#branch_id').val()) {
				bootbox.alert("Select warehouse");
				return false;
			}
			if (!$('#supplier_id').val()) {
				bootbox.alert("Select supplier");
				return false;
			} */
			return true;
		}
		$('.variable').on('change', function(event) {
			console.log(event.target);
			console.info($(event.target).closest('tr'));
		});
	</script>

</body>

</html>