@extends('layouts.admin')

@section('content')
    <?php
    $counter = 0;
    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <h3 class="text-center">Lease Requests
                    @if($leaseRequests->total() > 0 )
                        <br>Showing <strong>{{ count($leaseRequests) }}</strong> records
                    of <strong>{{ $leaseRequests->total() }}</strong>
                    @endif
                </h3>
                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        @if($leaseRequests->total() > 0 )
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Landlord</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Capacity</th>
                                    <th>Booked</th>
                                    <th colspan="3" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leaseRequests as $house)
                                    <tr>
                                        <td scope="row">{{++$counter}}</td>
                                        <td scope="row">{{$house->houseName}}</td>
                                        <td scope="row">{{$house->houseName}}</td>
                                        <td scope="row">{{$house->landPhoneNumber}}</td>
                                        <td scope="row">{{$house->location}}</td>
                                        <td scope="row">{{number_format($house->capacity)}}</td>
                                        <td scope="row">{{number_format($house->booked)}}</td>
                                        <td><a href="/admin/requests/preview/{{$house->id}}" class="btn btn-info pull-right">Preview</a>
                                        </td>
                                        <td><a href="/admin/requests/accept/{{$house->id}}" class="btn btn-success pull-right">Lease</a>
                                        </td>
                                        <td><a href="/admin/requests/reject/{{$house->id}}" class="btn btn-danger pull-right">Reject</a>
                                        </td>
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
                        <div class="pull-right">{{ $leaseRequests->links() }}</div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection