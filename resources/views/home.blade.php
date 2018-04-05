@extends('layouts.user')

@section('content')
    <?php
    $booked = count($statements);
    $count = count($houses);
    $rent = $days = 0;


    foreach ($statements as $statement) {

        $rent += $statement->amount;

    }

    $now = date("d");
    if ($now > 10) {
        $days = 30 - $now + 10;
    }
    if ($now < 10) {
        $days = 10 - $now;
    }

    ?>
    <div class="main-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 ">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-hourglass dollar2 icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Remaining</strong></h5>
                            <span>{{ $days }} Day(s)</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-home  icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Booked Rooms</strong></h5>
                            <span>{{ number_format($booked) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="r3_counter_box">
                        <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                        <div class="stats">
                            <h5><strong>Total Rent</strong></h5>
                            KES <span>{{ number_format($rent) }}</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col_1">
            <br>
            <br>
            <div class="col-md-12">
                <div class="activity_box activity_box2">
                    <h3 class="text-center">Available Houses</h3>
                    <div class="" id="style-3">
                        <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                            <div class="pull-right">
                                {{$houses->links()}}
                            </div>
                            <div class="row">

                                @if($count > 0)
                                    @foreach($houses as $house)
                                        <div class="col-md-6 item-grid__container">
                                            <div class="listing">
                                                <div class="item-grid__image-container">
                                                    <a href="/preview/{{$house->id}}">
                                                        <div class="item-grid__image-overlay"></div>
                                                        <!-- .item-grid__image-overlay -->
                                                        <img src="{{$house->img}}" alt="{{$house->name}} "
                                                             class="listing__img img-responsive std-image-home">
                                                        <span class="listing__favorite"><i class="fa fa-heart-o"
                                                                                           aria-hidden="true"></i></span>
                                                    </a>
                                                </div><!-- .item-grid__image-container -->

                                                <div class="item-grid__content-container">
                                                    <div class="listing__content">
                                                        <div class="listing__header">
                                                            <div class="listing__header-primary">
                                                                <h3 class="listing__title"><a
                                                                            href="/preview/{{$house->id}}">{{$house->houseName}}</a>
                                                                </h3>
                                                                <p class="listing__location"><span
                                                                            class="ion-ios-location-outline listing__location-icon"></span> {{$house->location}}
                                                                </p>
                                                            </div><!-- .listing__header-primary -->
                                                            <p class="listing__price">
                                                                KES {{number_format($house->price)}} per month</p>
                                                        </div><!-- .listing__header -->
                                                        <div class="listing__details">
                                                            <ul class="listing__stats">
                                                                <li>
                                                                    <span class="listing__figure">Rooms: </span>{{number_format($house->capacity)}}
                                                                </li>
                                                                <li>
                                                                    <span class="listing__figure">Booked: </span> {{number_format($house->booked)}}
                                                                </li>
                                                                <li>
                                                                    <span class="listing__figure">Available: </span>{{number_format($house->capacity - $house->booked )}}
                                                                </li>
                                                            </ul><!-- .listing__stats -->
                                                            <a href="/preview/{{$house->id}}" class="listing__btn">Details
                                                                <span
                                                                        class="listing__btn-icon"><i
                                                                            class="fa fa-angle-right"
                                                                            aria-hidden="true"></i></span></a>
                                                        </div><!-- .listing__details -->
                                                    </div><!-- .listing-content -->
                                                </div><!-- .item-grid__content-container -->
                                            </div><!-- .listing -->
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center table table-hover">
                                        <br>
                                        <br>
                                        <br>
                                        <h1 class="text-danger">Sorry. No rooms were found</h1>
                                    </div>
                                @endif
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
