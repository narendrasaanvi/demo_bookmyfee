<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Payment;
use App\Models\TournamentRegistration;
use App\Models\PlayerRegistration;
use Dompdf\Options;

class PaymentReceiptController extends Controller
{
    public function index(Request $request, $orderId)
    {
        // Fetch the payment record using the provided transaction ID
        $payment = Payment::where('order_id', $orderId)->first();

        // Fetch the user associated with the payment
        $user = User::find($payment->user_id);

        // Fetch all tournament registrations based on the tournament_id from the payment's order_id
        $tournamentRegistrations = TournamentRegistration::where('order_id', $payment->order_id)->get();

        // Fetch players registered in the tournament
        $players = PlayerRegistration::whereIn('id', $tournamentRegistrations->pluck('player_id'))->get();

        $imagePath = public_path('assets/images/logo.png');

        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
            $base64Image = 'data:image/' . $imageType . ';base64,' . $imageData;
        } else {
            $base64Image = ''; // Default in case the image path is incorrect
        }


        // Prepare the HTML content for the PDF
        //return view('frontend.payment.payment-receipt', compact('players', 'user', 'payment','base64Image'))->render();
        $html =  view('frontend.payment.payment-receipt', compact('players', 'user', 'payment','base64Image'))->render();

        // Configure DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Instantiate DomPDF
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($html);

        // Render PDF (first pass to get PDF size and layout)
        $dompdf->render();

        // Output the PDF (stream directly to the browser)
        return $dompdf->stream('invoice.pdf');
    }
}
