<html lang="en" class="fullscreen-bg">

<head>
	<title>Login | AAA Claims</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('assets/auth/main.css') }}">
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	
	<style type="text/css">
		.auth-box .right .overlay {
    		background: rgba(52, 44, 98, 0.92) !important;
		}
		.btn-primary {
		    background-color: #322B67;
		    border-color: #000;
		}
		.btn-primary:hover {
		    background-color: #39326A;
		    border-color: #39326A;
		    color: #FFF;
		}
		.auth-box .right .heading {
		    margin-top: 0;
		    margin-bottom: 5px;
		    font-size: 36px;
		    font-weight: 300;
		}
		.auth-box .right p {
		    margin: 0;
		    font-size: 26px;
		    font-weight: 300;
		}
</style>

</head>

<body>
	<!-- WRAPPER  -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"></div>
								<p class="lead">Login to your account</p>
							</div>
							@yield('content')
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading" style="text-align: center;">Claims Login</h1>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>