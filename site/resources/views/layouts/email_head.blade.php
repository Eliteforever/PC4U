<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Thanks for your order!</title>
    <link href="{{ asset('css/email.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
</head>

<body>

<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" width="600">
			<div class="content">
				<table class="main" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="alert alert-good">
							Thanks for your order!
						</td>
					</tr>
					<tr>
						@yield('content')
					</tr>
				</table>
				<div class="footer">
					<table width="100%">
						<tr>
                            <td class="aligncenter content-block">&copy; <a href="{{ url('/') }}">PC4U</a> - {{ date('Y') }}</td>
						</tr>
					</table>
				</div></div>
		</td>
		<td></td>
	</tr>
</table>

</body>
</html>
