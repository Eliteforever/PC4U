$(function() {
    updateTotalInCart();
});

let addToCart = (id, amount) => {
    if(findInCart(id, amount, 1) == 0){
        if(docCookies.getItem("cartItems") == null ) { 
            var items = [];
            var product = createProduct(id, amount);

            items.push(product);
            items = JSON.stringify(items);

            Cookies.set('cartItems', items, { expires: 365, path: '/' });
        }else { 
            var items = JSON.parse(docCookies.getItem("cartItems"));
            var product = createProduct(id, amount);

            items.push(product);
            items = JSON.stringify(items);

            Cookies.set('cartItems', items, { expires: 365, path: '/' });
        }
    }else{
    }
    updateTotalInCart();
}

let createProduct = (id, amount) => {
    var product = [];
    product.push(id);
    product.push(amount);
    return product;
}

let removeCookie = (cookieName) => { 
    if(docCookies.removeItem(cookieName)) { 
        console.log("Cookie removed"); 
    }else{ 
        console.log("Cookie wasn't removed"); 
    } 
}

let findInCart = (id, amount, method) => {
    if(amount > 0) {
        var y = docCookies.getItem("cartItems");
        var y_parsed = JSON.parse(y);
        if(y_parsed != null) {
		        for(let i = 0; i < y_parsed.length; i++) {
			          if(y_parsed[i][0] === id) {
				            if(method === 1){

					              y_parsed[i][1] += parseInt(amount);
				            }else{
					              y_parsed[i][1] = parseInt(amount);
				            }
				            y = JSON.stringify(y_parsed);
				            Cookies.set('cartItems', y, { expires: 365, path: '/' });
				            return 1;
			          }else{
				            return 0;
			          }
		        }
        }
        return 0;
    }
}

let removeFromCart = (index, id) => {
    var alert = confirm("Weet u zeker dat u dit product uit uw winkelwagen wilt verwijderen?");

    if(alert == true){
        var y = docCookies.getItem("cartItems");
        var y_parsed = JSON.parse(y);
        y_parsed.forEach(function(row, index){
            console.log("index: " + index + " row id: " + row[0] + " param id " + id);
            if(row[0] === id){
                y_parsed.splice(index, 1);
            }
        });
        y = JSON.stringify(y_parsed);
        Cookies.set('cartItems', y, { expires: 365, path: '/' });
        document.getElementById("tableCart").deleteRow(index + 1);
        if($("#tableCart tr").length < 5){
            document.getElementById("cartBody").innerHTML = "<td colspan='5'>Geen producten in winkelwagen</td>";
        }
        var x = countAllInTable();
        $('#priceExBTW').fadeOut("fast", function() {
            $(this).text("€ " + x.toFixed(2));
            $(this).fadeIn("fast", function() {
                x = countAllWithTax();
                $('#priceInclBTW').fadeOut("fast", function() {
                    $(this).text("€ " + x.toFixed(2));
                    $(this).fadeIn("fast", function() {});
                });
            });
        });
    }else{

    }
    updateTotalInCart();
}


//Check if amount gets changed in the input field
$('input#amountInput').on('input', function() {
    var amount = $(this).val();
    if(amount > 0) {
        var rowindex = $(this).closest('tr').index() + 1;
        var btwPercentage = $('#cartItemRow:nth-child( ' + rowindex + ')').attr("data-btw");
        var productID = $('#cartItemRow:nth-child( ' + rowindex + ')').attr("data-prodId");
        var productID = parseInt(productID);
        findInCart(productID, amount, 2);
        btwPercentage = Math.round(btwPercentage);

        var prodPrice = $('#cartItemRow:nth-child( ' + rowindex + ')').children('.productPriceHidden').val();
        prodPrice = prodPrice.replace(/\s/g, '').replace('€', '').replace('&euro;', '');
        //prodPrice = prodPrice / ("1" +  btwPercentage) * 100;
		
		console.log("ANIKWOFGOINOGWNOIGINUONIGAW: " + amount);
		console.log("BAKIWOFGOINOGWNOIGINUO test: " + prodPrice);
        var newAmount =  amount * prodPrice;

        $('#cartItemRow:nth-child( ' + rowindex + ')').children('td.productPriceAll').fadeOut( "fast", function() {
            $(this).text("€ " + newAmount.toFixed(2));
            $(this).fadeIn( "fast", function() {
                var x = countAllInTable();
                $('#priceExBTW').fadeOut("fast", function() {
                    $(this).text("€ " + x.toFixed(2));
                    $(this).fadeIn("fast", function() {
                        x = countAllWithTax();
                        $('#priceInclBTW').fadeOut("fast", function() {
                            $(this).text("€ " + x.toFixed(2));
                            $(this).fadeIn("fast", function() {});
                        });
                    });
                });
            });
        });
    }else{
        $(this).val('1');
    }
});

let getCart = () => {
    return docCookies.getItem("cartItems");
}
var xl
let countAllInTable = () => {
    var all = 0;
    $('#cartBody > #cartItemRow').each(function() {
		let productPrice = $(this).children('.productPriceHidden').val();
		let productAmount = $(this).find('.amountInput').val();
		
		console.log("PROP: "+productPrice);
		console.log("AMOUNT: "+productAmount);
		
		productPrice = productPrice.replace('€', '').replace('&euro;', '');
		productPrice = productPrice.replace(',');
		productPrice = parseInt(productPrice);
		
		productAmount = parseInt(productAmount);
		console.log("price: "+productPrice);
		console.log("all first: "+all);
		all += (productPrice * productAmount);
		console.log("all sec: "+all);
        //all = (all + (+($(this).children('td.productPriceAll').text().replace(/\s/g, '').replace('€', '').replace('&euro;', '').replace(/,/g, ""))));
    });
    return all;
}

let countAllWithTax = () => {
    var all = 0;
    $('#cartBody > #cartItemRow').each(function() {
		console.log(all);
        all = (all + (+($(this).children('td.productPrice').text().replace(/\s/g, '').replace('€', '').replace('&euro;', ''))) * $(this).find('#amountInput').val());
		console.log(all);
    });
    return all;
}

let updateTotalex =(newTotal) => {
    countUp($('#priceExBTW'), $("#priceExBTW").text(), newTotal);
    /* updateTotalWithTax(10);*/
}

let updateTotalWithTax =(newTotal) => {
    countUp($('#priceInclBTW'), $("#priceInclBTW").text(), newTotal);
}

let updateTotalInCart = () => {
    if(Cookies.getJSON('cartItems') !== undefined) {
		$(".itemsInCart").text("(" + Cookies.getJSON('cartItems').length + ")");
	}
}
