@extends('layouts.home')

@section('main')

<div id="wrapper">

    @include('partials.login_header')
    @include('partials.header')

    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="inner">
                    <div class="hero hero-custom hero-narrrow">
                        <!-- <h2>To reset ypur password, enter your e-mail bla-bla-bla...</h2>               -->
                        <div class="subscribe">
                            <form method="post" action="/password-recovery/check/{{ $user->confirmation_code}}">
                                <div class="form-row">
                                    <input name="password" size="30" value="" required="" class="text login_input" placeholder="New Password" type="password">
                                    <input value="Change password" class="btn" data-loading-text="Loading..." type="submit">
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

@stop

