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
										<div class="form-group">
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
												<input type="file" onchange="encodeImageFileAsURL(this,'product_image')">
												<input type="hidden" name="product_image" id="product_image" class="form-control auto" data-a-sign="Rs. " data-d-group="2" value="">
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-12">
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
				allowClear: true
			});
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
						bootbox.alert('Error occured while getting data from server.');
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
						bootbox.alert("User Added Successfully");
						setTimeout(() => {
							window.location.href = "<?php echo base_url('products'); ?>";
						}, 3000);
					}else alert("Data Error");
				},error:function(data){
					bootbox.alert("ERROR!");
					console.log(data.responseText);
				}
			});
		}
	</script>
</body>

</html>