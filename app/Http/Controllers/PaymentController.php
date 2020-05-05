<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pay(PaymentRequest $request)
    {
        return $request->all();
    }

    public function approval()
    {

    }

    public function cancelled()
    {

    }
}
