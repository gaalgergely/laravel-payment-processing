@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Make a payment</div>

                <div class="card-body">
                    <form action="{{ route('pay') }}" method="POST" id="paymentFrom">
                        @csrf
                        <div class="row">
                            <div class="col-auto">
                                <label for="">How much you want to pay?</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    min="5"
                                    step="0.01"
                                    name="value"
                                    value="{{ mt_rand(500, 100000) / 100 }}"
                                    required
                                >
                                <small class="form-text text-muted">
                                    Use values with up to two decimal positions, using a dot "."
                                </small>
                            </div>
                            <div class="col-auto">
                                <label for="">Currency</label>
                                <select name="currency" id="" class="custom-select" required>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->iso }}">{{ strtoupper($currency->iso) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Select the desired payment platform</label>
                                <div class="form-group" id="toggler">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        @foreach($PaymentPlatforms as $PaymentPlatform)
                                            <label
                                                class="btn btn-outline-secondary rounded m-2 p-1"
                                                data-target="#{{ $PaymentPlatform->name }}Collapse"
                                                data-toggle="collapse"
                                            >
                                                <input
                                                    type="radio"
                                                    name="payment_platform"
                                                    value="{{ $PaymentPlatform->id }}"
                                                    required
                                                >
                                                <img src="{{ asset($PaymentPlatform->image) }}" class="img-thumbnail">
                                            </label>
                                        @endforeach
                                    </div>
                                    @foreach($PaymentPlatforms as $PaymentPlatform)
                                        <div
                                            id="{{ $PaymentPlatform->name }}Collapse"
                                            class="collapse"
                                            data-parent="#toggler"
                                        >
                                            @includeIf('components.' . strtolower($PaymentPlatform->name) . '-collapse')
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="PayButton">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
