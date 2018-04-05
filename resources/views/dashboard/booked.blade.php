@extends('layouts.user')

@section('content')
    <?php
    $counter = 0;
    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <center>
                    <h3>Booked rooms <br>
                        @if($houses->total() > 0)
                            <br>Showing <strong>{{ count($houses) }}</strong> room(s) of
                            <strong>{{ $houses->total() }}</strong>
                        @endif
                    </h3>
                </center>

                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        @if($houses->total() > 0)
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>House Name</th>
                                    <th>House ID</th>
                                    <th>Rent</th>
                                    <th>Landlord</th>
                                    <th colspan="2">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($houses as $house)
                                <tr>
                                    <td>{{ ++$counter }}</td>
                                    <td>
                                        @foreach($rooms as $room)
                                            @if($room->houseID == $house->houseID)
                                                {{ $room->houseName }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $house->houseID }}</td>
                                    <td>KES {{ number_format($house->amount) }}</td>
                                    <td>{{ $house->benefactor }}</td>
                                    <td colspan="2">{{ date('h:i:s a F d, Y', strtotime($house->created_at)) }}</td>
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
                        <div class="pull-right">{{ $houses->links() }}</div>
                    </div>

                </div>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection