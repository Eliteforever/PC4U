@extends('layouts.header')

@section('content')
<div id="container-products">
	<div id="sorteren-container">
		<div id="sorteren-content" class="blue-grey lighten-4">
			<h2>Sorteren</h2>
			<hr>
			<h5>Prijs</h5>
			<div class="inputfield">
			 <div id="test-slider" min="20" class="slider-style"></div>
			</div>
			<h5>Merken</h5>
			 <div class="inputfield">
				<input type="checkbox" id="test1">
				<label for="test1">test1</label>
				<input type="checkbox" id="test2">
				<label for="test2">test2</label>
				<input type="checkbox" id="test3">
				<label for="test3">test3</label>
				<input type="checkbox" id="test4">
				<label for="test4">test4</label>
			 </div>
		</div>
	</div>
	
	<div id="shop-container">
		<div id="filter-content">
			<h1>Filteren</h1>
			
			<div id="filtercontent-bar">
			
				<label class="order-select-label">Orden op</label>
				<select class="browser-default order-select">
					<option value="1" selected>Item1</option>
					<option value="2">Item2</option>
					<option value="3">Item3</option>
				</select>
				
				<input type="checkbox" class="filled-in" id="asc-desc" checked="checked" />
				<label for="asc-desc">Aflopend</label>
				
				<!--<div id="right-orden">-->
					<div class="input-field-eigenschap">
						<label class="eigenschap-select-label">Eigenschap 1</label>
						<select class="browser-default eigenschap-select">
							<option value="1" selected>None</option>
							<option value="2">Item2</option>
							<option value="3">Item3</option>
						</select>
					</div>
					<div class="input-field-eigenschap">
						<label class="eigenschap-select-label">Eigenschap 2</label>
						<select class="browser-default eigenschap-select">
							<option value="1" selected>None</option>
							<option value="2">Item2</option>
							<option value="3">Item3</option>
						</select>
					</div>
				<!--</div>-->
			</div>
			<hr>
		</div>
		<div id="shop-content">
			<div class="item-card blue-grey lighten-4">
				<img src="imgs/testimage.jpg"></img>
				<h1>Test Item</h1>
				<a class="item-card-producturl" href="#">Product pagina</a>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ornare quis velit quis...
				</p>
				<a href="#" class="item-card-price">&euro;20,-</a>
				<a href="#"><svg fill="#000000" class="item-card-cart-icon" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 0h24v24H0zm18.31 6l-2.76 5z" fill="none"/>
					<path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-9.83-3.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.13 0-.25-.11-.25-.25z"/>
				</svg></a>
			</div>
			<div class="item-card blue-grey lighten-4">
				<img src="imgs/testimage.jpg"></img>
				<h1>Test Item</h1>
				<a class="item-card-producturl" href="#">Product pagina</a>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ornare quis velit quis...
				</p>
				<a href="#" class="item-card-price">&euro;20,-</a>
				<a href="#"><svg fill="#000000" class="item-card-cart-icon" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 0h24v24H0zm18.31 6l-2.76 5z" fill="none"/>
					<path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-9.83-3.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.13 0-.25-.11-.25-.25z"/>
				</svg></a>
			</div>
			<div class="item-card blue-grey lighten-4">
				<img src="imgs/testimage.jpg"></img>
				<h1>Test Item</h1>
				<a class="item-card-producturl" href="#">Product pagina</a>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ornare quis velit quis...
				</p>
				<a href="#" class="item-card-price">&euro;20,-</a>
				<a href="#"><svg fill="#000000" class="item-card-cart-icon" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 0h24v24H0zm18.31 6l-2.76 5z" fill="none"/>
					<path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-9.83-3.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.13 0-.25-.11-.25-.25z"/>
				</svg></a>
			</div>
			<div class="item-card blue-grey lighten-4">
				<img src="imgs/testimage.jpg"></img>
				<h1>Test Item</h1>
				<a class="item-card-producturl" href="#">Product pagina</a>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ornare quis velit quis...
				</p>
				<a href="#" class="item-card-price">&euro;20,-</a>
				<a href="#"><svg fill="#000000" class="item-card-cart-icon" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 0h24v24H0zm18.31 6l-2.76 5z" fill="none"/>
					<path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-9.83-3.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.13 0-.25-.11-.25-.25z"/>
				</svg></a>
			</div>
			<div class="item-card blue-grey lighten-4">
				<img src="imgs/testimage.jpg"></img>
				<h1>Test Item</h1>
				<a class="item-card-producturl" href="#">Product pagina</a>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ornare quis velit quis...
				</p>
				<a href="#" class="item-card-price">&euro;20,-</a>
				<a href="#"><svg fill="#000000" class="item-card-cart-icon" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 0h24v24H0zm18.31 6l-2.76 5z" fill="none"/>
					<path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-9.83-3.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.13 0-.25-.11-.25-.25z"/>
				</svg></a>
			</div>
		</div>
	</div>
</div>
@endsection
@section('external-scripts')
	
			 <script>
			   var slider = document.getElementById('test-slider');
			  noUiSlider.create(slider, {
			   start: [0, 100],
			   connect: true,
			   step: 1,
			   tooltips: true,
			   orientation: 'horizontal', // 'horizontal' or 'vertical'
			   range: {
				 'min': 0,
				 'max': 100
			   },
			   format: wNumb({
				 decimals: 0
			   }),
				pips: { // Show a scale with the slider
					mode: 'count',
					values: 5,
					stepped: false,
					density: 5,
					format: wNumb({
						decimals: 2,
						prefix: '$'
					})
				}
			  });
			 </script>
@endsection
