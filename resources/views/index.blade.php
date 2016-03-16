@extends('layouts.default')

@section('layout_style_class')
 col1-layout
@endsection

@section('main')

<div class="col-main">
    <div class="std">
        
        @include('partials.index.banner')
        @include('partials.index.promo_products')
        @include('partials.index.customers_feedback')
        @include('partials.index.inviter')
        
    </div>
</div>


@endsection