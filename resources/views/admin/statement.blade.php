@extends('layouts.admin')

@section('content')
    <?php
    $counter = 0;
    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <h3 class="text-center">Admin Statements
                    @if($statements->total() > 0)
                        <br>Showing <strong>{{ count($statements) }}</strong> records of
                        <strong>{{ $statements->total() }}</strong>
                    @endif
                </h3>
                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        @if($statements->total() > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>From</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statements as $statement)
                                    <tr>
                                        <td scope="row">{{++$counter}}</td>
                                        <td scope="row">{{$statement->initiator}}</td>
                                        <td scope="row">KES {{number_format($statement->amount)}}</td>
                                        <td scope="row">{{$statement->action}}</td>
                                        <td scope="row">{{$statement->created_at}}</td>
                                    </tr>
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
                    <div class="col-md-12 bg-parent">
                        .
                        <div class="pull-right">{{ $statements->links() }}</div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection