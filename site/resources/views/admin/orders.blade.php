@extends('layouts.header')
@section('content')
<div id="container">
    <p class="header-text">Orders</p>
    <table class="usersTable striped responsive-table">
        <thead>
        <tr>
            <th>Email</th>
            <th>Order No.</th>
            <th>Geplaatst op</th>
            <th>Order details</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allOrders as $order)
        <tr>
			<td>{{ $order->email }}</td>
			<td>{{ $order->uniqueOrderID }}</td>
			<td>{{ $order->created_at }}</td>
			<td><a href="/order/{{ $order->uniqueOrderID }}">Klik hier</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection