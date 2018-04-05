@extends('layouts.admin')

@section('content')
    <!-- main content start-->
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <h3 class="text-center">Change password</h3>
                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        <form action="{{ route('admin.changePassword') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group" {{ $errors->has('currentPassword') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">Current Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" name="currentPassword" class="form-control" id="currentPassword"
                                           placeholder="Your current password" value="{{ old('currentPassword') }}" required>
                                    @if ($errors->has('currentPassword'))
                                        <span class="help-block text-danger">
                                                 <strong>{{ $errors->first('currentPassword') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('newPassword') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">New Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" name="newPassword" class="form-control" id="newPassword"
                                           placeholder="The new password"
                                           value="{{ old('newPassword') }}" required>
                                    @if ($errors->has('newPassword'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('newPassword') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('confirmPassword') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">Confirm:</label>
                                <div class="col-sm-9">
                                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
                                           placeholder="Confirm your password..."
                                           value="{{ old('confirmPassword') }}" required>
                                    @if ($errors->has('confirmPassword'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('confirmPassword') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('houseName') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label"></label>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary custom-btn" style="background: #00a78e;">Change Password</button>
                                </div>
                            </div>
                            <div class=" form-group"></div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection