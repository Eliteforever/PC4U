
    @foreach($final[0] as $data)
        <table border="1">
            <thead>
            <th>Name</th>
            <th>Amount</th>
            <th>Price BTW</th>
            <th>Price</th>
            </thead>
            <tbody>
            <tr>
                <td>{{ $data['name'] }}</td>
                <td>{{ $data['amount'] }}</td>
                <td>{{ number_format($data['priceAfterDiscount'] * $data['amount'], 2) }}</td>
                <td>{{ number_format(($data['priceAfterDiscount'] * $data['amount']) - $data['btw'], 2) }}</td>
            </tr>
            </tbody>
        </table>
    @endforeach