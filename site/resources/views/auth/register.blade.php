@extends('layouts.header') @section('content')
<div id="container">
    <div class="register-container">
        <div class="row">
            <div class="col-md-4 col-md-offset-8">
                <div class="login-box blue-grey lighten-5">
                    <p class="login-header">Registreer</p>
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col s6">
                                <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                                    <label for="firstName" class="col-md-4 control-label">First Name</label>

                                    <div class="col-md-6">
                                        <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required autofocus> @if ($errors->has('firstName'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('firstName') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('middleName') ? ' has-error' : '' }}">
                                    <label for="middleName" class="col-md-4 control-label">Middle Name</label>

                                    <div class="col-md-6">
                                        <input id="middleName" type="text" class="form-control" name="middleName" value="{{ old('middleName') }}" autofocus> @if ($errors->has('middleName'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('middleName') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                                    <label for="lastName" class="col-md-4 control-label">Last Name</label>

                                    <div class="col-md-6">
                                        <input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus> @if ($errors->has('lastName'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('lastName') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required> @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="form-group{{ $errors->has('phoneNumber') ? ' has-error' : '' }}">
                                    <label for="phoneNumber" class="col-md-4 control-label">Phone Number</label>

                                    <div class="col-md-6">
                                        <input id="phoneNumber" type="number" class="form-control" name="phoneNumber" value="{{ old('phoneNumber') }}" required autofocus> @if ($errors->has('phoneNumber'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('streetName') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('streetName') ? ' has-error' : '' }}">
                                    <label for="streetName" class="col-md-4 control-label">Street Name</label>

                                    <div class="col-md-6">
                                        <input id="streetName" type="text" class="form-control" name="streetName" value="{{ old('streetName') }}" required autofocus> @if ($errors->has('streetName'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('streetName') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('houseNumber') ? ' has-error' : '' }}">
                                    <label for="houseNumber" class="col-md-4 control-label">House Number</label>

                                    <div class="col-md-6">
                                        <input id="houseNumber" type="text" class="form-control" name="houseNumber" value="{{ old('houseNumber') }}" required autofocus> @if ($errors->has('houseNumber'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('houseNumber') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('postalCode') ? ' has-error' : '' }}">
                                    <label for="postalCode" class="col-md-4 control-label">Postal Code</label>

                                    <div class="col-md-6">
                                        <input id="postalCode" type="text" class="form-control" name="postalCode" value="{{ old('postalCode') }}" required autofocus> @if ($errors->has('postalCode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('postalCode') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="col-md-4 control-label">City</label>

                                    <div class="col-md-6">
                                        <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required autofocus> @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span> @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="login-button">
                                    Registreer
                                </button>
                                <p class="register-text-login" style="margin-bottom: 15px;">Heeft U al een account? <a class="register-text-href" href="{{ route('login') }}">Login</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
