@extends('layouts.loginlayout')
@section('content')
<div class="main">

        <!-- Login  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{asset('/login-signup/images/signin-image.jpg')}}" alt="sign up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <form action="{{ url('/login')}}" method="post" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="username"><i><img src="{{asset('/assets/svg/person.svg')}}" width="10px" height="10px"></i></label>
								<input type="text" name="username" placeholder="Username" required="required">
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i><img src="{{asset('/assets/svg/lock-locked.svg')}}" width="10px" height="10px"></i></label>
								<input type="password"  name="password" placeholder="Password" required="required">
							</div>
                            @if (session('error'))
    
    <div class="alert alert-danger alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>{{ session('error') }}</strong> 
              </div>
      @endif
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
							</div>
							<div class="form-group">
							<a href="{{url('/createaccount')}}" class="signup-image-link">Create an account instead?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
    @include('sweetalert::alert')
@section('onchange')
<script>
$('.message a').click(function(){
	$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
@endsection
@endsection
