
<div class="pdfSendToData">
	<div class="toDiv">
		Aan:
	</div>
	<div class="pdfSendDataToDetails">
		<p>de heer / mevrouw {{$data->orderDetails['name']}}</p>
		<p>{{$data->orderDetails['streetName']}} {{$data->orderDetails['houseNumber']}}</p>
		<p>{{$data->orderDetails['postalCode']}} {{$data->orderDetails['city']}}</p>
	</div>
</div>

<div class="pdfSendFromData">
	<p>PC4U</p>
	<p>{{$data->companyDetails['streetName']}} {{$data->companyDetails['houseNumber']}}</p>
	<p>{{$data->companyDetails['postalCode']}} {{$data->companyDetails['city']}}</p>
	<p>E-mail: {{$data->companyDetails['email']}}</p>
	<p>Telefoonnummer: {{$data->companyDetails['phoneNumber']}}</p>
</div>

<div class="pdfInvoiceDetails">
	<p>Factuurnummer: {{$data->orderDetails['uniqueOrderID']}}</p>
	<p>Datum van ontvangst: {{$data->orderDetails['created_at']}}</p>
</div>

<?php 
	$totalPrice = 0;
	setlocale(LC_MONETARY, 'nl_NL'); 
?>

<table border="1" class="pdfProductDetails">
	<thead>
		<tr>
			<th>Productnaam</th>
	        <th>Aantal</th>
	        <th>Prijs per stuk</th>
	        <th>BTW %</th>
	        <th>Korting %</th>
	        <th>Totaal</th>
	    </tr>
    </thead>
    <tbody>
    	
		@foreach($data->orderDetails['products'] as $orderProduct)
			<tr class="pdfProduct">
				<td>{{$orderProduct['name']}}</td>
				<td>{{$orderProduct['amount']}}</td>
				<td>{{$orderProduct['price']}}</td>
				<td>{{$orderProduct['btw']}}</td>
				<td>{{ 100 - (100 / ($orderProduct['price'] * (($orderProduct['btw'] / 100) + 1)) * $orderProduct['priceAfterDiscount']) }}</td>
				<?php 
					$price = 0;

					if ($orderProduct['priceAfterDiscount'] != ''){
						$price = $orderProduct['priceAfterDiscount'] * $orderProduct['amount'];

						echo '<td>€' . money_format('%.2n', $price) . '</td>';
					} else {
						$price = $orderProduct['price'] * (($orderProduct['btw'] / 100) + 1) * $orderProduct['amount'];
						echo '<td>€' . money_format('%.2n', $price) . '</td>';
					}

					$totalPrice += $price;
				?>
			</tr>
		@endforeach
	</tbody>
</table>

<div class="priceTotal">
	<p>Totale prijs: €{{ money_format('%.2n', $totalPrice) }}</p>
</div>