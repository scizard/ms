@extends('layouts.admin')

@section('content')
    <?php
    $counter = 0;
    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <h3 class="text-center">{{$preview->houseName}} Preview
                </h3>
                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="">
                        <div class="row">
                            <div class="col-md-5">
                                <center>
                                    <img src="{{asset($preview->img)}}" class="img-responsive">
                                </center>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr class="">
                                        <th class="text-center text-capitalize" colspan="2">{{$preview->houseName}} Information</th>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{$preview->houseName}}</td>
                                    </tr>
                                    <tr>
                                        <th>Landlord</th>
                                        <td>{{$preview->landPhoneNumber}}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact</th>
                                        <td>{{$preview->landPhoneNumber}}</td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td>{{$preview->location}}</td>
                                    </tr>
                                    <tr>
                                        <th>Capacity</th>
                                        <td>{{number_format($preview->capacity)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Booked</th>
                                        <td>{{number_format($preview->booked)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Available</th>
                                        <td>{{number_format($preview->capacity - $preview->booked)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td>
                                            @if($preview->status != 1)
                                                <a href="/admin/requests/accept/{{$preview->id}}" class="btn btn-success">Lease</a>
                                            @endif

                                            @if($preview->status != -1)
                                                <a href="/admin/requests/reject/{{$preview->id}}" class="btn btn-danger pull-center">Reject</a>
                                                @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection