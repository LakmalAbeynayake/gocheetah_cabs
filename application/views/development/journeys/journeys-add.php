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

		#map,
		#map_drop_off {
			width: 100%;
			height: 300px;
			background-color: grey;
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
									<h2 class="panel-title text-center"><strong>NEW JOURNEY</strong></h2>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<!-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> -->
									</div>
								</div>
								<form action="" id="add_product_form">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1"> Set Pick-Up
												*</label>
											<div class="col-sm-9">
												<div class="input-group">
													<input class="form-control" type="text" id="srh_address" placeholder="Enter address here">
													<!-- <span class="input-group-btn"><button class="btn btn-primary" id="search" type="button">SEARCH!</button></span> -->
												</div>
												<div class="">
													<div class="col-sm-6">LAT:<input type="text" id="lat" name="lat" value="" /></div>
													<div class="col-sm-6">LNG:<input type="text" id="lng" name="lng" value="" /></div>
												</div>
												<div class="metric">
													<div id="map"></div>
												</div>
											</div>
										</div>


										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1"> Set Drop-Off
												*</label>
											<div class="col-sm-9">
												<div class="input-group">
													<input class="form-control" type="text" id="srh_address_drop_off" placeholder="search address here">
													<span class="input-group-btn"><button class="btn btn-primary" id="search_drop_off" type="button">SEARCH!</button></span>
												</div>
												<div class="">
													<div class="col-sm-6">LAT:<input type="text" id="lat_drop_off" name="lat_drop_off" value="" /></div>
													<div class="col-sm-6">LNG:<input type="text" id="lng_drop_off" name="lng_drop_off" value="" /></div>
												</div>
												<div class="metric">
													<div id="map_drop_off"></div>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-12 control-label text-center" id="distance"> --:-- KM</label>
											<input type="hidden" id="distance_val" value="" name="distance">
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1"> Select Vehicle Category *</label>
											<div class="col-sm-9">
												<select class="form-control" id="category" name="category">
													<option value="">&nbsp;</option>
													<?php foreach ($main_category as $key => $category) { ?>
														<option value="<?php echo $category->cat_id; ?>" data-rate="<?php echo $category->cat_price; ?>"><?php echo $category->cat_name . " - Rs " . $category->cat_price . " / km"; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label text-center" id="total"> RS --.-- </label>
											<input type="hidden" id="total_val" name="total_val" value="">
										</div>


										<div class="form-group">
											<div class="col-sm-12">
												<p></p>
												<button disabled class="btn btn-primary btn-squared pull-right" type="submit" id="book_now"> Book Now </button>
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
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"></script>
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
				rate = $(this).find(':selected').data('rate');

				distance_val = $('#distance_val').val();

				$('#total').text("Minimum rate : Rs " + (distance_val * rate).toFixed(2));
				$('#total_val').val(distance_val * rate);

				/* check availability */
				$.ajax({
					type: "post",
					async: false,
					url: "<?php echo base_url('vehicles/check'); ?>",
					data: {
						category_id: category_id
					},
					dataType: "json",
					success: function(data) {
						if (data.success) {
							$('#book_now').removeAttr("disabled");
						} else {
							$('#book_now').attr("disabled",true);
							bootbox.alert("No vehicles available at the moment!");
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
				url: "<?php echo base_url('journeys/save'); ?>",
				type: "POST",
				data: new FormData(form),
				dataType: "JSON",
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false, // To send DOMDocument or non processed data file it is set to false
				success: function(data) // A function to be called if request succeeds
				{
					if (data.success) {
						bootbox.alert("Booking Added Successfully",function(){
							window.location.href = "<?php echo base_url('myjourney'); ?>";
						});
						
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

		/* maps */
		function initMap() {
			/* pickup */
			map = new google.maps.Map(document.getElementById('map'), {
				center: {
					lat: 6.927079,
					lng: 79.861244
				},
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var myMarker = new google.maps.Marker({
				position: new google.maps.LatLng($('#lat').val(), $('#lng').val()), //(6.927079, 79.861244),
				draggable: true
			});
			map.setCenter(myMarker.position);
			myMarker.setMap(map);
			/* drop off */
			map_drop_off = new google.maps.Map(document.getElementById('map_drop_off'), {
				center: {
					lat: 6.927079,
					lng: 79.861244
				},
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var myMarker_drop_off = new google.maps.Marker({
				position: new google.maps.LatLng($('#lat_drop_off').val(), $('#lng_drop_off').val()), //(6.927079, 79.861244),
				draggable: true
			});
			map_drop_off.setCenter(myMarker_drop_off.position);
			myMarker_drop_off.setMap(map_drop_off);

			var poss = {
				lat: "6.927079",
				lng: "79.861244"
			}

			changeMarkerPosition_drop_off(map_drop_off, myMarker_drop_off, poss.lat, poss.lng);

			/* $('#set_latlng').on('click', function() {
				var lat = $('#lat').val();
				var lng = $('#lng').val();
				map.setCenter({
					lat: lat,
					lng: lng
				});
				changeMarkerPosition(map, myMarker, lat, lng);
				myLatLng = new google.maps.LatLng({
					lat: parseFloat(lat),
					lng: parseFloat(lng)
				});
				geocodeLatLng(geocoder, map, myMarker, myLatLng);
			}); */
			var geocoder = new google.maps.Geocoder();
			/*$('#srh_area_id').on('change', function() {
				var address = "";
				var data = $('#srh_area_id').select2('data');
				if (data) {
					address = data.text;
				}
				geocodeAddress(geocoder, map, myMarker,address);
			});*/



			/* $('#search').on('click', function() {
				var address = $('#srh_address').val();
				geocodeAddress(geocoder, map, myMarker, address);
			}); */
			google.maps.event.addListener(myMarker, 'dragend', function(evt) {
				changeMarkerPosition(map, myMarker, evt.latLng.lat(), evt.latLng.lng());
			});
			google.maps.event.addListener(map, 'click', function(event) {
				changeMarkerPosition(map, myMarker, event.latLng.lat(), event.latLng.lng());
				//set_lat_lng(event.latLng.lat(),event.latLng.lng());
				map.setCenter(event.latLng);
				geocodeLatLng(geocoder, map, myMarker, event.latLng);
			});
			/* drop off */

			google.maps.event.addListener(myMarker_drop_off, 'dragend', function(evt) {
				changeMarkerPosition_drop_off(map_drop_off, myMarker_drop_off, evt.latLng.lat(), evt.latLng.lng());
			});
			google.maps.event.addListener(map_drop_off, 'click', function(event) {
				changeMarkerPosition_drop_off(map_drop_off, myMarker_drop_off, event.latLng.lat(), event.latLng.lng());
				//set_lat_lng(event.latLng.lat(),event.latLng.lng());
				map_drop_off.setCenter(event.latLng);
				geocodeLatLng(geocoder, map_drop_off, myMarker_drop_off, event.latLng);
			});

			/*google.maps.event.addListener(myMarker, 'dragstart', function (evt) {
				//document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
			});*/


			//ask location start
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					changeMarkerPosition(map, myMarker, position.coords.latitude, position.coords.longitude);
					/* var content = "Location found!";
					info_window(map, pos, content) */
					map.setCenter(pos);
				}, function() {
					handleLocationError(true, map.getCenter());
				});
			} else {
				// Browser doesn't support Geolocation
				handleLocationError(false, map.getCenter());
			}
			//ask location end

			/*end info Window*/
		}

		function info_window(map, pos, content) {
			/*info Window*/
			infoWindow = new google.maps.InfoWindow;
			infoWindow.setPosition(pos);
			infoWindow.setContent(content);
			infoWindow.open(map);
		}

		function handleLocationError(browserHasGeolocation, pos) {
			var content = browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.';
			info_window(map, pos, content)
		}

		function changeMarkerPosition(map, marker, lat, lng) {
			console.log("change mo");
			var latlng = new google.maps.LatLng(lat, lng);
			marker.setPosition(latlng);
			map.setCenter(marker.position);
			set_lat_lng(lat, lng);
		}

		function changeMarkerPosition_drop_off(map, marker, lat, lng) {
			var latlng = new google.maps.LatLng(lat, lng);
			marker.setPosition(latlng);
			map.setCenter(marker.position);
			set_lat_lng_drop_off(lat, lng);
		}

		function geocodeAddress(geocoder, resultsMap, marker, address) {
			address += " Sri Lanka";
			geocoder.geocode({
				'address': address
			}, function(results, status) {
				if (status === 'OK') {
					resultsMap.setCenter(results[0].geometry.location);
					geocodeLatLng(geocoder, map, marker, results[0].geometry.location);
					//console.log("location:"+results[0].geometry.location);
					//console.log("latlng:"+results[0].geometry.location.lat()+","+results[0].geometry.location.lng());
					//console.log();
					changeMarkerPosition(resultsMap, marker, results[0].geometry.location.lat(), results[0].geometry.location.lng());
				} else {
					bootbox.alert('Geocode was not successful for the following reason: ' + status);
					set_lat_lng(0, 0);
				}
			});
		}

		function geocodeLatLng(geocoder, resultsMap, marker, latLng) { //alert("came here");
			geocoder.geocode({
				'latLng': latLng
			}, function(results, status) {
				if (status === 'OK') {
					if (results[0]) {
						bootbox.confirm({
							title: "Change Delivery address?",
							message: "A new address found for your search. Do you want to change old address to new one?<br><br> New address:<b><i>" + results[0].formatted_address + "</i></b>",
							buttons: {
								cancel: {
									label: '<i class="fa fa-times"></i> Cancel'
								},
								confirm: {
									label: '<i class="fa fa-check"></i> Change'
								}
							},
							callback: function(result) {
								console.log('This was logged in the callback: ' + result);
								if (result === true) {
									$('#shipping_address').val(results[0].formatted_address);
								}
							}
						});
					}
				}
			});
		}

		function set_lat_lng(lat, lng) {
			console.log(lat + "/" + lng)
			$('#lat').val(lat);
			$('#lng').val(lng);
		};

		function set_lat_lng_drop_off(lat, lng) {
			console.log(lat + "/" + lng)
			$('#lat_drop_off').val(lat);
			$('#lng_drop_off').val(lng);
			distance();
		};

		function distance() {
			lat_drop_off = $('#lat_drop_off').val();
			lng_drop_off = $('#lng_drop_off').val();

			var p1 = {
				lat: lat_drop_off,
				lng: lng_drop_off
			}

			latt = $('#lat').val();
			lngg = $('#lng').val();

			var p2 = {
				lat: latt,
				lng: lngg
			}
			var dis = getDistance(p1, p2);
			if (dis < 1000)
				$('#distance').text(dis.toFixed(2) + " KM");
			$('#distance_val').val(dis.toFixed(2));
		}

		var rad = function(x) {
			return x * Math.PI / 180;
		};

		var getDistance = function(p1, p2) {
			var R = 6378137; // Earth’s mean radius in meter
			var dLat = rad(p2.lat - p1.lat);
			var dLong = rad(p2.lng - p1.lng);
			var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
				Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat)) *
				Math.sin(dLong / 2) * Math.sin(dLong / 2);
			var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			var d = R * c;
			return (d / 1000); // returns the distance in km
		};
	</script>
</body>

</html>