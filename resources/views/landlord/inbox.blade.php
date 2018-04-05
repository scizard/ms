@extends('layouts.landlord')

@section('content')
    <?php
    $counter = 0;
    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="activity_box activity_box2">
                <center>
                    <h3>Inbox <br>
                        @if($messages->total() > 0)
                            <br>Showing <strong>{{ count($messages) }}</strong> messages of
                            <strong>{{ $messages->total() }}</strong>
                        @endif
                    </h3>
                </center>

                <div class="" id="style-3">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        @if($messages->total() > 0)
                            @foreach($messages as $message)
                                <div class="inbox-page">
                                    {{++$counter}}.
                                    <div class="inbox-row widget-shadow" id="accordion" role="tablist"
                                         aria-multiselectable="true">

                                        <div class="mail mail-name"><h6>@if($message->from == env('ADMIN'))Support. @else {{$message->from}} @endif</h6></div>
                                        <a role="button" data-toggle="collapse" data-parent="" href=""
                                           aria-expanded="true" aria-controls="collapseOne">
                                            <div class="mail"><p>{{$message->subject}}</p>
                                            </div>
                                        </a>
                                        <div class="mail-right"><p>{{$message->created_at}}</p></div>
                                        <div class="clearfix"></div>

                                        <div class="">
                                            <div class="mail-body">
                                                <p>{{$message->message}}.</p>
                                                <form action="{{ route('landlord.reply') }}" method="post">
                                                    <input type="text" name="message" placeholder="Reply to sender" required="">
                                                    <input name="to" value="{{$message->from}}" hidden>
                                                    <input name="subject" value="{{$message->subject}}" hidden>
                                                    <input type="submit" value="Send">

                                                    {{ csrf_field() }}
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center">
                                <br>
                                <br>
                                <br>
                                <h1 class="text-danger">Sorry. No records were found</h1>
                            </div>
                        @endif

                    </div>

                </div>
                <div class="col-md-12 bg-parent">
                    .
                    <div class="pull-right">{{ $messages->links() }}</div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection