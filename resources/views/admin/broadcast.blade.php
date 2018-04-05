@extends('layouts.admin')

@section('content')
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <center>
                    <h3>Broadcast Mail
                    </h3>
                </center>

                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        <div class="inbox-page">

                            <form class="com-mail" method="post" action="{{ route('admin.broadcast') }}">
                                {{ csrf_field() }}
                                <label>Send message to:</label><br><br>
                                <input type="radio" name="category" value="all" checked/><label> All</label>
                                <input type="radio" name="category" value="landlords"/><label> Landlords</label>
                                <input type="radio" name="category" value="tenants"/><label> Tenants</label>
                                <br>
                                <br>
                                <label>Subject:</label><br>
                                <input type="text" class="form-control1 control3" name="subject" placeholder="Subject :"><br>
                                <label>Message:</label><br>
                                <textarea class="form-control1 control2"  name="message" placeholder="Message :"></textarea>
                                <input type="submit" value="Send Message">
                            </form>

                        </div>

                    </div>

                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection