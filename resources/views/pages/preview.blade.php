@extends('layouts.user')

@section('content')
    <div class="main-page">
        <div class="col_1">
            <div class="col-md-12">
                <div class="activity_box activity_box2">
                    <h3 class="text-center">{{$preview->houseName}}</h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="sign-up__main">
                                        <img src="{{asset($preview->img)}}" class="img-responsive std-image" width="1000" height="700">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="sign-up__main">

                                        <div class="sign-up__header">
                                            <center>
                                                <ul class="property__list">
                                                    <li class="property__item">
                                                        <a href="" class="property__link">
                                                            <i class="ion-android-person property__icon"></i>
                                                            <span class="property__item-desc">{{env('APP_NAME')}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="property__item">
                                                        <a href="" class="property__link">
                                                            <i class="ion-android-phone-portrait property__icon"></i>
                                                            <span class="property__item-desc">{{$preview->landPhoneNumber}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="property__item">
                                                        <a href="" class="property__link">
                                                            <i class="ion-android-locate property__icon"></i>
                                                            <span class="property__item-desc">{{$preview->location}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="property__item">
                                                        <a href="" class="property__link">
                                                            <i class="ion-android-home property__icon"></i>
                                                            <span class="property__item-desc"
                                                                  style="color: #1fc341;">{{number_format($preview->capacity - $preview->booked)}}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </center>
                                            <br>
                                            <center>
                                                <h1 class="sign-up__textcontent"><a href=""
                                                                                    class="sign-up__tab is-active">Description</a>
                                                </h1>
                                                <p>{{$preview->houseName}} is a {{$preview->category}} house with a total capacity of {{number_format($preview->capacity)}}. It has {{number_format($preview->booked)}} booked rooms and it is located at {{$preview->location}}, Kenya.</p>
                                            </center>
                                            <br>
                                            <center>
                                                <h1 class="sign-up__textcontent"><a href=""
                                                                                    class="sign-up__tab is-active">Action</a>
                                                </h1>

                                                Available: <span style="color: green;">{{number_format($preview->capacity - $preview->booked)}}</span>
                                                <br>
                                                <br>
                                                <a href="/checkout/{{$preview->id}}" class="header__cta ">Book</a>
                                                <br>
                                                <br>

                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

        </div>

    </div>

@endsection

