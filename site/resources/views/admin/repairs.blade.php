@extends('layouts.header')

@section('content')
    <div id="container">
        <div class="row">
            <div class="col s8 repairPanel">
                <p class="header-text headerNoMargin">
                    Achternaam, Voornaam
                </p>
                <p class="header-text headerNoMargin">
                    email@email.com
                </p>
                <hr class="line" />
                <p class="header-text headerNoMargin">
                    Omschrijving
                </p>
                <textarea cols="30" rows="10" class="repairPanelTextarea">Allemaal test data</textarea>
                <div class="row">
                    <div class="col s6">
                        <p class="header-text headerNoMargin">
                            Wachtwoord
                        </p>
                        <input name="" type="text" value="" class="passwordRepairField" />
                    </div>
                    <div class="col s6">
                        <p class="header-text headerNoMargin">
                            Garantie bewijs
                        </p>
                        <p class="repairGarantieBewijs">
                            <i class="material-icons">insert_drive_file</i>
                            Garantiebewijs.pdf
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s4">
                <p class="header-text headerNoMargin repairHeader">
                    Reparaties
                </p>
                <div class="allRepairsScroller">
                    <p class="header-text headerNoMargin">
                        Zoek reparatie
                    </p>
                    <input name="" type="text" value=""/>
                    <div class="repairs">
                        <ul>
                            @for($i = 0; $i < 10; $i++)
                                <li class="repaitListItem">
                                    Voornaam, achternaam <br/> email
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('external-scripts')
    <script src="{{ asset('js/matchHeight.js') }}"></script>
@endsection
