@include('layouts.nav')<!-- .header -->
<section class="item-grid">
    <div class="container">
        @if(count($houses) > 0)
        <div class="row">
            <div class="sign-up__header">
                <center>
                    <h1 class="sign-up__textcontent"><a href=""
                                                        class="sign-up__tab is-active">APARTMENTS. <br><small>{{ count($houses) }} results found</small></a>
                    </h1>
                </center>
            </div>


                @foreach($houses as $house)
                    <div class="col-md-6 item-grid__container">
                        <div class="listing">
                            <div class="item-grid__image-container">
                                <a href="/show/{{$house->id}}">
                                    <div class="item-grid__image-overlay"></div><!-- .item-grid__image-overlay -->
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
                                            <p class="listing__title"><a
                                                        href="/show/{{$house->id}}">{{$house->houseName}}</a></p>
                                            <p class="listing__location"><span
                                                        class="ion-ios-location-outline listing__location-icon"></span> {{$house->location}}
                                            </p>
                                        </div><!-- .listing__header-primary -->
                                        <p class="listing__price">KES {{number_format($house->price)}} per month</p>
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
                                        <a href="/show/{{$house->id}}" class="listing__btn">Details <span
                                                    class="listing__btn-icon"><i class="fa fa-angle-right"
                                                                                 aria-hidden="true"></i></span></a>
                                    </div><!-- .listing__details -->
                                </div><!-- .listing-content -->
                            </div><!-- .item-grid__content-container -->
                        </div><!-- .listing -->
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    <br>
                    <br>
                    <br>
                    <center>
                        <h1 style="color: red;">Sorry. No Apartment records were found</h1>
                    </center>
                </div>
            @endif
        </div>
        <div class="pull-right">
            {{$houses->links()}}
        </div>
    </div><!-- .container -->
</section>
@include('layouts.footer')