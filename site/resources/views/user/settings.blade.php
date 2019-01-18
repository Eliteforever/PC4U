@extends('layouts.header')

@section('content')

<div id="container">
	<h1>{{ \App\Traits\nameTrait::getSpecificName($combined[0]['id']) }}</h1>
	
		
	<form method="post" action="{{ route('editUser') }}">
		{{ csrf_field() }}
    <div class="row">
        <div class="col s6">
            <input type="hidden" value="{{ $combined[0]['id'] }}" name="userID">
            <input name="firstName" type="text" placeholder="Voornaam" value="{{ $combined[0]['firstName'] }}" />
            <input name="middleName" type="text" placeholder="Tussenvoegsel" value="{{ $combined[0]['middleName'] }}" />
            <input name="lastName" type="text" placeholder="Achternaam" value="{{ $combined[0]['lastName'] }}"/>
            <input name="email" type="text" placeholder="Email" value="{{ $combined[0]['email'] }}"/>
            <p class="dimText">
                Laatst aangepast op {{ $combined[0]['updated_at'] }} {{ date_default_timezone_get() }}
            </p>
        </div>
        <div class="col s6">
            <input name="streetName" type="text" placeholder="Straat naam" value="{{ $combined[1]['streetName'] }}"/>
            <input name="houseNumber" type="text" placeholder="Huisnummer" value="{{ $combined[1]['houseNumber'] }}"/>
            <input name="postalCode" type="text" placeholder="Postcode" value="{{ $combined[1]['postalCode'] }}"/>
            <input name="city" type="text" placeholder="Woonplaats" value="{{ $combined[1]['city'] }}"/>
        </div>
        <div class="col s12">
            <button class="waves-effect waves-light btn" type="submit">Wijzig</button>
        </div>
    </div>
	</form>
</div>
@endsection
