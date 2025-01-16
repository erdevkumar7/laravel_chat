<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );

        $this->apiContext->setConfig([
            'mode' => config('services.paypal.settings.mode'),
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'ERROR',
        ]);
    }

    public function createPayment(Request $request)
    {
        // if()      

        // $price = $request->total_amount;
        $price = 10;
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setTotal($price);
        $amount->setCurrency("USD");

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("Payment Of Product");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.execute'))
            ->setCancelUrl(route('payment.cancel'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
            return redirect($payment->getApprovalLink());
        } catch (\Exception $ex) {
            return back()->withError('Error processing PayPal payment.');
        }
    }

    public function executePayment(Request $request)
    {
        $paymentId = $request->paymentId;
        $payerId = $request->PayerID;
    
        $payment = Payment::get($paymentId, $this->apiContext);
    
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
    
        try {
            $result = $payment->execute($execution, $this->apiContext);
            if ($result->getState() === 'approved') {                          
                // Save payment details in payments table
                PaymentDetail::create([
                    'user_id' => Auth::guard('web')->user()->id,
                    'paypal_payment_id' => $result->getId(),
                    'status' => $result->getState(),
                    'amount' => $result->transactions[0]->getAmount()->getTotal(),
                    'currency' => $result->transactions[0]->getAmount()->getCurrency(),
                ]);
                // \Log::info('Payment Result: ',  (array)$result->transactions[0]->getAmount()->getCurrency());  
                return view('front.customer.paymentSuccess');
            }
        } catch (\Exception $ex) {
            return back()->withError('Payment execution failed.');
        }
    
        return back()->withError('Payment failed.');
    }

    public function cancelPayment()
    {
        return view('front.customer.paymentCancel');
    }
}
