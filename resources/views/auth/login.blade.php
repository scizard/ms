@include('layouts.nav')<!-- .header -->
<section class="sign-up">
    <div class="container">
        <div class="sign-up__container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="sign-up__header">
                        <center>
                            <h1 class="sign-up__textcontent"><a href="#log-in" class="sign-up__tab is-active">LOGIN</a>
                            </h1>
                        </center>
                    </div><!-- .sign-up__header -->

                    <div class="sign-up__main">
                        <form action="{{ route('login') }}" class="sign-up__form is-visible" method="post">

                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('phoneNumber') ? ' has-error' : '' }}">
                                <label for="phoneNumber" class="sign-up__label">Phone Number:</label>
                                <input id="phoneNumber" type="text" class="sign-up__field" name="phoneNumber" value="{{ old('phoneNumber') }}" required autofocus>

                                @if ($errors->has('phoneNumber'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('phoneNumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="username" class="sign-up__label">Password</label>
                                <input id="password" type="password" class="sign-up__field" name="password" value="{{ old('password') }}" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="sign-up__submit">Sign In</button>
                            <a href="{{route('reset')}}" class="sign-up__link" style="margin-left: 10px;">Forgot Password?</a>
                        </form><!-- .sign-up__form -->
                    </div>
                </div>
            </div><!-- .row -->
        </div><!-- .sign-up__container -->
    </div>
</section>

@include('layouts.footer')