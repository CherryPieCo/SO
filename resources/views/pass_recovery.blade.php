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
                            <div id="success">
                                <span class="green textcenter">
                                    <p>
                                        Thank you for signing up.
                                    </p> </span>
                            </div>
                            <div id="error">
                                <span>
                                    <p>
                                        Something went wrong. Please refresh and try again.
                                    </p> </span>
                            </div>
                            <form id="subscribe" name="subscribe" method="post" novalidate="novalidate">
                                <div class="form-row">
                                    <input name="subscribe_email" id="subscribe_email" size="30" value="" required="" class="text login_input" placeholder="Email address" type="text">
                                    <input id="submit" name="submit" value="Recover password" class="btn" data-loading-text="Loading..." type="submit">
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



