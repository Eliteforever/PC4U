@extends('layouts.header')
<?php $item = 0; $sum = "0";?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenLite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/RoundPropsPlugin.min.js"></script>
@section('content')
    <div id="cart-container" class="cart-container">
        <div class="row">
            <div class="col s8">
                <p class="header-text recentProductsHeader">&nbsp;</p>
                <table class="cartTable" id="tableCart">
                    <thead>
                        <tr>
                            <td>
                                Product naam
                            </td>
                            <td>
                                Aantal
                            </td>
                            <td>
                                Prijs per stuk
                            </td>
                            <td>
                                Prijs Excl. BTW
                            </td>
                            <td>
                                Acties
                            </td>
                        </tr>
                    </thead>
                    <tbody id="cartBody">
                        @forelse($finalArr[0] as $product)
                            <tr id="cartItemRow" data-btw="{{ $product['item'][0]['btw'] }}" data-prodId="{{ $product['item'][0]['id'] }}">
                                
                                <td>
                                    {{ $product['item'][0]->name }}
                                    
                                </td>
                                <td class="amount">
                                    <input name="amount" min="1" max="100" type="number" id="amountInput" value="{{ $product['amount'] }}" class="amountInput" />
                                    
                                </td>
                                <td class="productPrice">
                                    <?php
                                    $summ = 0;
                                    if ($product['item'][0]->priceAfterDiscount > 0){
                                        $summ = $product['item'][0]->priceAfterDiscount;
                                    } else {
                                        $summ = (($product['item'][0]->price * ($product['item'][0]->btw / 100 + 1)));
                                    }
                                    ?>
                                    € {{ number_format($summ, 2, '.', '') }}
                                </td>
								<input class="productPriceHidden" type="hidden" value="{{ number_format($product['item'][0]->price, 2) }}">
                                <td class="productPriceAll">
                                    € {{ number_format($product['item'][0]->price * $product['amount'], 2, '.', '') }}
                                </td>
                                <td>
                                    <i onclick="removeFromCart({{ $item }}, {{ $product['item'][0]->id }})" class="material-icons cart_icons">remove_circle</i>
                                </td>
                            </tr>
                            <?php $item++; ?>
                        @empty
                            <td colspan="5">Geen producten in winkelwagen</td>
                        @endforelse
                        <tr>
                            <td colspan="1" class="whitespace-table"></td>
                            <td colspan="1" class="whitespace-table"></td>
                            <td>Totaal <span class="smaller_text">(Excl. Btw)</span></td>
                            <td colspan="3" id="priceExBTW">
                                <?php $sum = "0";?>
                                @forelse($finalArr[0] as $prod)
                                    <?php $sum = $sum + ($product['item'][0]->price * $product['amount']) ?>
                                @empty

                                @endforelse
                                € {{ number_format($sum, 2, '.', '') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" class="whitespace-table"></td>
                            <td colspan="1" class="whitespace-table"></td>
                            <td>Totaal <span class="smaller_text">(Incl. Btw)</span></td>
                            <td colspan="3" id="priceInclBTW">
                                <?php $summ = "0";?>
                                @forelse($finalArr[0] as $prod)
                                    <?php

                                    $summ = 0;
                                    if ($product['item'][0]->priceAfterDiscount > 0){
                                        $summ = $product['item'][0]->priceAfterDiscount * $product['amount'];
                                    } else {
                                        $summ = (($product['item'][0]->price * ($product['item'][0]->btw / 100 + 1)) * $product['amount']);
                                    }
                                    
                                    Debugbar::addMessage($summ, 'including BTW');
                                    ?>
                                @empty

                                @endforelse
                                € {{ number_format($summ, 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="1" class="whitespace-table"></td>
                            <td colspan="1" class="whitespace-table"></td>
                            <td colspan="1"></td>
                            <td class="oder-button" colspan="3">
                                <a href="{{ route('checkout') }}" class="order-href">
                                    @if(!empty($finalArr))
                                        <button class="order-button">
                                    @else
                                            <button class="order-button" disabled="disabled">
                                    @endif
                                    Bestellen
                                            </button>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col s4 recent_items">
                <p class="header-text recentProductsHeader">Recent bekeken</p>
                @forelse($finalArr[1] as $product)
                    <a href="/product/{{ $product[0]->id }}">
                        <div class="productBox recentProductsBox">
                            <div class="row" style="margin-bottom:-10px;">
                                <div class="col s4">
                                    <img alt="Product image" src="/getImage/{{ $product[0]->imageID }}" width="120" height="120" />
                                </div>
                                <div class="col s8">
                                    <b><p style="margin-top:0px;">
                                        {{ $product[0]->name }}
                                    </p></b>
                                    <p>
                                        {{ $product[0]->description }}
                                    </p>

                                    <?php
                                    $summ = 0;
                                    if ($product[0]->priceAfterDiscount > 0){
                                        $summ = $product[0]->priceAfterDiscount;
                                    } else {
                                        $summ = (($product[0]->price * ($product[0]->btw / 100 + 1)));
                                    }
                                    ?>

                                    <p class="recentPrice">€ {{ number_format($summ, 2, '.', '') }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="header-text center">Geen recent bekeken producten</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection 
