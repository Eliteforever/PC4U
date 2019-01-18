@extends('layouts.header')
@section('content')
    <div id="container">
        <div class="banner">
            <ul id="lightSlider">
                @foreach($arr[0] as $banner)
                    <li class="valign-wrapper">
                        <img class="commercialImage" src="imgs/{{ $banner->folder}}{{ $banner->filename }}">
                    </li>
                @endforeach
                @foreach($arr[1] as $bann)
                    @foreach($bann as $banner)
                        <li> <img class="commercialImage" src="imgs/{{ $banner->folder}}{{$banner->filename }}"> </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
        <div class="aanbiedingen">
            <p class="header-text">Aanbiedingen</p>
            <div class="row">
                @if(!empty($arr[3]))
                    <ul class="saleProducts">
                    @forelse($arr[3] as $sales)
                        <li class="lslide">
                            <a href="product/{{ $sales->productID->id }}">
                                    <div class="cardsColumn col s12">
                                        <div class="card horizontal productCard">
                                            <div class="productCardImageContainer">
                                                <img class="productCardImage" src="getImage/{{ $sales->productID->imageID }}">
                                                <?php
                                                $priceWithBTW = ($sales->productID->price * ($sales->productID->btw / 100 + 1));
                                                $price = $sales->productID->price * (1 + ($sales->productID->btw / 100));
                                                $price *= 1 - (($sales->saleAmount) / 100);
                                                ?>
                                                <p class="discountPercent">-{{ (100 - (100 / $priceWithBTW * $price)) }}%</p>
                                            </div>
                                            <div class="card-stacked">
                                                <div class="card-content productCardContent">
                                                    <div class="cardNameDescContainer">
                                                        <h3 class="itemCardHeaderText">{{ $sales->productID->name }}</h3>
                                                        <p class="productCardDescription">{{ $sales->productID->description }}</p>
                                                    </div>
                                                    <div class="productCardPriceDiv">
                                                        <p class="price oldPrice">&euro; {{ number_format($sales->productID->price * ($sales->productID->btw / 100 + 1), 2) }}</p>
                                                        <p class="price productCardPriceAfterDiscount">&euro;
                                                            <?php
                                                            $price = $sales->productID->price * (1 + ($sales->productID->btw / 100));
                                                            $price *= 1 - (($sales->saleAmount) / 100);
                                                            ?>
                                                            {{ number_format($price, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </a>
                        </li>
                    @empty
                    @endforelse
                    </ul>
                @else
                    <p class="header-text center">Er zijn geen aanbiedingen</p>
                @endif
            </div>
        </div>
        <div class="recente">
            <p class="header-text">Recent bekeken</p>
            <div class="row">
                @if(!empty($arr[2]))
                    <ul class="recentsList">
                        @forelse($arr[2] as $recents)
                            @foreach($recents as $recent)
                                <li class="lslide">
                                    <a href="product/{{ $recent['id'] }}">
                                        <div class="cardsColumn">
                                            <div class="card horizontal productCard">
                                                <div class="productCardImageContainer">
                                                    <img class="productCardImage" src="getImage/{{ $recent['imageID'] }}">
                                                    @if($recent->priceAfterDiscount)
                                                        <?php
                                                        $priceWithBTW = ($recent->price * ($recent->btw / 100 + 1));
                                                        $price = $recent->price * (1 + ($recent->btw / 100));
                                                        $price *= 1 - (($recent->saleAmount) / 100);
                                                        ?>
                                                        <p class="discountPercent">-{{ (100 - (100 / $priceWithBTW * $price)) }}%</p>
                                                    @else
                                                    @endif
                                                </div>
                                                <div class="card-stacked">
                                                    <div class="card-content productCardContent">
                                                        <div class="cardNameDescContainer">
                                                            <h3 class="itemCardHeaderText">
                                                                {{ $recent['name'] }}
                                                            </h3>
                                                            <p class="productCardDescription">
                                                                {{ $recent['description'] }}
                                                            </p>
                                                        </div>
                                                        <div class="productCardPriceDiv">
                                                            @if($recent->priceAfterDiscount)
                                                                <p class="price oldPrice">&euro; {{ number_format($recent['price'] * ($recent['btw'] / 100 + 1), 2) }}</p>
                                                                <p class="price productCardPriceAfterDiscount">&euro; {{ number_format($recent->priceAfterDiscount, 2) }}</p>
                                                            @else
                                                                <p class="price productCardPriceAfterDiscount">&euro; {{ number_format($recent['price'] * ($recent['btw'] / 100 + 1), 2) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @empty
                        @endforelse
                </ul>
                @else
                    <p class="header-text center">Geen recent bekeken producten</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('external-scripts')
    <link href="{{ asset('css/lightslider.css') }}" rel="stylesheet"/>
    <script src="{{ asset('js/imageScroller.js') }}"></script>
    <script src="{{ asset('js/lightslider.js') }}"/></script>
@endsection
