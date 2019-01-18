@extends('layouts.header')

<meta id="csrf-token" content="{{ csrf_token() }}">

@section('content')


<div id="container" class="categoryPanel">
	<div class="row">
		<div class="col s6 mainCategoryAdminPanel selectedcategoryPanel">
			<div class="row">
				<div class="">

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
		</div>
		<div class="col s6 mainCategoryAdminPanel allCategoryView">
			<p class="header-text headerNoMargin">
				Producten
			</p>

			<div class="textCheckbox">
				<label class="inputFieldLabel" for="inputSaleVal">Verander korting</label>
				<input type="number" value="0.00" step="0.01" name="saleVal" id="inputSaleVal" class="inputSale" />

				<input type="checkbox" id="inputPercentage" />
				<label class="inputFieldLabel" for="inputPercentage">Korting in procenten</label>
			</div>

			<div class="twoDates">
				<div class="left">
					<label class="inputFieldLabel" for="inputStartDate">Verander start datum</label>
					<input type="text" id="inputStartDate" class="datepicker" />
				</div>
				<div class="left">
					<label class="inputFieldLabel" for="inputEndDate">Verander stop datum</label>
					<input type="text" id="inputEndDate" class="datepicker" />
				</div>
			</div>
			<hr id="salesHr" />
			<div class="section">
				<a href="javascript:void(0)" id="editSalesBtn" class="waves-effect waves-light btn salesbtn">Wijzig korting</a>
				<a href="javascript:void(0)" id="removeSalesBtn" class="waves-effect waves-light btn salesbtn">Verwijder korting</a>
			</div>
			<div class="twoDates">
				<div class="left">
					<a href="javascript:void(0)" id="selectProducts">Alles selecteren</a>
				</div>
				<div class="left">
					<a href="javascript:void(0)" id="deselectProducts">Alles deselecteren</a>
				</div>
			</div>
			<div id="productDisplay" class="collection"></div>
		</div>
	</div>
</div>



@endsection
@section('external-scripts')
			 <script src="{{ asset('js/handyfunctions.js') }}" ></script>
			 <script src="{{ asset('js/productSelector.js') }}"></script>
			 
			 <script>
				var prevSelected = undefined;
				var inputStartDatePicker = undefined;
				var inputEndDatePicker = undefined;
				
			 	function showProducts(categories, products, other){
			 		console.log('-----------');
					console.log(products); //
			 		console.log('-----------');
					
					$('#productDisplay').empty();
					for(let i = 0; i < products.length; i++) {
						let productCard = createProductCard(products[i]);
						productCard.onclick = function(e) { 
							let p = products[i];
							setSelected(this, e); 
							setProperties(p.TEMPsaleAmount, p.TEMPpercent, p.TEMPstartDate, p.TEMPendDate);
						}
						// Prevents from selecting text so shift clicking works
						productCard.onselectstart = function(e) {return false;}
						$('#productDisplay').append(productCard);
					}
			 	}
				
				function setAllActiveState(active) {
					let cards = $('#productDisplay a').get();
					for(let i = 0; i < cards.length; i++) {
						if(active) {
								cards[i].classList.add('active');
						} else {
								cards[i].classList.remove('active');
						}
					}
				}
				
				function setSelected(elm, e) {
					// Tests for shift key and handles that
					if(e.shiftKey && prevSelected !== undefined) {
						let start = false;
						let cards = $('#productDisplay a').get();
						for(let i = 0; i < cards.length; i++) {
							if(start || cards[i] == elm) {
								if(cards[i] != prevSelected) {
									cards[i].classList.toggle('active');
								}
							}
							if(cards[i] == prevSelected || cards[i] == elm) {
								start = !start;
							}
						}
					} else {
						elm.classList.toggle('active');
					}
					prevSelected = elm;
				}
				
				function setProperties(saleVal, percent, startDate, endDate) {
					
					$('#inputSaleVal').val(emptyIfNullOrUndefined(saleVal));
					if(percent == 1) {
						$('#inputPercentage').prop("checked", true);
					} else {
						$('#inputPercentage').prop("checked", false);
					}
					
					let TEMPstartDate = new Date(startDate);
					TEMPstartDate.setDate(TEMPstartDate.getDate() + 1);
					inputStartDatePicker.set('select', TEMPstartDate);
					
					let TEMPendDate = new Date(endDate);
					if(typeof endDate == 'undefined') {
						let endDate = new Date();
						//TEMPendDate.setDate(TEMPendDate.getDate() + 1);
					}
					TEMPendDate.setDate(TEMPendDate.getDate() + 1);
					inputEndDatePicker.set('select', TEMPendDate);
				}
				
				function createProductCard(product) {
					// Create card root element
					let card = document.createElement('a');
					card.href = 'javascript:void(0)';
					card.classList.add('collection-item');
					card.setAttribute('productID', product['id']);
					// Create card title
					let title = document.createElement('h5')
					title.innerText = product['name'];
					
					// Create price and priceDiscount
					let priceDiv = document.createElement('div');
					priceDiv.classList.add('productCardPriceDiv')
					
					let price = document.createElement('p');
					price.classList.add('price')
					
					if (product['priceAfterDiscount'] < product['price']){
						let priceWithBtw = (product["price"] * (product['btw'] / 100 + 1)).toFixed(2);
						let priceAfterDiscount = (100 - (100 / priceWithBtw * product['priceAfterDiscount'])).toFixed(0);
						
						// Add price discount to priceDiv
						let priceDiscount = document.createElement('p');
						priceDiv.appendChild(priceDiscount);

						// Add correct classes if discount
						price.classList.add('oldPrice')
						priceDiscount.classList.add('price', 'productCardPriceAfterDiscount')
						
						// Add the innerHTML
						price.innerHTML = '€' + priceWithBtw;
						priceDiscount.innerHTML += '€' + product["priceAfterDiscount"].toFixed(2);

					} else {
						price.innerHTML = '€' + (product["price"] * (product['btw'] / 100 + 1)).toFixed(2);
					}
					priceDiv.appendChild(price);
						
					// Append children
					card.appendChild(title);
					card.appendChild(priceDiv);
					
					return card;
				}
				
				function sendEditRequest(e) {
					let productIDs = [];
					
					// Get products where to change sale and add them to the productIDs array
					let cards = $('#productDisplay a').get();
					for(let i = 0; i < cards.length; i++) {
						if(cards[i].classList.contains('active')) {
							productIDs.push(cards[i].getAttribute('productID'));
						}
					}
					
					// Create hidden elements for productIDs and time
					createHiddenElement(productIDs, 'inputSale', 'productIDs', 'productIDs');
					createHiddenElement($('#inputPercentage').is(':checked'), 'inputSale', 'percent', 'percent');
					createHiddenElement(inputStartDatePicker.get('select').obj, 'inputSale', 'startDate', 'startDate');
					createHiddenElement(inputEndDatePicker.get('select').obj, 'inputSale', 'endDate', 'endDate');
					
					// Send request
					postControl = new PostControl(null, 'inputSale', null);
					postControl.post('/admin/createEditSales');
				}
				
				function removeRequest(e) {
					if (confirm('Weet u zeker dat u de aanbiedingen op de geselecteerde producten wilt verwijderen?')) {
						let productIDs = [];
						
						// Get products where to change sale and add them to the productIDs array
						let cards = $('#productDisplay a').get();
						for(let i = 0; i < cards.length; i++) {
							if(cards[i].classList.contains('active')) {
								productIDs.push(cards[i].getAttribute('productID'));
							}
						}
						
						// Create hidden elements for productIDs and time
						createHiddenElement(productIDs, 'inputRemoveSale', 'productIDs', 'productIDs');
						
						// Send request
						postControl = new PostControl(null, 'inputRemoveSale', null);
						postControl.post('/admin/removeSales');
					}
				}
				
			 	$('document').ready(function(){				
					let productUpdater = new ProductUpdater();
		
					productUpdater.bindOnProductsAndCategoriesReceived(showProducts);
					
					productUpdater.updateProductList();
					
					$('#selectProducts').click(function() {setAllActiveState(true)});
					$('#deselectProducts').click(function() {setAllActiveState(false)});
					$('#editSalesBtn').click(sendEditRequest);
					$('#removeSalesBtn').click(removeRequest);
				});
				
				
				$('.datepicker').pickadate({
					//format: 'm/dd/yyyy',
					selectMonths: true, // Creates a dropdown to control month
					selectYears: 10, // Creates a dropdown of 15 years to control year,
					today: 'Vandaag',
					clear: 'Verwijder',
					close: 'Opslaan',
					closeOnSelect: false, // Close upon selecting a date,
					
					onStart: function ()
					{
						var date = new Date();
						let elm = this.$node[0];
						if(elm.id == 'inputStartDate') {
							inputStartDatePicker = this;
							console.log(this);
							this.set('select', [date.getFullYear(), date.getMonth(), date.getDate()]);
						} else if(elm.id == 'inputEndDate') {
							date.setDate(date.getDate() + 1);
							inputEndDatePicker = this;
							this.set('select', [date.getFullYear(), date.getMonth(), date.getDate()]);
						}
					}
				});
			 </script>
@endsection
