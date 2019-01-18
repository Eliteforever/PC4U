@extends('layouts.header')

<link rel="stylesheet" href="<?php echo asset('css/imageSelector.css')?>" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<meta id="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div id="container">
	<div id="contact-container">
		<div class="box">
			<h1>Form 1</h1>
			<form method="get" action="/imageTest">
				<button class="imageSelectorButton" type="button" onclick="imageSelectorHandler.show(this)">Selecteer Foto</button>
				<p id="selectedImageName"></p>
				<img id="selectedImage" src="" />
				<input type="text" name="bladiebla" value="Mickey" />
				<input type="submit" />
			</form>
		</div>

		<div class="box">
			<h1>Form 2</h1>
			<form method="get" action="/imageTest">
				<button class="imageSelectorButton" type="button" onclick="imageSelectorHandler.show(this)">Selecteer Foto</button>
				<p id="selectedImageName"></p>
				<img id="selectedImage" src="" />
				<input type="text" name="bladiebla" value="Mause" />
				<input type="submit" />
			</form>
		</div>

		<div class="box">
			<h1>JS</h1>
			<button class="imageSelectorButton" type="button" onclick="imageSelectorHandler.show(this)">Selecteer Foto</button>
			<p id="selectedJSImageName"></p>
			<img id="selectedJSImage" src="" />
		</div>
	</div>
</div>

<script type="text/javascript" src="{!! asset('js/imageSelector.js') !!}"></script>

<script>
	imageSelectorHandler.addCallback('onAcceptImage', function(args){
		document.getElementById("selectedJSImageName").innerHTML = args.filename;
		document.getElementById("selectedJSImage").setAttribute('src', 'imgs/' + args.folder + args.filename);
	});

	imageSelectorHandler.addCallback('onClearImage', function(args){
		document.getElementById("selectedJSImageName").innerHTML = ""
		document.getElementById("selectedJSImage").setAttribute('src', "");
	});

</script>

@endsection