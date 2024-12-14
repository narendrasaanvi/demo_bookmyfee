<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    private $merchantId = 'M22KY0BL57LIO';
    private $apiKey = 'd52c9150-dcba-43f3-968a-93eaf7eb4d34';
    private $redirectUrl;
 
    public function __construct()
    {
        $this->redirectUrl = route('payment.callback');
    }

    public function index(Request $request, Payment $payment, $orderId)
    {
        // Retrieve the order details using the Payment model
        $payment = $payment->where('order_id', $orderId)->first();

        if (!$payment) {
            return redirect()->back()->with('error', 'Invalid order ID.');
        }

        return view('frontend.payment.index', compact('payment'));
    }

    public function store(Request $request)
    {
        $orderId = $request->input('orderId');
        $amount = $request->input('amount');

        // Prepare transaction data and send the payment request
        $transactionData = $this->prepareTransactionData($orderId, $amount);
        $response = $this->sendPaymentRequest($transactionData);

        if ($this->isPaymentInitiated($response)) {
            return redirect()->away($response->data->instrumentResponse->redirectInfo->url);
        }

        return redirect()->back()->with('error', 'Payment initiation failed. Please try again later.');
    }

    private function prepareTransactionData($orderId, $amount)
    {
        return [
            'merchantId' => $this->merchantId,
            'merchantTransactionId' => $orderId,
            'merchantUserId' => $orderId,
            'amount' => $amount * 100, // amount in paise
            'redirectUrl' => $this->redirectUrl,
            'redirectMode' => "POST",
            'callbackUrl' => $this->redirectUrl,
            'paymentInstrument' => [
                'type' => "PAY_PAGE",
            ],
        ];
    }

    private function generateRequestHeader($encodedPayload)
    {
        $payload = $encodedPayload . "/pg/v1/pay" . $this->apiKey;
        return hash("sha256", $payload) . '###' . 1;
    }

    private function sendPaymentRequest($transactionData)
    {
        $encodedPayload = base64_encode(json_encode($transactionData));
        $hashedHeader = $this->generateRequestHeader($encodedPayload);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-VERIFY: " . $hashedHeader,
                "accept: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode(['request' => $encodedPayload]),
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            Log::error("cURL Error: " . curl_error($curl));
            return null;
        }

        curl_close($curl);

        return json_decode($response);
    }

    private function isPaymentInitiated($response)
    {
        return $response && isset($response->code) && $response->code == 'PAYMENT_INITIATED';
    }

    public function handleCallback(Request $request, Payment $payment)
    {
        if ($request->code === 'PAYMENT_SUCCESS') {
            $payment = $payment->where('order_id', $request->transactionId)->first();

            if ($payment) {
                $payment->update([
                    'payment_status' => 'approve', // Update payment status to 'APPROVED'
                    'provider_reference_id' => $request->providerReferenceId,
                    'checksum' => $request->checksum,
                ]);
            }

            return view('frontend.payment.thanks', [
                'orderId' => $request->transactionId,
                'errors' => ''
            ]);
        }

        return redirect()->back()->with('error', 'Payment failed. Please try again later.');
    }
}
