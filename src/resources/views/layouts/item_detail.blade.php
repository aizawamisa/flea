@extends('layouts.app')

@section('css')
<link rel= "stylesheet" href= "{{ asset('css/item.css') }}">
@endsection

@section('main')
   <div class="image-wrap">
      <div class="image-group">
        @if ($item->soldToUsers()->exists())
            <div class="sold-out__mark">SOLD OUT</div>
        @endif
        <img class="image-group__image" src="{{ asset($item->img_url) }}" alt="商品画像">
      </div>
   </div>

   <div class="detail-wrap">
      <div class="item-group">
        <h2 class="item-group__title">{{ $item->name }}</h2>
        <span class="item-group__brand">{{ $item->brand }}</span>
        <p class="item-group__price">¥{{ number_format($item->price )}}(値段)</p>
        <div>
            @if ($userLiked)
                <form action="/item/unlike/{{ $item->id }}" method="post">
                    @method('delete')
                    @csrf
                    <button class="item-icon__button" type="submit">
                        <img class="item-icon__image" src="{{ asset('img/star-solid.svg') }}" alt="お気に入り">
                        <p class="likes-count likes-count--red">{{ $likesCount }}</p>
                    </button>                  
                </form>
            @else            
               <form action="/item/like/{{ $item->id }}" method="post">
                  @csrf
                  <button class="item-icon__button" type="submit">
                    <img class="item-icon__image" src="{{ asset('img/star-regular.svg') }}" alt="お気に入り">
                    <p class="likes-count">{{ $likesCount }}</p>
                  </button>        
               </form>
            @endif
            <div class="comment-wrap">
                <button class="item-icon__button" onclick="location.href='{{ $link }}'">
                    <img class="item-icon" src="{{ request()->is('item/comment/*') ? asset('img/comment-solid.svg') : asset('img/comment-regular.svg') }}" alt="コメント">
                    <p class="comments-count">{{ $commentsCount }}</p>
                </button>
            </div>
        </div>
      </div>
      @yield('content')
   </div>
@endsection