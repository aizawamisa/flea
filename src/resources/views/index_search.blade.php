@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
    <div class="tab-wrap">
        <label class="tab-wrap__label">
            <input class="tab-wrap__input" type="radio" name="tab" checked>検索結果
        </label>
        <div class="tab-wrap__group">
            @forelse ($items as $item)
                <div class="tab-wrap__content">
                    @if ($item->soldToUsers()->exists())
                        <div class="sold-out__mark">SOLD OUT</div>
                    @endif
                    <a class="tab-wrap__content-link" href="/item/{{ $item->id }}">
                        <img class="tab-wrap__content-image" src="{{ $item->img_url }}">
                    </a>
                </div>
            @empty
                <p class="no-message">該当する商品はありません</p>
            @endforelse

            @for ($i = 0; $i < 10; $i++)
                <div class="tab-wrap__content dummy"></div>
            @endfor
        </div>
    </div>
@endsection