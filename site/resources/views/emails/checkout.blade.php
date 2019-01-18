@extends('layouts.email_head')
@section('content')
<td class="content-wrap">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="content-block">
                Thanks for your order at PC4U,
                {{ \App\Traits\nameTrait::getName() }}!
            </td>
        </tr>
        <tr>
            <td class="content-block">
                We will send you an email when we start the shipping process.
            </td>
        </tr>
        <tr>
            <td class="content-block">
                <a href="{{ url('order') }}/{{ $data['orderID'] }}" class="btn-primary">View my order</a>
            </td>
        </tr>
        <tr>
            <td class="content-block">
                Regards,
                PC4U
            </td>
        </tr>
    </table>
</td>
@endsection