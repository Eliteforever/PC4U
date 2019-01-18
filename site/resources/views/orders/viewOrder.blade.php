@extends('layouts.header')

@section('content')
    <div id="container">
        <p class="header-text">Order No. {{ $orderInfo['orderInfo']['uniqueOrderID']}}</p>
        <p class="sub-header">Placed by: {{ \App\Traits\nameTrait::getName() }}</p>
        <a class="sub-header factuur" href="/factuur/{{ $orderInfo['orderInfo']['uniqueOrderID'] }}">Bekijk factuur</a>
        <div class="row">
            @foreach($orderInfo['products'] as $productObject)
                <div class="col s12 m3">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="/getImage/{{ $productObject['product']->imageID }}">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">{{ $productObject['product']->name }}
                                <i class="material-icons right">arrow_drop_up</i></span>
                            <p>&euro;{{ number_format(($productObject['product']->price * ($productObject['product']->btw / 100 + 1)) * $productObject['amount'], 2) }}</p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">{{ $productObject['product']->name }}<i
                                        class="material-icons right">arrow_drop_down</i></span>
                            <p>{{ $productObject['product']->description }}</p>
                            <hr>
                            <p>Aantal gekocht: {{ $productObject['amount'] }}</p>
                            <hr>
                            <p>Subtotaal Incl BTW:
                                &euro;{{ number_format(($productObject['product']->price * ($productObject['product']->btw / 100 + 1)) * $productObject['amount'], 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection