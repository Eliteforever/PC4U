@extends('layouts.header')
@section('content')
<div id="container">
	<div id="contact-container">
		<div class="box">
			<h1>Contact us</h1>
			<div class="row">
		      <div class="col s6">
		      	@foreach($combined[0] as $contactData)
		      		<p> <i class="material-icons">email</i> {{ $contactData['email'] }}</p>
		      		<p> <i class="material-icons">phone</i> {{ $contactData['phoneNumber'] }}</p>
		      	@endforeach
		      	@foreach($combined[1] as $contactData)
		      		<p><i class="material-icons">home</i>  {{ \App\Traits\addressTrait::getAddressInfo(1) }}</p>
		      	@endforeach
		      </div>
		      <div class="col s6" style="border-left:1px solid #989898;height:500px">
		      	Andere informatie als bijvoorbeeld openings tijden idk ik voer maar gewoon wat in want ik weet niet wat hier komt
		      </div>
		    </div>
		</div>
	</div>
</div>
@endsection