@extends('layouts.landlord')

@section('content')
    <!-- main content start-->
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <h3 class="text-center">Withdraw to stripe</h3>
                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">

                        <form action="{{ route('landlord.withdraw') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <p class="text-center">Your current balance is <span class="text-success">KES {{ number_format($balance) }}</span> </p><br>
                            <div class="form-group" {{ $errors->has('amount') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">Amount:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="amount" class="form-control" id="amount"
                                           placeholder="Amount to withdraw" value="{{ old('amount') }}" required>
                                    @if ($errors->has('amount'))
                                        <span class="help-block text-danger">
                                                 <strong>{{ $errors->first('amount') }}</strong>
                                                 </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" {{ $errors->has('password') ? ' has-error' : '' }}>
                                <label for="name" class="col-sm-2 control-label">Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control" id="password" style="width:70%;"
                                           placeholder="Your password"
                                           value="{{ old('password') }}" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                           <div class="form-group">
                                <label for="name" class="col-sm-2 control-label"></label>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary custom-btn" style="background: #00a78e;">Withdraw</button>
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