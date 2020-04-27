<!DOCTYPE html>
<html lang="en" xmlns:background="http://www.w3.org/1999/xhtml">
<head>
    <title>Login V1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assetLogin/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assetLogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assetLogin/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assetLogin/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assetLogin/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assetLogin/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assetLogin/css/main.css')}}">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter"  >
    <div class="container-login100" >
        <div class="wrap-login100" {{--style="background: url('{{asset('uploads/image/4.jpeg')}}'); background-size: cover;"--}}  >
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{asset('assets/assetLogin/images/img-01.png')}}" alt="IMG">
            </div>

            <form class="login100-form validate-form" method="POST" action="{{--{{ route('admin.login.submit') }}--}}">
                @csrf
					<span class="login100-form-title">Member Login</span>
                @if($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                        </button>
                        {{$message}}
                    </div>
                @endif
                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input id="email"  type="email" class="input100 form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <input id="password" class="input100 form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>


                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">Login</button>
                </div>

                <div class="text-center p-t-12">
						<span class="txt1">Forgot</span>
                    <a class="txt2" href="#">Username / Password?</a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="#">Create your Account<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>




<!--===============================================================================================-->
<script src="{{asset('assets/assetLogin/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('assets/assetLogin/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('assets/assetLogin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('assets/assetLogin/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('assets/assetLogin/vendor/tilt/tilt.jquery.min.js')}}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="{{asset('assets/js/main.js')}}"></script>

</body>
</html>