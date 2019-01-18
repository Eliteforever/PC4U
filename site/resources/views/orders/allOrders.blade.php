@extends('layouts.header')
@section('content')
    <div id="container">
        <p class="header-text">Alle orders geplaatst door: {{ \App\Traits\nameTrait::getName() }}</p>
        <div class="row">
            @forelse($allOrders as $order)
                <div class="col s12 m4">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Order No. {{ $order->uniqueOrderID }}</span>
                            <p>Order geplaats: {{ $order->created_at }}</p>
                        </div>
                        <div class="card-action">
                            <a href="/order/{{ $order->uniqueOrderID }}" target="_blank">Bekijk order</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="header-text center">Nog geen order geplaatst door {{ \App\Traits\nameTrait::getName() }}</p>
            @endforelse
        </div>
    </div>
@endsection