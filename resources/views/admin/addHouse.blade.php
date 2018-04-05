@extends('layouts.admin')

@section('content')
    <!-- main content start-->
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <h3 class="text-center">Add a house</h3>
                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        <form action="{{ route('admin.addHouse') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group" {{ $errors->has('houseName') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">House name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="houseName" class="form-control" id="houseName"
                                           placeholder="The name of the house..." value="{{ old('houseName') }}" required>
                                    @if ($errors->has('houseName'))
                                        <span class="help-block text-danger">
                                                 <strong>{{ $errors->first('houseName') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('capacity') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">Capacity:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="capacity" class="form-control" id="capacity"
                                           placeholder="The field officer's work ID..."
                                           value="{{ old('capacity') }}" required>
                                    @if ($errors->has('capacity'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('capacity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('booked') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">Already booked:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="booked" class="form-control" id="booked"
                                           placeholder="Number of already booked rooms..."
                                           value="{{ old('booked') }}" required>
                                    @if ($errors->has('booked'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('booked') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('price') ? ' has-error' : '' }}>
                                <label for="price" class="col-sm-2 control-label">Price (per unit):</label>
                                <div class="col-sm-9">
                                    <input type="text" name="price" class="form-control" id="price"
                                           placeholder="Price per unit..."
                                           value="{{ old('price') }}" required>
                                    @if ($errors->has('price'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('street') ? ' has-error' : '' }}>
                                <label for="street" class="col-sm-2 control-label">Street:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="street" id="street"
                                           placeholder="Street name..."
                                           value="{{ old('street') }}" required>
                                    @if ($errors->has('street'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('town') ? ' has-error' : '' }}>
                                <label for="town" class="col-sm-2 control-label">Town:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="town" id="town"
                                           placeholder="Town..."
                                           value="{{ old('town') }}" required>
                                    @if ($errors->has('town'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('town') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('ownerName') ? ' has-error' : '' }}>
                                <label for="ownerName" class="col-sm-2 control-label">Owner Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="ownerName" id="ownerName"
                                           placeholder="The landlords Name..."
                                           value="{{ old('ownerName') }}" required>
                                    @if ($errors->has('ownerName'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('ownerName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('landPhoneNumber') ? ' has-error' : '' }}>
                                <label for="region" class="col-sm-2 control-label">Owner contact:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="landPhoneNumber" id="landPhoneNumber"
                                           placeholder="The landlords phone number..."
                                           value="{{ old('landPhoneNumber') }}" required>
                                    @if ($errors->has('landPhoneNumber'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('landPhoneNumber') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group"}}>
                                <label for="region" class="col-sm-2 control-label">Category:</label>
                                <div class="col-sm-9">
                                    <select name="houseCategory" class="form-control" style="width: 70%">
                                        <option value="Single Rentals">Single Rentals</option>
                                        <option value="Bedsitter Rentals">Bedsitter Rentals</option>
                                        <option value="Single Hostels">Single Hostels</option>
                                        <option value="Bedsitter Hostel">Bedsitter Hostels</option>
                                        <option value="Apartments">Apartments</option>
                                        <option value="Commercial">Commercials</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('defaultImg') ? ' has-error' : '' }}>
                                <label for="region" class="col-sm-2 control-label">Default Image:</label>
                                <div class="col-sm-9">
                                    <input type="file"  name="defaultImg" id="defaultImg" class="form-control" style="width: 70%;"
                                           value="{{ old('defaultImg') }}" required >
                                    @if ($errors->has('defaultImg'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('defaultImg') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-offset-2">
                                <button type="submit" class="btn btn-primary custom-btn" style="background: #00a78e;">Add House</button>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection