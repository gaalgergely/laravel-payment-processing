<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Resolvers\PaymentPlatformResolver;

class PaymentController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');

        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function pay(PaymentRequest $request)
    {
        try {

            $paymentPlatformId = $request->get('payment_platform', null);

            $paymentPlatform = $this->paymentPlatformResolver->resolveService($paymentPlatformId);

            session()->put('paymentPlatformId', $paymentPlatformId);

            return $paymentPlatform->handlePayment($request);

        } catch (\Exception $e) {

            return redirect()->route('home')->withErrors($e->getMessage());

        }
    }

    public function approval()
    {
        if(session()->has('paymentPlatformId')) {

            try {

                $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('paymentPlatformId'));
                return $paymentPlatform->handleApproval();

            } catch (\Exception $e) {

                /**
                 * We can not retrieve your payment platform.
                 */
                return redirect()->route('home')->withErrors($e->getMessage());

            }
        }
    }

    public function cancelled()
    {
        return redirect()->route('home')->withErrors('You cancelled the payment.');
    }
}
