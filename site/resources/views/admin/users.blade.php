@extends('layouts.header')
@section('content')
<div id="container">
    <p class="header-text">Gebruikers</p>
    @if(request()->route()->uri == "admin/users")
        <p class="sub-header sub-left"><a href="{{ route('getAllUsers') }}"><b>Alle gebruikers</b></a></p>
        <p class="sub-header sub-left sub-left-margin"><a href="{{ route('getRemovedUsers') }}">Verwijderde gebruikers</a></p>
    @else
        <p class="sub-header sub-left"><a href="{{ route('getAllUsers') }}">Alle gebruikers</a></p>
        <p class="sub-header sub-left sub-left-margin"><a href="{{ route('getRemovedUsers') }}"><b>Verwijderde gebruikers</b></a></p>
    @endif
    <table class="usersTable striped responsive-table">
        <thead>
        <tr>
            <th>Admin</th>
            <th>Naam</th>
            <th>Email</th>
            <th>Telefoon nummer</th>
            <th>Adres</th>
            <th colspan="2">Acties</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allUsers as $user)
        <tr>
            <td>
                @if($user->admin != 0)
                    <i class="material-icons">check</i>
                @else
                    <i class="material-icons">close</i>
                @endif
            </td>
            <td>{{ \App\Traits\nameTrait::getSpecificName($user->id) }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phoneNumber }}</td>
            <td>{{ \App\Traits\addressTrait::getAddressInfo($user->addressID) }}</td>
            @if(request()->route()->uri == "admin/users")
                {{--<td><i class="material-icons" onclick="updateUser({{ $user->id }})">create</i></td>--}}
                <td>
                    <form action="{{ route('removeUser', $user->id) }}" method="post">
                        {{ csrf_field() }}
                        <input type="submit" class="material-icons transparent-btn" value="clear">
                    </form>
                </td>
            @else
                <td>
                    <form action="{{ route('activateUser', $user->id) }}" method="post">
                        {{ csrf_field() }}
                        <input type="submit" class="material-icons transparent-btn" title="Re-activate" value="check">
                    </form>
                </td>
            @endif
            <td>
                <form action="{{ route('getUserAdmin', $user->id) }}" method="get">
                    {{ csrf_field() }}
                    <input type="submit" class="material-icons transparent-btn" title="Edit" value="edit">
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(request()->route()->uri == "admin/users")
    {{--<div id="modal1" class="modal modal-fixed-footer">--}}
        {{--<div class="modal-content productImageModal">--}}
            {{--<form action="{{ route('editUser') }}">--}}
                {{--<input type="text" class="firstName" name="firstName">--}}
                {{--<input type="text" class="middleName" name="middleName">--}}
                {{--<input type="text" class="lastName" name="lastName">--}}
                {{--<input type="email" class="email" name="email">--}}
                {{--<input type="number" class="phoneNumber" name="phoneNumber">--}}
            {{--</form>--}}
        {{--</div>--}}
        {{--<div class="modal-footer">--}}
            {{--<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>--}}
        {{--</div>--}}
    {{--</div>--}}
@endif
@endsection
@section('external-scripts')
    <script src="{{ asset('js/admin/users.js') }}"></script>
@endsection