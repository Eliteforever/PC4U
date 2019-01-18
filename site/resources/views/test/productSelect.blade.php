@extends('layouts.header')

@section('content')

<div class="row">
	<div class="col l4">

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
</div>

@endsection
@section('external-scripts')
			 <script src="{{ asset('js/handyfunctions.js') }}" ></script>
			 <script src="{{ asset('js/productSelector.js') }}"></script>

			 <script>
			 	function showProducts(categories, products, other){
			 		console.log(products); //

			 		// ... code
			 	}

			 	$('document').ready(function(){				
					let productUpdater = new ProductUpdater();
						productUpdater.bindOnProductsAndCategoriesReceived(showProducts);

					productUpdater.updateProductList();
				});
			 </script>
@endsection
