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
                            <form id="password-recovery-form" method="post" novalidate="novalidate">
                                <div class="form-row">
                                    <input name="email" id="subscribe_email" size="30" value="" required="" class="text login_input" placeholder="Email address" type="text">
                                    <input value="Recover password" class="btn" data-loading-text="Loading..." type="submit">
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

@section('scripts')
<script>
$(document).ready(function() {
    $form = $('#password-recovery-form');
    $form.on('submit', function() {
        $.ajax({
            data: $form.serializeArray(),
            type: "POST",
            url: '/password-recovery',
            cache: false,
            dataType: 'json',
            success: function(response) {
                toastr.success('Check your email for password recovering');
            }
        });
        
        return false;
    });
});
</script>
@stop

