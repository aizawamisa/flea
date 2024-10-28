@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('main')
     <div class="header__title">
        <p class="header__text">支払方法の選択</p>
     </div>
     <form class="payment-wrap" action="/purchase/payment/select/{{ $item_id }}" method="post">
        @csrf
        <div class="payment-inner">
            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment_id" value="1" checked>クレジットカード
                    <span class="card-brand__area">
                        <img class="card-brand__area-img" src="{{ asset('img/jcb.svg') }}"  style="width: 5%"alt="JCB">
                        <img class="card-brand__area-img" src="{{ asset('img/master.svg') }}" style="width: 5%" alt="MASTER">
                        <img class="card-brand__area-img" src="{{ asset('img/visa.svg') }}" style="width: 5%" alt="VISA"> 
                    </span>
                </label>
            </div>

            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment_id" value="2">銀行振込
                </label>
            </div>

            <div class="radio-list">
                <label class="payment-label">
                    <input class="payment-radio" type="radio" name="payment_id" value="3">コンビニ
                </label>
            </div>
            <input type="hidden">
            <button class="submit-button" type="submit">変更する</button>
        </div>
     </form>
     @endsection