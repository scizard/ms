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
                            <h1 class="sign-up__textcontent"><a href="#log-in" class="sign-up__tab is-active">RESET PASSWORD</a>
                            </h1>
                        </center>
                    </div><!-- .sign-up__header -->

                    <div class="sign-up__main">
                        <form action="{{ route('reset') }}" class="sign-up__form is-visible" method="post">

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
                            <button type="submit" class="sign-up__submit">Reset Password</button>
                        </form><!-- .sign-up__form -->
                    </div>
                </div>
            </div><!-- .row -->
        </div><!-- .sign-up__container -->
    </div>
</section>

@include('layouts.footer')