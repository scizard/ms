@extends('layouts.landlord')

@section('content')
    <?php
    $counter = 0;
    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <center>
                    <h3>Statements <br>
                        @if($statements->total() > 0)
                            <br>Showing <strong>{{ count($statements) }}</strong> statements of
                            <strong>{{ $statements->total() }}</strong>
                        @endif
                    </h3>
                </center>

                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        @if($statements->total() > 0)
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>From</th>
                                    <th>PhoneNumber</th>
                                    <th>Amount</th>
                                    <th colspan="2">Transaction code</th>
                                    <th>House ID</th>
                                    <th>Email</th>
                                    <th colspan="2">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($statements as $statement)
                                <tr>
                                    <td>{{ ++$counter }}</td>
                                    <td>
                                        @foreach( $users as $user)
                                            @if($user->phoneNumber == $statement->user)
                                                {{$user->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{  $statement->user }}</td>
                                    <td>KES {{ number_format($statement->amount) }}</td>
                                    <td colspan="2">{{ $statement->referenceCode }}</td>
                                    <td>{{ $statement->houseID }}</td>
                                    <td>{{ $statement->email }}</td>
                                    <td colspan="2">{{ date('h:i:s a F d, Y', strtotime($statement->created_at)) }}</td>
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