@extends('layouts.home')

@section('main')

<div id="wrapper" class="wrapper-page wrapper-flexi">

    @include('partials.login_header')
    @include('partials.header')

    <div class="container">

        <div class="row">

            <div class="span12">

                <div class="inner">

                    <div class="hero">

                        <h1>Contact Us</h1>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="clearfix"></div>

</div>

<div class="strip" id="content">

    <div class="container">

        <div class="row">

            <div class="span8">

                <div class="inner">
                    <div class="row">
                        <!-- <div class="span1">
                        <div class="inner"></div>
                        </div> -->
                        <div class="span12">
                            <!-- <h1 class="text-center fwb text-branded">Contact us</h1> -->
                            <h3 class="text-center">We strive to make our service better every day. Write us your suggestions and comments on its work.</h3>
                        </div>
                    </div>

                    <div class="row contact-section">
                        <div class="span2">
                            <div class="inner"></div>
                        </div>
                        <div class="span9 contact-form">
                            <div class="">
                                <div class="form-box form-box-custom">
                                    <div class="top">
                                        <h3 class="fwb">Fill out the form below to send the message</h3>
                                    </div>

                                    <div class="bottom">
                                        <form id="signup" name="signup" method="post" novalidate="novalidate">
                                            <div class="form-row">
                                                <div class="span3">
                                                    <label>Name</label>
                                                </div>
                                                <div class="span9">
                                                    <input name="contact_name" id="contact_name" size="30" value="" required="" class="text login_input" placeholder="Your name" type="text">
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="form-row">
                                                <div class="span3">
                                                    <label>Email</label>
                                                </div>
                                                <div class="span9">
                                                    <input name="contact_email" id="contact_email" size="30" value="" required="" class="text login_input" placeholder="Email Address" type="text">
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="form-row">
                                                <div class="span3">
                                                    <label>Subject</label>
                                                </div>
                                                <div class="span9">
                                                    <input name="contact_subject" id="contact_subject" size="30" value="" class="text login_input" placeholder="Subject" type="text">
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="form-row">
                                                <div class="span3">
                                                    <label>Text</label>
                                                </div>
                                                <div class="span9">
                                                    <textarea name="contact_text" id="contact_text" placeholder="Text"></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="form-row">
                                                <input id="send" name="send" value="Send" class="btn btn-wide btn-extrawide" data-loading-text="Loading..." type="submit">
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- <div class="span4 contact-image"></div> -->
                    </div>
                </div>

            </div>

            <div class="span4">

                <div class="inner" id="sidebar">

                    <ul>

                        <!--<li>
                        <h3><span class="glyph-item icon-cloud-download" aria-hidden="true" ></span>Download our app!</h3>
                        <p>Phasellus consequat facilisis volutpat ma faucibus odio vitae semper. Ae volutpat lobortis. </p
                        </li>-->
                        <li>
                            <h3><span class="glyph-item  icon-pencil" aria-hidden="true" ></span> Signup</h3>
                            <form method="post" action="#" name="example">

                                <div class="form-row">
                                    <input id="user_name" placeholder="Your name" class="text login_input" type="text" name="user_name" required />
                                    <div class="clearfix"></div>
                                </div>

                                <div class="form-row">
                                    <input id="user_email" type="email" placeholder="Your email" class="text login_input" name="user_email" required />
                                    <div class="clearfix"></div>
                                </div>

                                <div class="form-row">
                                    <input type="submit" name="register" value="Sign up now!" class="btn btn-wide" data-loading-text="Loading..." />
                                    <div class="clearfix"></div>
                                </div>

                            </form>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="clearfix"></div>

        </div>

    </div>

</div>

<div class="clearfix"></div>

@include('partials.footer')


@stop

