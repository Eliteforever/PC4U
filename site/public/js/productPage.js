let addToCartButton = (inputID, productID) => {
    var inputAmount = $("#" + inputID).val();
    if(inputAmount > null){
        addToCart(productID, parseInt(inputAmount), 2);
        createToast("Product is toegevoegd aan winkelwagen", "/cart", "202020");
    }else{
        alert('Voer alstublieft een aantal in');
    }
}

$( ".productImageContainer" ).mouseover(function() {
    $(".tag").css('display', 'block');
});

$( ".productImageContainer" ).mouseout(function() {
    $(".tag").css('display', 'none');
});

$(".tag").click(function() {
    $('.modal').modal();
    $(".modalProductImage").attr('src', $(".productPictureBig").attr('src'));
    $('#modal1').modal('open');
});

$(function() {
    var productId = parseInt($("#container").attr('data-productID'));
    var found = false;
    if(document.cookie.indexOf('recentItems=') == -1) {
        var recent = [];
        recent.push(productId);
        recent = JSON.stringify(recent);
        Cookies.set('recentItems', recent);
    } else {
        var recent = JSON.parse(Cookies.get('recentItems'));
        for(let i = 0; i < recent.length; i++) {
            if(recent[i] == productId) {
                found = true;
            }
        }
        if(!found) {
            if(recent.length === 20) {
                recent.shift();
            }
            recent.push(productId);
            recent = JSON.stringify(recent);
            Cookies.set('recentItems', recent);
        }
    }
});
