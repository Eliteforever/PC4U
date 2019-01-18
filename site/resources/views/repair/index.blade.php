@extends('layouts.header')

@section('content')
<div id="container">
	<form method="post" action="{{ route('repair/post') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<label for="orders">Selecteer een order</label>
		<select name="orders" class="browser-default">
			@foreach($finalOrders as $order)
			<option value="{{ $order[0] }}">{{ $order[1] }}</option>
			@endforeach
		</select>
		<label for="description">Wat is er fout?</label>
		<textarea name="description" placeholder="Description" required="required"></textarea>
		<label for="password">Typ het wachtwoord van de PC als u niet wilt dat het een factory reset krijgt.</label>
		<input type="text" placeholder="Password" name="password">
		<input type="file" name="fotoPad" accept="image/*">
		<input type="submit" name="submit">
	</form>
</div>
@endsection