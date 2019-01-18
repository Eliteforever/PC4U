@extends('layouts.header')

<meta id="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="<?php echo asset('css/imageSelector.css')?>" type="text/css">

@section('content')
    
<div id="container" class="categoryPanel">
	<input id="imageName" name="imageName" class="inputProduct" value="{{ $productInfo['image']['filename'] }}" type="hidden"/>
	<input id="imageFolder" name="imageFolder" class="inputProduct" value="{{ $productInfo['image']['folder'] }}" type="hidden"/>
	<div class="row">
		<div class="col s8 mainCategoryAdminPanel selectedcategoryPanel">
			  <div class="row">
				<div class="col s6">
					<p class="header-text headerNoMargin">
						Product
					</p>
					
					<input id="inputProductID" value="{{ $productInfo['id'] }}" name="id" type="hidden">
					<input id="inputCategoryID" value="{{ $productInfo['category']['id'] }}" name="id" type="hidden">
					
					<label class="inputFieldLabel" for="inputProductName">Verander naam</label>
					<input id="inputProductName" value="{{ $productInfo['name'] }}" name="name" class="inputProduct" type="text" />

					<label class="inputFieldLabel" for="inputProductPhoto">Verander foto</label>
					<p id="inputProductPhoto">{{ $productInfo['image']['filename'] }}</p>
					<button class="imageSelectorButton waves-effect waves-light btn" onclick="imageSelectorHandler.show(this)">Selecteer Foto</button>
					<p>
						<label class="inputFieldLabel" for="inputProductDescription">Verander omschrijving</label>
					</p>
					<textarea id="inputProductDescription" name="description" class="inputProduct" type="text" >{{ $productInfo['description'] }}</textarea>
					
					<label class="inputFieldLabel" for="inputProductPrice">Verander prijs</label>
					<input id="inputProductPrice" value="{{ number_format($productInfo['price'], 2) }}" name="price" class="inputProduct" type="number" step="0.01" />
					
					<label class="inputFieldLabel" for="inputProductBtw">Verander BTW</label>
					<input id="inputProductBtw" value="{{ number_format($productInfo['btw'], 2) }}" name="btw" class="inputProduct" type="number" step="0.01" />

					<div class="actionButtonsCategoryPanel">
						<a onclick="newProduct();" class="waves-effect waves-light btn">Nieuw</a>
						<a onclick="editProduct();" class="waves-effect waves-light btn">Wijzig</a>
						<a onclick="deleteProduct();" class="waves-effect waves-light btn">Verwijder</a>
					</div>
					
					<br />
				</div>
				<div class="col s6">
					<p class="header-text headerNoMargin">
					Categorie
					</p>
					<label class="inputFieldLabel" for="inputProductCategory">Verander Categorie</label>
					<select id="inputProductCategory" name="productCategoryID" class="browser-default inputProduct inputProperty">
						<option value=""></option>
					</select>
					<br />
					<p class="header-text headerNoMargin">
					Eigenschappen
					</p>

					<label class="inputFieldLabel" for="inputPropertySelect">Selecteer Eigenschap</label>
					<select id="inputPropertySelect" name="propertyID" class="browser-default inputProperty" disabled>	
					</select>
					
					<label class="inputFieldLabel" for="inputPropertyValue">Waarde</label>
					<input id="inputPropertyValue" name="value" type="text" class="inputProperty" disabled/>
					
					<div class="actionButtonsCategoryPanel">
					  <a id="editPropertyBut" onclick="editProperty();" class="waves-effect waves-light btn disabled">Wijzig</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col s4 mainCategoryAdminPanel allCategoryView">
			<p class="header-text headerNoMargin">
				Alle producten
			</p>
			<label class="inputFieldLabel" for="inputSearchProduct">Zoek product</label>
			<input id="inputSearchProduct" type="text" />
			<label class="inputFieldLabel" for="inputProductCategorySearch">Toon producten van categorie</label>
			<select id="inputProductCategorySearch" class="browser-default">
				<option value="-1" selected>Alle</option>
			</select>

			<div id="allProductsList" class="collection">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="{!! asset('js/imageSelector.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/admin/products.js') !!}"></script>
@endsection
@section('external-scripts')
    <script>
     $(document).ready(function() {
         $('select').material_select();
     });
    </script>
    <script src="{{ asset('js/matchHeight.js') }}"></script>
@endsection

