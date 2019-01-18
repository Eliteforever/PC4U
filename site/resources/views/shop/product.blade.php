@extends('layouts.header')

@section('content')
@foreach($productInfo as $productInfo)
    <?php
        if(isset($productInfo['priceAfterDiscount'])){
            $withBTw = $productInfo['price'] * ($productInfo['btw'] / 100 + 1);
            $afterDiscount = (100 - (100 / $withBTw * $productInfo['priceAfterDiscount']));
        }
    ?>
<div id="container" data-productID="{{ $productInfo['id'] }}">
    <div class="row">
        <div class="col s12 m4">
            <p class="header-text" style="margin: 0px;">
                &nbsp;
            </p>
            <div class="productImageContainer">
                <div class="tag">
                    <i class="material-icons productImageHover">search</i>
                </div>
                <img class="productPictureBig" alt="Picture of {{ $productInfo['name'] }}" src="/imgs{{ $productInfo['image']['folder'] }}{{ $productInfo['image']['filename'] }}" width="350" height="350" />
            </div>
        </div>
        <div class="col s12 m8">
            <p class="header-text productName">
                {{ $productInfo['name'] }}
            </p>
            <span class="productDescriptionX">
                {{ $productInfo['description'] }}
            </span>
            <hr class="produtHR abovePrice" />
            <div class="row">
                <div class="col s4 ProductPriceCol">
                    @if(isset($productInfo['priceAfterDiscount']))
                        <p class="header-text productPrice oldPrice oldPriceP">
                            € {{ number_format($productInfo['price'] * ($productInfo['btw'] / 100 + 1), 2) }}
                        </p>
                        <p class="header-text productPrice newProductPrice">
                            € {{ number_format($productInfo['priceAfterDiscount'], 2) }}
                        </p>
                    @else
                        <p class="header-text productPrice">
                            € {{ number_format($productInfo['price'] * ($productInfo['btw'] / 100 + 1), 2) }}
                        </p>
                    @endif
                    <p class="productPriceSub">
                        Incl {{ $productInfo['btw'] + 0 }}% BTW Excl verzendkosten
                    </p>
                </div>
                <div class="col s4">
                    <input name="" type="number" value="" class="ProductOrderAmount" id="productAmountID" placeholder="Aantal" />
                </div>
                <div class="col s4">
                    <button onclick="addToCartButton('productAmountID', {{ $productInfo['id'] }})" class="order-button productOrderButton">
                        Add to  cart
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr class="productHR" />
    <div class="row">
        <div class="col s12 m6">
            <p class="header-text headerNoMargin">
                Eigenschappen
            </p>
            <div class="table-limiter">
                <table class="striped">
                    @foreach($productInfo['properties'] as $property)
                        <tr>
                            <td>{{ $property['name'] }}</td>
                            <td>
                                {{ $property['prefix']}}{{$property['value']}}{{$property['postfix'] }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col s12 m6">
            <p class="header-text headerNoMargin">
                Bekijk ook
            </p>
            <div class="row">
                @forelse($productInfo['recommended'] as $recommended)
                    <div class="col s3 otherProducts">
                        <a href="{{ $recommended['id'] }}">
                            <img alt="" class="otherProductsImg"  src="http://localhost:8000/getImage/{{ $recommended['imageID'] }}"/>
                            <p>
                                {{ $recommended['name'] }}
                            </p>
                        </a>
                    </div>
                @empty
                    <div class="col s12">
                        <span class="header-text no-products-text">
                            Geen aanbevolen producten
                        </span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content productImageModal">
        <img class="modalProductImage" alt="" src=""/>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
    </div>
</div>
@endforeach
@endsection
@section('external-scripts')
    <script src="/js/productPage.js"></script>
@endsection
