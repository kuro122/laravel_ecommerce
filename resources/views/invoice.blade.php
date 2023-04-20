<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Invoice</title>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}
		th, td {
			text-align: left;
			padding: 8px;
			/* border-bottom: 1px solid #ddd; */
		}
		th {
			background-color: #f2f2f2;
		}
	</style>
</head>
<body>
  <h1>E-SHOPPER</h1>
  Order ID
  <br>
  xyz Name
  <br>
  address
  <br>
  contact

	<table>
		<thead>
			<tr>
				<th>Description</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Item 1</td>
				<td>1</td>
				<td>$10.00</td>
				<td>$10.00</td>
			</tr>
			<tr>
				<td>Item 2</td>
				<td>2</td>
				<td>$20.00</td>
				<td>$40.00</td>
			</tr>
			<tr>
				<td colspan="3">Subtotal</td>
				<td>$50.00</td>
			</tr>
			<tr>
				<td colspan="3">Tax (10%)</td>
				<td>$5.00</td>
			</tr>
			<tr>
				<td colspan="3">Total</td>
				<td>$55.00</td>
			</tr>
		</tbody>
	</table>
</body>
</html>
