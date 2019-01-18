@extends('layouts.header')

@section('content')
<div id="container">
	<div class="login-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-8">
				<div class="login-box blue-grey lighten-5">
					<p class="login-header">Log In</p>
					<form method="POST" action="{{ route('login') }}">
							{{ csrf_field() }}
						<div class="form-group">
							<p class="input-text">Email</p>
							<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

							@if ($errors->has('email'))
								<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
						<div class="form-group">
							<p class="input-text">Password</p>
							<input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required>

							@if ($errors->has('password'))
								<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
						<button type="submit" class="login-button">
							Login
						</button>
						<p class="register-text-login">Nog geen account? <a class="register-text-href" href="{{ route('register') }}">Registreer</a></p>
						<p class="password-text-login"><a class="password-text-href" href="{{ url('password/reset') }}">Wachtwoord vergeten?</a></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection