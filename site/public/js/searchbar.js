$('.searchInputHeader').each(function(){

	var elem = $(this);

   	// Save current value of element
	elem.data('oldVal', elem.val());

   	// Look for changes in the value
   	elem.bind("propertychange change click keyup input paste", function(event){
   		let value = elem.val();

    	// If value has changed...
      	if (elem.data('oldVal') != value) {
       		// Updated stored value
       		elem.data('oldVal', value);

		   	if (value.length > 1){
				let postHandler = new PostControl(null, null, function(productsAndCategories){

					let products = productsAndCategories.products;
					let categories = productsAndCategories.categories;

					if (products.length === 0 && categories.length === 0){
						$('.searchbarResultContainer').each(function(){
							$(this).removeClass("searchbarResultOpen");
						});
					} else {
						$('.searchbarResultContainer').each(function(){
							$(this).addClass("searchbarResultOpen");
						});

						$('.searchbarProductList').each(function(){
							$(this).empty();
						});

						$('.searchbarProductList').each(function(){
							let productHeaderTextAppend = "";

							if (products.length === 0){
								productHeaderTextAppend = "geen.";
							}

							$(this).append($('<div></div>', {
								class: 'collection-header',
								})
							.append($('<p></p>', {
								text: 'Gevonden producten: ' + productHeaderTextAppend
							})));

							for (let i = 0; i < products.length; i++){
								$contentDiv = $('<div></div>', {
									class: 'searchProductContent'
								}).append($('<h3></h3>', {
									class: 'searchProductName',
									text: products[i]['name']
									})
								);

								$a = $('<a></a>', {
									class: 'collection-item searchBarProductListItem',
									href: '/product/' + products[i]['id'] 
								}).append($('<div></div>', {
									class: 'searchBarProductImage'
								}).append($('<img></img>', {
									class: 'categoryImage'
								}).attr('src', '/imgs' + products[i]['image']['folder'] + products[i]['image']['filename'])
								)).append($contentDiv);

								$priceDiv = $('<div></div>', {
									class: 'searchPriceDiv'
								});

								$(this).append($a);
								$contentDiv.append($priceDiv);

								console.log(products[i]);

								if (products[i]['priceAfterDiscount'] > 0){
									$priceDiv.append($('<h3></h3>', {
										class: 'searchProductPrice',
										text: "€" + products[i]['priceAfterDiscount'].toFixed(2)
										})
									);

									$priceDiv.append($('<h3></h3>', {
										class: 'searchProductPrice searchProductOldPrice',
										text: "€" + (products[i]['price'] * (products[i]['btw'] / 100 + 1)).toFixed(2)
										})
									);								
								} else {
									$priceDiv.append($('<h3></h3>', {
										class: 'searchProductPrice',
										text: "€" + (products[i]['price'] * (products[i]['btw'] / 100 + 1)).toFixed(2)
										})
									);
								}
							}
						});

						$('.searchbarCategoryList').each(function(){
							$(this).empty();
						});

						$('.searchbarCategoryList').each(function(){
							let categoryHeaderTextAppend = "";

							if (categories.length === 0){
								categoryHeaderTextAppend = "geen.";
							}

							$(this).append($('<div></div>', {
								class: 'collection-header',						
							})
							.append($('<p></p>', {
								text: 'Gevonden categorieen: ' + categoryHeaderTextAppend
							})));

							for (let i = 0; i < categories.length; i++){
								$(this).append($('<a></a>', {
									class: 'collection-item',
									href: '/categories/' + categories[i]['name'],
									text: categories[i]['name']
									})
								);
							}
						});
					}
				});

				postHandler.getAll("/searchProductsAndCategories", {'inputValue': value});

	   		} else {
	   			$('.searchbarResultContainer').each(function(){
					$(this).removeClass("searchbarResultOpen");
				});
	   		}
     	}else if(event.keyCode === 27) {
            $('.searchbarResultContainer').each(function(){
                $(this).removeClass("searchbarResultOpen");
            });
		}
   	});

});
