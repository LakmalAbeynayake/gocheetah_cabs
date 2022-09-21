<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login | SkyPOS Solutions</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php echo assets_url(); ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo assets_url(); ?>/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo assets_url(); ?>/vendor/linearicons/style.css">

	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo assets_url(); ?>/css/main.1.0.css">

	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="<?php echo assets_url(); ?>/css/demo.css">

	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo assets_url(); ?>/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo assets_url(); ?>/img/favicon.png">
	<style>
		.btn-notification {
			width: 100%;
			font-size: 18px;
			cursor: inherit;
			margin-top: -20px;
			display: none;
		}

		.btn-notification.btn-danger>i::before {
			content: "\f057";
			font-family: "FontAwesome";
			font-style: normal;
		}

		.btn-notification.btn-success>i::before {
			content: "\f00c";
			font-family: "FontAwesome";
			font-style: normal;
		}

		.btn-notification>span {
			margin-left: 10px;
		}
	</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center">
									<h1>RIDE LIKE A CHEETAH</h1>
								</div>
								<p class="lead">Login to your account</p>
							</div>
							<form class="form-auth-small" action="" id="login-form">
								<button id="error_msg" type="button" class="btn btn-danger btn-toastr btn-notification" data-context="error" data-message="This is error info" data-position="top-right"><i></i><span>Invalid username or password.</span></button>
								<button id="success_msg" type="button" class="btn btn-success btn-toastr btn-notification" data-context="error" data-message="This is error info" data-position="top-right"><i></i><span>Logged in successfully.</span></button>
								<div class="form-group">
									<label for="driver_username" class="control-label sr-only">Email</label>
									<input type="" class="form-control" id="driver_username" value="lakmal" placeholder="Email" required>
								</div>
								<div class="form-group">
									<label for="driver_password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" id="driver_password" value="demo1234" placeholder="Password" required>
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox">
										<span>Remember me</span>
									</label>
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span>
								</div>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<!-- <?php echo assets_url(); ?> -->
						<div class="content text" style="background-image: url(<?php echo assets_url(); ?>/img/logo.svg);height: 100%;background-repeat: round;">
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
	<?php $this->load->view('common/js') ?>
	<script>
		$('document').ready(function() {

		});
		$('#login-form').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('drivers/login') ?>",
				data: {
					driver_username: $('#driver_username').val(),
					driver_password: $('#driver_password').val()
				},
				dataType: "json",
				success: function(data) {
					if (!data.success) {
						$('#error_msg').show();
						setTimeout(() => {
							$('#error_msg').fadeOut(1000);
						}, 5000);
					} else {
						$('#error_msg').hide();
						$('#success_msg').fadeIn(100);
						setTimeout(() => {
							window.location.href = "<?php echo base_url('drivers/dashboard') ?>";
						}, 1000);
					}
				},
				error: function(data) {
					console.log(data);
				},
				dataType: "JSON"
			});
		})
	</script>
</body>

</html>