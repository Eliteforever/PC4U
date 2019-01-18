@extends('layouts.header')
<?php $item = 0;?>
@section('content') 
    <div id="cart-container" class="cart-container">
        <div class="row">
            <div class="col s8">
                <p class="header-text recentProductsHeader">&nbsp;</p>
                <div class="Orderinfo">
                    <p class="header-text OrderInfoHeader">Vul uw informatie in</p>
                    <div class="OrderInfoForm">
                        <form action="{{ route('checkoutPost') }}" method="post">
                            {{ csrf_field() }}
                            <table class="">
                                <tbody>
                                    <tr>
                                        <td>Voornaam</td>
                                        <td name="firstName">{{ Auth::user()->firstName }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tussenvoegsel</td>
                                        <td>{{ Auth::user()->middleName }}</td>
                                    </tr>
                                    <tr>
                                        <td>Achternaam</td>
                                        <td>{{ Auth::user()->lastName }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr/></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Telefoonnummer</td>
                                        <td>{{ Auth::user()->phoneNumber }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr/></td>
                                    </tr>
                                    <tr>
                                        <td>Plaats</td>
                                        <td><input name="city" type="text" class="browser-default" value="{{ $address->city }}" /></td>
                                    </tr>
                                    <tr>
                                        <td>Straat</td>
                                        <td><input name="streetName" type="text" class="browser-default" value="{{ $address->streetName }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Huisnummer</td>
                                        <td><input name="houseNumber" type="text" class="browser-default huisnummerMain" value="{{ $address->houseNumber }}"/><input name="houseNumberExtension" type="text" class="browser-default huisnummerToevoeging" value=""/></td>
                                    </tr>
                                    <tr>
                                        <td>Postcode</td>
                                        <td><input name="postalCode" type="text" class="browser-default" value="{{ $address->postalCode }}"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr/></td>
                                    </tr>
                                    <tr>
                                        <td><p class="checkboxInput">
                                            <input type="checkbox" class="newsletter" id="newsletter" checked="checked" />
                                            <label for="newsletter">Ontvang de wekelijkse nieuwsbrief</label>
                                        </p></td>
                                    </tr>
                                    <tr>
                                        <td><p class="checkbox">
                                            <input type="checkbox" class="terms" id="terms" name="terms"/>
                                            <label for="terms">Ik ga akkoord met de voorwaarden</label>
                                        </p></td>
                                    </tr>
                                    <tr>
                                        <td><button class="order-button">
                                            Bevestig gegevens
                                        </button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col s4 recent_items">
                <p class="header-text recentProductsHeader">Recent bekeken</p>
                @for($i = 0; $i < 5; $i++)
                    <div class="productBox recentProductsBox">
                        <div class="row" style="margin-bottom:-10px;">
                            <div class="col s4">
                                <img alt="Product image" src="http://via.placeholder.com/120x120"/>
                            </div>
                            <div class="col s8">
                                <b><p style="margin-top:0px;">
                                    Product  naam
                                </p></b>
                                33,99
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection 
