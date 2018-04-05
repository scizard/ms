@extends('layouts.user')

@section('content')
    <div class="main-page">
        <div class="col_1">
            <div class="col-md-12">
                <div class="activity_box activity_box2">
                    <h3 class="text-center">Check-Out</h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                            <div class="row">
                                <div class="sign-up__main">

                                    <div class="col-md-6">
                                        <br>
                                        <h1 class="text-center">Payment method</h1>
                                        <br>
                                        <img src="{{ asset('homeStyles/images/uploads/Visa.png') }} "
                                             class="img img-responsive">
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <h1 class="text-center">Order</h1>

                                        <form action="{{ route('checkout') }}" method="POST">
                                            {{ csrf_field() }}
                                            <label class="text-bold">House name:</label><br>
                                            <input class="form-control" name="item" value="{{ $house->houseName }}"
                                                   disabled/>
                                            <input name="item" value="{{ $house->houseName }}" hidden/>
                                            <label  class="text-bold">Cost per unit:</label><br>
                                            <input class="form-control" id="" name="" value="KES {{ number_format($house->price) }}"
                                                   disabled/>
                                            <input name="price" id="price" value="{{ $house->price }}" hidden/>
                                            <label  class="text-bold">Available:</label><br>
                                            <input class="form-control" name="available"
                                                   value="{{ $house->capacity - $house->booked }}" disabled/>
                                            <label  class="text-bold">Quantity:</label><br>
                                            <input class="form-control" name="available"
                                                   value="1" disabled/>
                                            <label  class="text-bold">Total cost:</label><br>
                                            <input name="cost" class="form-control" value="KES {{ number_format($house->price) }}" disabled/>
                                            <input name="houseID" value="{{ $house->houseID }}" hidden/>
                                            <input name="id" value="{{ $house->id }}" hidden/>

                                            <br>
                                            {{--<input type="submit" class="btn btn-block btn-success form-control" value="Local payment">--}}

                                            <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="{{ env('STRIPE_PUB_KEY') }}"
                                                    data-amount=" {{ $house->price * 100 }} "
                                                    data-name="{{ env('APP_NAME') }} Payment"
                                                    data-description="Pay {{ $house->houseName }}"
                                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                    data-locale="auto"
                                                    data-zip-code="true"
                                                    data-currency="kes">
                                            </script>


                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

        </div>

    </div>

@endsection

