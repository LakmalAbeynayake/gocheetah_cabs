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
									<h2 class="panel-title"><strong>ADD PRODUCTS</strong></h2>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<!-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> -->
									</div>
								</div>
								<form action="" id="add_product_form">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1"> Product Name
												*</label>
											<div class="col-sm-9">
												<input type="text" id="product_name" class="form-control" name="product_name">
											</div>
										</div>
										<div class="form-group collapse">
											<label class="col-sm-2 control-label" for="form-field-2"> Product Code
												*</label>
											<div class="col-sm-9">
												<input type="text" id="product_code" class="form-control" name="product_code" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-3"> Category* </label>
											<div class="col-sm-9">
												<select class="form-control search-select" id="category" name="category">
													<option value="">&nbsp;</option>
													<?php foreach ($main_category as $key => $category) { ?>
														<option value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-3"> Sub Category </label>
											<div id="subcat_data" class="col-sm-9">
												<select data-placeholder="Select category to load sub-categories" id="subcategory" class="form-control search-select" name="subcategory">
													<option selected="selected" value=""></option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2"> Product Unit * </label>
											<div class="col-sm-9">
												<select class="form-control search-select" id="unit" name="unit">
													<?php foreach ($unit_type as $key => $unit) {
														if ($unit->unit_code == "Item") {
															echo "<option selected value='$unit->unit_id'>$unit->unit_code</option>";
														} else {
															echo "<option value='$unit->unit_id'>$unit->unit_code</option>";
														}
													} ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2"> Retail Price * </label>
											<div class="col-sm-9">
												<input type="text" id="product_price" class="form-control auto" name="product_price" data-a-sign="Rs. " data-d-group="2">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2"> Product Cost * </label>
											<div class="col-sm-9">
												<input type="text" name="product_cost" id="product_cost" class="form-control auto" data-a-sign="Rs. " data-d-group="2" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2"> Product Description </label>
											<div class="col-sm-9">
												<textarea class="ckeditor form-control" cols="10" rows="10" id="product_description" name="product_description"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2"> Product Image </label>
											<div class="col-sm-9">
												<img id="product_image_pv" src="" alt="" style="max-width: 100px;" alt="no-image">
												<label for="product_image_select">
													<a class="btn btn-sm btn-success">SELECT</a>
													<input style="display: none;" id="product_image_select" type="file" onchange="encodeImageFileAsURL(this,'product_image')">
												</label>
												<button class="btn btn-sm btn-info" id="reset_image"><i class="fa fa-times"></i></button>
												<input type="hidden" name="product_image" id="product_image" class="form-control auto" value="">
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-12">
												<p></p>
												<button class="btn btn-primary btn-squared pull-right" type="submit"> Add Product </button>
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
	<script src="<?php echo assets_url(); ?>/js/form_validations-add_product.js"></script>
	<script>
		$(document).ready(function() {
			FormValidator.init();

			$(".search-select").select2({
				//allowClear: true
			});
			$('#product_image').val("data:image/jpeg;base64,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");
			$('#product_image_pv').attr("src", "data:image/jpeg;base64,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");
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
							$("#subcategory").select2({
								allowClear: true
							});
						} else {
							$('#subcat_data').empty();
							var default_data = '<select name="subcategory" id="subcategory" class="form-control search-select" data-placeholder="Select Category to load Subcategories"></select>';
							$('#subcat_data').html(default_data);
							$("#subcategory").select2({
								allowClear: true
							});
						}
					},
					error: function() {
						alert('Error occured while getting data from server.');
					}

				});
			});
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

		function add_product(form) {
			$.ajax({
				url: "<?php echo base_url('products/save_product'); ?>",
				type: "POST",
				data: new FormData(form),
				dataType: "JSON",
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false, // To send DOMDocument or non processed data file it is set to false
				success: function(data) // A function to be called if request succeeds
				{
					if (data.success) {
						bootbox.alert("Product added Successfully");
						window.location.href = "<?php echo base_url('products'); ?>";
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
			$('#product_image').val("data:image/jpeg;base64,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");
			$('#product_image_pv').attr("src", "data:image/jpeg;base64,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");
		});
	</script>
</body>

</html>