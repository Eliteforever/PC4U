/* ProductsCard
	
*/
class ProductsCard{
	constructor(product){	
		this.$card = $('<div></div>', {
			class: 'card horizontal productCard'
		});

		let $cardImageContainer = $('<div></div>', {
			class: 'productCardImageContainer'
		});
		this.$card.append($cardImageContainer);

		this.$image = $('<img></img>', {
			class: 'productCardImage'
		}).attr('src', urlPrepend + "imgs/" + product["image"]["folder"] + product["image"]["filename"]);
		$cardImageContainer.append(this.$image);

		let $cardStacked = $('<div></div>', {
			class: 'card-stacked'
		})
		this.$card.append($cardStacked);

		let $cardContent = $('<div></div>', {
			class: 'card-content productCardContent'
		});
		$cardStacked.append($cardContent);

		let $cardNameDescContainer = $('<div></div>', {
			class: 'cardNameDescContainer'
		});
		$cardContent.append($cardNameDescContainer);

		this.$name = $('<h3></h3>', {
			class: 'itemCardHeaderText',
			text: product['name']
		});
		$cardNameDescContainer.append(this.$name);

		this.$description = $('<p></p>', {
			class: 'productCardDescription',
			text: product['description']
		});
		$cardNameDescContainer.append(this.$description);

		let $priceDiv = $('<div></div>', {
			class: 'productCardPriceDiv'
		})
		$cardContent.append($priceDiv);

		if (product['priceAfterDiscount'] > 0){
			let priceWithBtw = (product["price"] * (product['btw'] / 100 + 1)).toFixed(2);
			let priceAfterDiscount = (100 - (100 / priceWithBtw * product['priceAfterDiscount'])).toFixed(0);

			this.$price = $('<p></p>', {
				class: 'price oldPrice',
				text: '€' + priceWithBtw
			});
			$priceDiv.append(this.$price);

			this.$priceAfterDiscount = $('<p></p>', {
				class: 'price productCardPriceAfterDiscount',
				text: '€' + product["priceAfterDiscount"].toFixed(2)
			});
			$priceDiv.append(this.$priceAfterDiscount);

			this.$discountPercent = $('<p></p>', {
				class: 'discountPercent',
				text: '-' + priceAfterDiscount + '%'
			})
			$cardImageContainer.append(this.$discountPercent);

		} else {
			this.$price = $('<p></p>', {
				class: 'price',
				text: '€' + (product["price"] * (product['btw'] / 100 + 1)).toFixed(2)
			});
			$priceDiv.append(this.$price);
		}
	}

	getElement(){
		return this.$card;
	}
}

function createColumn(){
	let column = $('<div></div>', {
		class: 'col s12 l6 cardsColumn'
	});1

	return column;
}

function showProducts(categories, products, other){
	distributer.clearColumns();
	let productCards = [];
	console.log(products);
	for (let i = 0; i < products.length; i++){
		let productCard = new ProductsCard(products[i]);
			productCard.$card.click(function(){
				window.location.href = "/product/" + products[i]['id'];
			});

			productCards.push(productCard.getElement());
	}

	distributer.distribute(productCards);
}

let distributer;

$('document').ready(function(){
	let url = window.location.href;
	let splitUrl = url.split("/");
	let category = "";
	console.log(splitUrl);
	urlPrepend = "";

	for (let i = 3; i < splitUrl.length; i++){
		urlPrepend += "../";
	}

	let target = $("#productListTarget");

	distributer = new Distributer();
	distributer.addColumn(createColumn(), target);
	distributer.addColumn(createColumn(), target);

	if ($('#requestCategory') != "undefined"){
		category = $('#requestCategory').data('category');
	}

	let productUpdater = new ProductUpdater();
		productUpdater.bindOnProductsAndCategoriesReceived(showProducts);

	productUpdater.updateProductList();

	console.log(category);
});




