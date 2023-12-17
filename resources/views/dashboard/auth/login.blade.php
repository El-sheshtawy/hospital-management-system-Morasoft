@extends('dashboard.layouts.master2')
@push('extra_css')
    <style>
		.login-form {
			display: none;
		}
	</style>

	{{-- Sidemenu respoansive tabs css --}}
	<link href="{{URL::asset('dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}"
		  rel="stylesheet">
@endpush
@section('content')
	<div class="container-fluid">
		<div class="row no-gutter">
			<!-- The image half -->
			<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
				<div class="row wd-100p mx-auto text-center">
					<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
						<img src="{{URL::asset('dashboard/img/media/login.png')}}"
							 class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
					</div>
				</div>
			</div>
			<!-- The content half -->
			<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
				<div class="login d-flex align-items-center py-2">
					<!-- Demo content-->
					<div class="container p-0">
						<div class="row">
							<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
								<div class="card-sigin">
									<div class="mb-5 d-flex">
										<a href="{{ url('/' . $page='index') }}">
											<img src="{{URL::asset('dashboard/img/brand/favicon.png')}}"
												 class="sign-favicon ht-40" alt="logo">
										</a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Va<span>le</span>x</h1></div>
									<div class="card-sigin">
										<div class="main-signup-header">
											<h2>{{ __('dashboard/auth.Welcome back') }}</h2>
											@if ($errors->any())
												<div class="alert alert-danger">
                                                         <h4 style="color: red" >{{ __('dashboard/auth.Login failed!') }}</h4>
                                                     <ul>
														@foreach ($errors->all() as $error)
															<li>{{ $error }}</li>
														@endforeach
													</ul>
												</div>
											@endif

											{{-- Select login type --}}
											<div class="form-group">
												<select class="form-control" id="sectionChooser">
													<option value="" selected disabled>
														Select Login or Register
													</option>
													<option value="login">Login</option>
                                                    <option value="register">Register</option>
                                                </select>
                                            </div>


											{{-- Login Form--}}
											<div class="login-form" id="login">
												<h5 class="font-weight-semibold mb-4">
													Login
												</h5>
												<form method="POST" action="{{ route('login.store') }}">
													@csrf
													<div class="form-group">
														<label>
												Email
														</label>
														<input class="form-control"
															   placeholder="Enter your email"
															   type="email" autofocus name="email" value="{{ old('email') }}">
													</div>
													<div class="form-group">
														<label>
															{{ __('dashboard/auth.Password') }}
														</label>
														<input class="form-control"
															   placeholder="Enter your password"
															   type="password" name="password">
													</div>
													<button type="submit" class="btn btn-main-primary btn-block">
														{{ __('dashboard/auth.Sign In') }}
													</button>
													<div class="row row-xs">
														<div class="col-sm-6">
															<button class="btn btn-block">
																<i class="fab fa-facebook-f">
																</i> Sign up with Facebook
															</button>
														</div>
														<div class="col-sm-6 mg-t-10 mg-sm-t-0">
															<button class="btn btn-info btn-block">
																<i class="fab fa-twitter"></i>
																Sign up with Twitter
															</button>
														</div>
													</div>
												</form>
												<div class="main-signin-footer mt-5">
													@if (Route::has('password.request'))
														<p>
															<a href="{{ route('password.request') }}">
																{{ __('dashboard/auth.Forgot password ?') }}
															</a>
														</p>
													@endif
													<p>
														{{__("dashboard/auth.Don't have an account ?")}} <br>
														<a href="{{ route('register.store') }}">
														{{ __('dashboard/auth.Create an Account') }}
														</a>
													</p>
												</div>
                                            </div>

                                            {{-- Register Form --}}
                                            <div class="login-form" id="register">
                                                <h5 class="font-weight-semibold mb-4">
                                             Register
                                                </h5>
                                                <form method="POST" action="{{ route('register.store') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>
                                                            {{ __('dashboard/auth.Email') }}"
                                                        </label>
                                                        <input class="form-control"
                                                               placeholder="Enter your email"
                                                               type="email" autofocus name="email" value="{{ old('email') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>
                                                            {{ __('dashboard/auth.Password') }}
                                                        </label>
                                                        <input class="form-control"
                                                               placeholder="Enter your password"
                                                               type="password" name="password">
                                                    </div>
                                                    <button type="submit" class="btn btn-main-primary btn-block">
                                                        {{ __('dashboard/auth.Sign In') }}
                                                    </button>
                                                    <div class="row row-xs">
                                                        <div class="col-sm-6">
                                                            <button class="btn btn-block">
                                                                <i class="fab fa-facebook-f">
                                                                </i> {{ __('dashboard/auth.Sign up with Facebook') }}
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                                            <button class="btn btn-info btn-block">
                                                                <i class="fab fa-twitter"></i>
                                                                {{ __('dashboard/auth.Sign up with Twitter') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                        </div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
		@endsection
@push('extra_js')
<script>
				$(document).ready(function() {
					$('#sectionChooser').change(function () {
						var myID = $(this).val();
						$('.login-form').each(function () {
							myID === $(this).attr('id') ? $(this).show() : $(this).hide();
						});
					});
				});
</script>
@endpush
