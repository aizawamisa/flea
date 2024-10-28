@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('main')
    @if (session('success'))
        <div class="message-success" id="message">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="message-error" id="message">
            {{ session('error') }}
        </div>
    @endif
<div class="section-wrap">
    <div class="section-group">
        <div class="image-content">
            <img class="image-content__image" src="{{ asset($item->img_url) }}" alt="商品画像">
        </div>
        <div class="item-content">
            <h2 class="item-content__title">{{ $item->name }}</h2>
            <p class="item-content__price">¥{{ number_format($item->price) }}</p>        
        </div>
    </div>
    <div class="payment-group">
        <div class="header-content">
            <h3 class="header-content__title">支払方法</h3>
            <a class="link-button" href="/purchase/payment/{{ $item->id }}">変更する</a>
        </div>
        
         <div class="confirm-content confirm-content__payment"> 
            <p class="address-content">{{ isset($paymentMethod) ? $paymentMethod : '支払方法が未選択です' }}</p>
        </div>
    </div>
    <div class="address-group">
        <div class="header-content">
            <h3 class="header-content__title">配送先</h3>
            <a class="link-button" href="/purchase/address/{{ $item->id }}">変更する</a>
        </div>
        <div class="address-content">
            @if (isset($profile) && isset($profile->postcode))
            <p class="address-content__text">〒{{ substr($profile->postcode, 0, 3) . '-' . substr($profile->postcode, 3) }}</p>
            <p class="address-content__text">{{ $profile->address }} <span>{{ $profile->building }}</span></p>
            @else
            <p class="address-content">配送先情報がありません</p>
            @endif
        </div>
    </div>
</div>

<form class="confirm-wrap" action="/purchase/decide/{{ $item->id }}" method="post"> 
    @csrf
    <div class="confirm-group">
        <div class="confirm-content confirm-content__price"> 
            <p class="confirm-content__title">商品代金</p>
            <p class="confirm-content__text">¥{{ number_format($item->price) }}</p>
        </div>
        <div class="confirm-content confirm-content__total"> 
            <p class="confirm-content__title">支払い金額</p>
            <p class="confirm-content__text">¥{{ number_format($item->price) }}</p>
        </div>
        <div class="confirm-content confirm-content__payment"> 
            <p class="confirm-content__title">支払い方法</p>
            <p class="confirm-content__text">{{ $paymentMethod ?? '未選択' }}</p>
        </div>
    </div>
    
    @if(isset($paymentMethod) && isset($profile->postcode))
        @if($paymentMethod === 'クレジットカード')
            <a href="{{ route('create', ['item_id' => $item->id]) }}" class="btn btn-primary">クレジットカード決済</a>
        @else
            @if(session('paymentId'))
                <input type="hidden" name="payment_id" value="{{ session('paymentId') }}">
            @endif
            <button class="submit-button" type="submit" onclick="return confirm('購入しますか？')">購入する</button>
        @endif
    @endif    
</form>
@endsection