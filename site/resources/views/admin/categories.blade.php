@extends('layouts.header')

<meta id="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="<?php echo asset('css/imageSelector.css')?>" type="text/css">

@section('content')

<div id="container" class="categoryPanel">
    <div class="row">
        <div class="col s8 mainCategoryAdminPanel selectedcategoryPanel">
	          <div class="row">
                <div class="col s6">
                    <p class="header-text headerNoMargin">
                        Categorie
                    </p>
					<input id="imageName" name="imageName" class="inputCategory" type="hidden"/>
					<input id="imageFolder" name="imageFolder" class="inputCategory" type="hidden"/>
					<input id="categoryIDInput" name="categoryID" class="inputProperty" type="hidden"/>
					
	                  <label class="inputFieldLabel" for="inputCategoryName">Verander naam</label>
                    <input id="inputCategoryName" name="name" class="inputCategory" type="text" />


	                  <label class="inputFieldLabel" for="inputCategoryPhoto">Verander foto</label>
	                  <p id="inputCategoryPhoto"></p>
	                  <button class="imageSelectorButton waves-effect waves-light btn" onclick="imageSelectorHandler.show(this)">Selecteer Foto</button>

	                  <p>
                        <label class="inputFieldLabel" for="inputCategoryDescription">Verander omschrijving</label>
                    </p>
	                  <textarea id="inputCategoryDescription" name="description" class="inputCategory" type="text"></textarea>
                    <div class="actionButtonsCategoryPanel">
                        <a onclick="newCategory();" class="waves-effect waves-light btn">Nieuw</a>
	                      <a onclick="editCategory();" class="waves-effect waves-light btn">Wijzig</a>
	                      <a onclick="deleteCategory();" class="waves-effect waves-light btn">Verwijder</a>
                    </div>
                </div>
                <div class="col s6">
                    <p class="header-text headerNoMargin">
                        Eigenschappen
                    </p>

						<label class="inputFieldLabel" for="inputPropertySelect">Selecteer Eigenschap</label>
	                  <select id="inputPropertySelect" class="browser-default">	
	                  </select>

	                  

	                  <label class="inputFieldLabel" for="inputPropertyName">Naam</label>
	                  <input id="inputPropertyName" name="name" type="text" class="inputProperty" />

					<label class="inputFieldLabel" for="inputPropertyDatatype">Type waarde</label>
	                  <select id="inputPropertyDatatype" class="browser-default inputProperty" name="datatype">	
						<option value="2" selected>Getal</option>
						<option value="1">Text</option>
	                  </select>
	                  
                    <div class="row">
                        <div class="col s6">
                            <label class="inputFieldLabel" for="inputPropertyPrefix">Prefix</label>
	                          <input id="inputPropertyPrefix" name="prefix" type="text" class="inputProperty" />
                        </div>
                        <div class="col s6">
                            <label class="inputFieldLabel" for="inputPropertyPostfix">Postfix</label>
                            <input id="inputPropertyPostfix" name="postfix" type="text" class="inputProperty" />
                        </div>
                    </div>
	                  <label class="inputFieldLabel" for="inputPropertyDescription">Descriptie</label>
	                  <textarea id="inputPropertyDescription" name="description" type="text"  class="inputProperty"></textarea>
                    <div class="actionButtonsCategoryPanel">
                        <a onclick="newProperty();" class="waves-effect waves-light btn">Nieuw</a>
	                      <a onclick="editProperty();" class="waves-effect waves-light btn">Wijzig</a>
	                      <a onclick="deleteProperty();" class="waves-effect waves-light btn">Verwijder</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s4 mainCategoryAdminPanel allCategoryView">
            <p class="header-text headerNoMargin">
                Alle categorien
            </p>
	          <label class="inputFieldLabel" for="inputSearchCategory">Zoek categorie</label>
	          <input id="inputSearchCategory" type="text" />

	          <div id="allCategoriesList" class="collection">
	          </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{!! asset('js/imageSelector.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/admin/categories.js') !!}"></script>

@endsection
@section('external-scripts')
    <script src="{{ asset('js/matchHeight.js') }}"></script>
@endsection
