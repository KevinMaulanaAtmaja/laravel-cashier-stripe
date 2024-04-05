<?php

namespace App\Http\Controllers\Subscriptions\Account;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view("product.index", compact("products"));
    }

    public function checkout()
    {
        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        $products = Product::all();
        $lineItems = [];
        $totalPrice = 0;
        foreach ($products as $p) {
            $totalPrice += $p->price;
            $lineItems[] = [
                [
                    'price_data' => [
                        'currency' => 'idr',
                        'product_data' => [
                            'name' => '[Anya T-shirt] ' . $p->name,
                            'images' => [$p->image],
                        ],
                        'unit_amount' => $p->price * 1000,
                    ],
                    'quantity' => 1,
                ]
            ];
        }
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);


        Order::create([
            'status' => 'unpaid',
            'total_price' => $totalPrice,
            'session_id' => $session->id,
        ]);
        // dd($request->all());

        return redirect($session->url);
    }
    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        $sessionId = $request->get('session_id');
        // $customer = null;
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException;
            }
            // dd($session);
            // $customer = \Stripe\Customer::retrieve($session->customer);
            $order = Order::where('session_id', $session->id)->first();
            if (!$order) {
                throw new NotFoundHttpException;
            }
            if ($order->status == 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }

            $customer = $session->customer_details->name;
            // dd($customer);
            $order = Order::where('session_id', $session->id)->first();
            // dd($order);
            return view('product.success', compact('customer', 'order'));
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }
    public function cancel()
    {
        return view('product.cancel');
    }

    public function webhook()
    {
        // $stripe = new \Stripe\StripeClient('sk_test_...');

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;


        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $sesionId = $session->id;

                $order = Order::where('session_id', $sesionId)->first();
                if ($order && $order->status == 'unpaid') {
                    $order->status = 'paid';
                    $order->save();
                    // send email to customer
                    return response('Webhook received', 200);
                }

                // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        return response('Webhook received', 200);
    }
}
