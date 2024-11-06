@extends('layouts.master2')

@section('title')
تسجيل حساب جديد - برنامج الفواتير
@endsection

@section('css')
<!-- Sidemenu-responsive-tabs css -->
<link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row no-gutter">
			<!-- The content half -->
			<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
				<div class="login d-flex align-items-center py-2">
					<div class="container p-0">
						<div class="row">
							<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
								<div class="card-sigin">
									<div class="mb-5 d-flex">
										<a href="{{ route('dashboard') }}">
											<img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo">
										</a>
										<h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Invoice System</h1>
									</div>
									<div class="card-sigin">
										<div class="main-signup-header">
											<h2>مرحبا بك</h2>
											<h5 class="font-weight-semibold mb-4">حساب جديد</h5>
											<form method="POST" action="{{ route('register') }}">
												@csrf
												<div class="form-group">
													<label>الاسم </label>
													<input class="form-control @error('name') is-invalid @enderror" placeholder="أدخل اسمك " type="text" name="name" value="{{ old('name') }}" required>
													@error('name')
														<span class="invalid-feedback">{{ $message }}</span>
													@enderror
												</div>

												<div class="form-group">
													<label>البريد الإلكتروني</label>
													<input class="form-control @error('email') is-invalid @enderror" placeholder="أدخل بريدك الإلكتروني" type="email" name="email" value="{{ old('email') }}" required>
													@error('email')
														<span class="invalid-feedback">{{ $message }}</span>
													@enderror
												</div>
												<div class="form-group">
													<label>كلمة المرور</label>
													<input class="form-control @error('password') is-invalid @enderror" placeholder="أدخل كلمة المرور" type="password" name="password" required>
													@error('password')
														<span class="invalid-feedback">{{ $message }}</span>
													@enderror
												</div>
												<div class="form-group">
													<label>تأكيد كلمة المرور</label>
													<input class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="أعد إدخال كلمة المرور" type="password" name="password_confirmation" required>
													@error('password_confirmation')
														<span class="invalid-feedback">{{ $message }}</span>
													@enderror
												</div>
												<button class="btn btn-main-primary btn-block">إنشاء حساب</button>
											</form>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div><!-- End -->
				</div>
			</div><!-- End -->

			<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
				<div class="row wd-100p mx-auto text-center">
					<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
						<img src="{{URL::asset('assets/img/media/login.png')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
@endsection
