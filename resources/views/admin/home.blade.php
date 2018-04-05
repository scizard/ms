<?php
$tenant = $rooms = $leaseRequests = $leaseCount = $statementCount = 0;
$landlordCount = count($landlord);
$houseCount = count($houses);

foreach ($houses as $house) {
    if ($house->status == 0) {
        $leaseRequests++;
    }
    if ($house->status == 1) {
        $rooms += $house->capacity;
    }
}
foreach ($statements as $statement){
    if($statement->action == 'book'){
        ++ $tenant;
    }
}
?>
@extends('layouts.admin')
@section('content')
    <div class="main-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Landlords</strong></h5>
                            <span>{{number_format($landlordCount)}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Tenants</strong></h5>
                            <span>{{ number_format($tenant) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-home  icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Apartments</strong></h5>
                            <span>{{number_format($houseCount)}}</span>
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
                                    <td class="">{{ number_format($tenant) }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="row">Rooms</td>
                                    <td>{{number_format($rooms)}}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Landlords</td>
                                    <td>{{number_format($landlordCount)}}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Apartments</td>
                                    <td>{{number_format($houseCount)}}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Transactions</td>
                                    <td>65</td>
                                </tr>
                                <tr>
                                    <td scope="row">Lease Requests</td>
                                    <td>{{number_format($leaseRequests)}}</td>
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
                    <h3>Statements @if(count($statements) > 0)<i
                                class="badge badge-danger">{{number_format(count($statements))}}</i>@endif </h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                            @if(count($statements)>0)
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($statements as $statement)
                                        @if($statementCount < 5)
                                            <tr>
                                                <td scope="row">{{++$statementCount}}</td>
                                                <td>{{number_format($statement->amount)}}</td>
                                                <td>{{$statement->action}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center table table-hover">
                                    <br>
                                    <br>
                                    <br>
                                    <h1 class="text-danger">Sorry. No statements were found</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.statements') }}">
                        <center>
                            <h3>view all</h3>
                        </center>
                    </a>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-4 ">
                <div class="activity_box activity_box2">
                    <h3>Lease Requests @if($leaseRequests > 0)<i
                                class="badge badge-danger">{{number_format($leaseRequests)}}</i>@endif </h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                            @if($leaseRequests>0)
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
                                        @if($house->status == 0 && $leaseCount < 5)
                                            <tr>
                                                <td scope="row">{{++$leaseCount}}</td>
                                                <td scope="row">{{$house->houseName}}</td>
                                                <td>{{number_format($house->capacity)}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center table table-hover">
                                    <br>
                                    <br>
                                    <br>
                                    <h1 class="text-danger">Sorry. No requests were found</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.leaseRequests') }}">
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