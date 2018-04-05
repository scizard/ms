@extends('layouts.landlord')
@section('content')

    <?php
    $transactionCount = $leaseCount = $booked = $earned = $tenants = $apartments = $rooms = 0;
        foreach ($statements as $statement){
            $earned += $statement->amount;
            $tenants++;
        }

        foreach ($houses as $house){
            $apartments ++;
            $rooms += $house->capacity;
            $booked += $house->booked;
        }

        foreach ($transactions as $transaction){
            $transactionCount++;
        }
    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Earned</strong></h5>
                            <span>KES {{ number_format($balance) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Tenants</strong></h5>
                            <span>{{ number_format($tenants) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-home  icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Apartments</strong></h5>
                            <span>{{ number_format($apartments) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-hotel  icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Rooms</strong></h5>
                            <span>{{number_format($rooms)}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col_1">
            <br>
            <br>
            <div class="col-md-4">
                <div class="activity_box activity_box2">
                    <h3>Analysis</h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <td>Tenants</td>
                                    <td class="">{{ number_format($tenants) }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="row">Total Rooms</td>
                                    <td>{{number_format($rooms)}}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Booked Rooms</td>
                                    <td>{{ number_format($booked) }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Available rooms</td>
                                    <td>{{ number_format($rooms - $booked)  }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Transactions</td>
                                    <td>{{ number_format($transactionCount) }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Apartments</td>
                                    <td>{{ number_format($apartments) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="">
                        <center>
                            <h3>view all</h3>
                        </center>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-4 ">
                <div class="activity_box activity_box2">
                    <h3>Statements </h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                           @if($transactionCount > 0)
                            <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Stripe Code</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($transactions as $transaction)
                                        <td>{{ number_format($transaction->amount) }}</td>
                                        <td>{{ $transaction->referenceCode }}</td>
                                    @endforeach
                                    </tbody>
                                </table>
                               @else
                                <div class="text-center">
                                    <br>
                                    <br>
                                    <br>
                                    <h1 class="text-danger">Sorry. No records were found</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('landlord.statement') }}">
                        <center>
                            <h3>view all</h3>
                        </center>
                    </a>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-4 ">
                <div class="activity_box activity_box2">
                    <h3>Property Leased </h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">

                            @if($apartments > 0)
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="">Capacity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($houses as $house)
                                        @if($house->status == 1)
                                        <tr>
                                            <td>{{++$leaseCount}}</td>
                                            <td>{{ $house->houseName }}</td>
                                            <td class="">{{ $house->capacity }}</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center">
                                    <br>
                                    <br>
                                    <br>
                                    <h1 class="text-danger">Sorry. No records were found</h1>
                                </div>
                            @endif

                        </div>
                    </div>
                    <a href="{{ route('landlord.remove') }}">
                        <center>
                            <h3>view all</h3>
                        </center>
                    </a>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

        </div>

    </div>
@endsection