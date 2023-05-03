<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB ;
class OrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'order',
        );
    }

    public function build(){
        $tax = 500;
    if (Auth::check()) {
        $cart_id = Auth::id();
    }
    // ______________________show product Details ____________________________
    $data = DB::table('cart')
    ->join('product', 'cart.product_id', '=', 'product.id')
    ->select('cart.*', 'product.name', 'product.price', 'product.image')
    ->where('cart.user_id', $cart_id)
    ->get();
    // $checkout_details = $data->id;

    $prices = $data->pluck('price'); // get a collection of all prices
    $items = $data->pluck('no_of_items');
    $total = $prices->map(function ($price, $index) use ($items) {
        return $price * $items[$index];
    })->sum();

                $html = '<html>
<head>
    <title>New order has been booked</title>
</head>
<body>
    <h1>Your Order Has Been Booked</h1>
    <p>Thank you for choosing our E-SHOPPER service. Your order has been successfully booked.</p>
    <table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>';
    foreach ($data as $row) {
        $html .= '<tr>
            <td>'.$row->name.'</td>
            <td>'.$row->no_of_items.'</td>
            <td>'.$row->price.'</td>
        </tr>';
    }
    $html .= '
        <tr>
            <td colspan="3">Subtotal</td>
            <td>'.$total.'</td>
        </tr>
        <tr>
            <td colspan="3">Shipping</td>
            <td>'.$tax.'</td>
        </tr>
        <tr>
            <td colspan="3">Total</td>
            <td>'.$total+$tax.'</td>
        </tr>
    </tbody>
</table>
<p>Regards,</p>
<p>Eshopper</p>

</body>
</html>';

return $this->from('E-SHOPPER@example.com')
            ->subject('New order has been booked')
            ->html($html)   
            ->with('items', $data);

}

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
