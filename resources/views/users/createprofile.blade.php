@extends('layouts.loginlayout')

@section('content')
<div class="main">

    <!-- Sign up form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Sign up</h2>
                    @if (session('error'))

                    <div class="alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ session('error') }}</strong>
                    </div>
                    @endif
                    <form action="{{ url('/createaccount')}}" method="post" class="register-form" id="register-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="empfirstname"><i class="zmdi zmdi-account-box-mail"></i></label>
                            <input type="text" name="empfirstname" placeholder="Firstname" value="{{ old('empfirstname')}}" required="required">
                        </div>
                        <div class="form-group">
                            <label for="emplastname"><i class="zmdi zmdi-account-box-mail"></i></label>
                            <input type="text" name="emplastname" placeholder="Lastname" value="{{ old('emplastname')}}" required="required">
                        </div>
                        <div class="form-group">
                            <label for="username"><i class="zmdi zmdi-account"></i></label>
                            <input type="text" name="username" placeholder="Username" value="{{ old('username')}}" required="required">
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" value="{{old('password')}}" placeholder="Password" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-assignment"></i></label>
                            <select name="position">
                                <option value="">Select Position...</option>
                                <option value="manager">Manager</option>
                                <option value="cashier">Cashier</option>
                                <option value="receptionist">Receptionist</option>
                                <option value="kitchen staff">Kitchen Staff</option>
                                <option value="waiter">Waiter</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image"><i class="zmdi zmdi-image"></i></label>
                            <input type="file" name="image" id="image" />
                            @if ($errors->has('image'))
                  <span class="text-danger">{{ $errors->first('image') }}</span>
                  @endif
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                        </div>
                        <div class="form-group">
                            <a href="{{url('/login')}}" class="signup-image-link">I am already member</a>
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="{{asset('/login-signup/images/signup-image.jpg')}}" alt="sign up image"></figure>
                </div>
            </div>
        </div>
    </section>
</div>
@include('sweetalert::alert')
@endsection