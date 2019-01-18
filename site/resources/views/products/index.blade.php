@extends('layouts.header')

@if ($category != null)
<meta id="requestCategory" content="{{ $category }}">
@endif


@section('content')
<div class="productsContainter">
	<div id="container-products" class="fullWidth">
		<div id="productMain">
			<div class="row">
				<div class="col s12 l3 sortDataContainer">

					<!-- Include this to use productSelector.js -->
					<div id="productsMenu" class="card-panel productsMenuCard">
						<h2>Menu</h2>
						<div id="menuContent">

							<ul class="menuSelector tabs">
							    <li class="tab col s6"><a class="active" href="#filterMenu">Filteren</a></li>
							    <li class="tab col s6"><a href="#sortMenu">Sorteren</a></li>
							</ul>

						  	<div id="filterMenu" class="col s12 card-panel removePadding removeMargin">
								<ul class="collection removeMargin">
							        <li>
							        	<ul class="collapsible removePadding removeLeftRightBorder">
										    <li>
										     	<div class="collapsible-header"><i class="material-icons">arrow_drop_down</i>Toegevoegd</div>
										     	<div class="collapsible-body removePadding">
											      	<ul id="usedFilters" class="collection removePadding">			       
												    </ul>
										      	</div>
										    </li>
										</ul>
									</li>
									<li>
							        	<ul id="baseListFilter" class="collection">
										   
										</ul>
									</li>

							        <li class="removePadding">
							        	<ul class="collapsible removePadding removeLeftRightBorder">
										    <li>
										     	<div class="collapsible-header"><i class="material-icons">arrow_drop_down</i>Categories</div>
										     	<div class="collapsible-body removePadding">
											      	<ul class="collection removePadding">			       
												        <li class="collection-item removePadding">
													        <ul id="categoryListFilter" class="collapsible removeMargin removeLeftRightBorder">							
															</ul>
												        </li>
												    </ul>
										      	</div>
										    </li>
										</ul>
									</li>
							    </ul>
							</div>

							<div id="sortMenu" class="col s12 card-panel removePadding removeMargin">
								<ul class="collection removeMargin">
									<li id="usedSorters" class="collection-item">
										Momenteel niks gesorteerd
									</li>	
									<li>
							        	<ul id="baseListSorter" class="collection">
										    
										</ul>
									</li>				        
							        <li class="removePadding">
							        	<ul class="collapsible removePadding removeLeftRightBorder">
										    <li>
										     	<div class="collapsible-header"><i class="material-icons">arrow_drop_down</i>Categories</div>
										     	<div class="collapsible-body removePadding">
											      	<ul class="collection removePadding">			       
												        <li class="collection-item removePadding">
													        <ul id="categoryListSorter" class="collapsible removeMargin removeLeftRightBorder">							
															</ul>
												        </li>
												    </ul>
										      	</div>
										    </li>
										</ul>
									</li>
							    </ul>
							</div>
					    </div>
					</div>
					<!-- End include -->

				</div>
				<div class="col s12 l9 productList">
					<div id="productListTarget" class="row">
					
					</div>
				</div>
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

			 <script src="{{ asset('js/handyfunctions.js') }}" ></script>
			 <script src="{{ asset('js/distributer.js') }}" ></script>
			 <script src="{{ asset('js/productSelector.js') }}"></script>
			 <script src="{{ asset('js/products.js') }}" ></script>	
@endsection
