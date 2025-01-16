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
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Shipping;
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
        $userId = Auth::guard('web')->user()->id;
        $shipping = Shipping::where('user_id', $userId)->first();
        if(!$shipping){
            return back()->withErrors([
                'empty_data' => 'You have not added Address, please add the Address!',
            ])->withInput();
        }
        $priceInInr = $request->total_amount;
        $exchangeRate = 0.012; // Example: 1 INR = 0.012 USD
        $priceInUsd = $priceInInr * $exchangeRate;
        // dd($priceInUsd);
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setTotal(number_format($priceInUsd, 2));
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
                $userId = Auth::guard('web')->user()->id;

                $cartItems = Cart::where('user_id', $userId)->with('product')->get();
                if ($cartItems->isEmpty()) {
                    return back()->withError('Cart is empty. Please try again.');
                }
                // Save order and payment details
                $order = Order::create([
                    'user_id' => $userId,
                    'paypal_payment_id' => $result->getId(),
                    'total_amount' => $result->transactions[0]->getAmount()->getTotal(),
                    'currency' => $result->transactions[0]->getAmount()->getCurrency(),
                    'payment_status' => $result->getState(),
                    'order_status' => 'completed', // Order status
                ]);

                foreach ($cartItems as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product->id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->product->price,
                    ]);
                }
                // Clear the cart
                Cart::where('user_id', $userId)->delete();
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
