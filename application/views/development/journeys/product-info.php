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
							<h2 class="panel-title"><strong>PRODUCT INFO</strong></h2>
							<div class="right">
								<a href="<?php echo base_url() ?>products">Products</a> / Product Info
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
										<img style="max-height: 200px;" src="<?php echo $product->product_image; ?>" class="img-circle" alt="Avatar">
										<h3 class="name"><?php echo $product->product_name; ?></h3>
										<?php echo ($product->product_status) ? '<span class="online-status status-available">Available</span>' : '<span class="online-status status-unavailable">Unavailable</span>' ?>
									</div>
								</div>
								<div class="profile-info">

								</div>
								<div class="text-center">
									<?php
									$disable = '<a data-product_id=' . $product->product_id . '" class="btn btn-warning disable"><i class="fa fa-minus-circle"></i> Disable Product</a>';
									$enable  = '<a data-product_id=' . $product->product_id . '" class="btn btn-warning"><i class="fa fa-plus-circle"></i> Disable Product</a>';
									$show = ($product->product_status) ? $disable : $enable;
									echo $show;
									?>
									<a href="<?php echo base_url() . 'products/edit?product_id=' . $product->product_id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Product</a>
									<a href="" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong"><i class="fa fa-plus-square"></i> Add Raw Materials</a>
								</div>
								<!-- END PROFILE HEADER -->
							</div>
							<!-- END LEFT COLUMN -->

							<!-- RIGHT COLUMN -->
							<div class="profile-right">
								<h4 class="heading"><?php echo $product->product_name; ?></h4>
								<input type="hidden" id="product_id" value="<?php echo $product->product_id; ?>">

								<div class="tab-content">
									<div class="tab-pane fade in active" id="tab-bottom-left2">
										<div class="table-responsive">
											<table class="table project-table">
												<thead>
													<tr>
														<th>Title</th>
														<th>Value</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Product Code</td>
														<td><?php
															echo $product->product_code; ?></td>
													</tr>
													<tr>
														<td>Product Name</td>
														<td><?php echo $product->product_name; ?></td>
													</tr>
													<?php
													if (isset($product->cat_name)) {
													?>
														<tr>
															<td>Product Category</td>
															<td><?php echo $product->cat_name; ?></td>
														</tr>
													<?php
													}
													?>
													<?php
													if (isset($product->sub_cat_name)) {
													?>
														<tr>
															<td>Product Sub Category</td>
															<td><?php echo $product->sub_cat_name; ?></td>
														</tr>
													<?php
													}
													?>
													<tr>
														<td>Product Cost</td>
														<td><?php echo $product->product_cost; ?></td>
													</tr>
													<tr>
														<td>Product Price</td>
														<td><?php echo $product->product_price; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- END TABBED CONTENT -->
								<br>
								<br>
								<br>
								<br>
								<br>
							</div>
							<!-- END RIGHT COLUMN -->
						</div>
					</div>

				</div>
			</div>
			<!-- END MAIN CONTENT -->
			<!-- MODEL START -->
			<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
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

			var conf = bootbox.confirm({
				message: "Changes will be applied immedietly. Are you sure?",
				centerVertical: true,
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
			/* conf.on("shown.bs.modal", function() {
				$('body > div.bootbox.modal.fade.bootbox-confirm.in').css("display", "flex").css("align-items", "center");
			}); */
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