<!doctype html>
<html lang="en">

<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">


	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="{{ asset('sidebar/css/css.css') }}" rel="stylesheet">

	<link href="{{ asset('sidebar/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="stylesheet" href="{{ asset('sidebar/css/style.css') }}">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<style>
		body {
			background: #eaeaea;
		}

		.icon {
			font-size: 23pt;
		}
	</style>

</head>

<body>

	<div class="wrapper d-flex align-items-stretch">
		<nav id="sidebar" class="order-last active" class="img" style="background-image: url('{{ asset('sidebar/images/bg_1.jpg') }}');">
			<div class="custom-menu">
				<button type="button" id="sidebarCollapse" class="btn btn-primary">
				</button>
			</div>
			<div class="">
				<h1><a href="" class="logo">S & A <span></span></a></h1>
				<ul class="list-unstyled components mb-5">
					<li class="active">
						<a href="{{ Route('Home') }}"><span class="fa fa-home mr-3"></span> Dashboard</a>
					</li>
					<li>
						<a href="{{ route('Company-register') }}"><span class="fa-solid fa-building mr-3"></span>Registration</a>
					</li>

					<li>
						<a href="{{ route('new-invoice-user-tree') }}"><span class="fa-solid fa-bullhorn mr-3"></span>Invoice Requests</a>
					</li>


					<li>
						<a href="{{ route('ongoing-invoice') }}"><span class="fa-solid fa-person-running mr-3"></span> Ongoing Invoices</a>
					</li>

					<li>
						<a href="{{ route('Approved-invoice') }}"><span class="fa-solid fa-clipboard-check mr-3"></span> Approved Invoices</a>
					</li>

					<li>
						<a href="{{ route('Outstanding-invoice') }}"><span class="fa-solid fa-clock mr-3"></span> Outstanding</a>
					</li>
					<li>
						<a href="{{ route('Receipt') }}"><span class="fa-solid fa-receipt mr-3"></span> Receipt</a>
					</li>
					<li>
						<a href="{{ route('login') }}"><span class="fa-solid fa-right-from-bracket mr-3"></span> Log Out</a>
					</li>
				</ul>

				<div class="mb-5 px-4">

				</div>

				<div class="footer px-4">
					<p class="mt-5 text-muted text-center">
						Open System Integrator <br> Anushka Piyumal
					</p>
				</div>

			</div>

		</nav>

		<!-- Page Content  -->
		<div id="content" class="p-4 p-md-5 pt-5">
			<h2 class="mb-4"><a href="@yield('link')" class="btn"><i class="@yield('icon') icon"></i></a>@yield('pageTitle')</h2>


			@if(session('good'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{ session('good') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			@endif

			@if(session('bad'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				{{ session('bad') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			@endif

			@yield('content')

		</div>
	</div>

	<script src="{{ asset('sidebar/js/jquery.min.js') }}"></script>
	<script src="{{ asset('sidebar/js/popper.js') }}"></script>
	<script src="{{ asset('sidebar/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('sidebar/js/main.js') }}"></script>

</body>

</html>