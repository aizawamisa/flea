@extends('layouts.app')

@section('css')
<link rel= "stylesheet" href= "{{ asset('css/index.css') }}">
<style>
    .tab-wrap__label.active {
        font-weight: bold;
        border-bottom: 2px solid #000;
    }
    .tab-wrap__group {
        display: none;
    }
    .tab-wrap__group.active {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
</style>
@endsection

@section('main')
    <div class="user-wrap">
        <div class="user-group">
            <img class="user-group__icon" src="{{ $user->img_url ?? asset('img/default_user.png') }}">
            <div class="user-unit">
                <p class="user-unit__name">
                {{ $user->name }}
                </p>
            </div>
        </div>
        <a class="user-wrap__profile" href="/mypage/profile">プロフィールを編集</a>
    </div>

    <div class="tab-wrap">
    @if(session('success'))
    <div class="message-success" id="message">
        {{ session('success') }}
    </div>
    <script src="https:ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
            $(document).ready(function(){
                $("#message").fadeIn(1000).delay(3000).fadeOut(1000);
            });
    </script>
    @endif

        <div class="tab-wrap__label active" data-tab="sell_items">出品した商品</div>
        <div class="tab-wrap__label" data-tab="bought_items">購入した商品</div>
            
        <div class="tab-wrap__group active" id="sell_items">
            @forelse ($sellItems as $item)
                <div class="tab-wrap__content">
                    @if ($item->soldToUsers()->exists())
                        <div class="sold-out__mark">SOLD OUT</div>
                    @endif
                    <a class="tab-wrap__content-link" href="/item/{{ $item->id }}">
                        <img class="tab-wrap__content-image" src="{{ $item->img_url }}">
                    </a>
                </div>
            @empty
                <p class="no-message">出品した商品はありません</p>
            @endforelse

            <!-- ページネーションのリンク -->
            <div class="pagination">
            {{ $sellItems->links('vendor.pagination.items') }}
            </div>

            @for ($i = 0; $i < 10; $i++)
                <div class="tab-wrap__content dummy"></div>
            @endfor  
    </div>

    <div class="tab-wrap__group" id="bought_items">
        @forelse ($soldItems as $item)
            <div class="tab-wrap__content">
                <div class="sold-out__mark">SOLD OUT</div>
                <a class="tab-wrap__content-link" href="/item/{{ $item->id }}">
                    <img class="tab-wrap__content-image" src="{{ $item->img_url }}">
                </a>
            </div>
        @empty
            <p class="no-message">購入した商品はありません</p>
        @endforelse  

        <!-- ページネーションのリンク -->
        <div class="pagination">
        {{ $soldItems->links('vendor.pagination.items') }}
        </div>
        
        @for ($i = 0; $i < 10; $i++)
            <div class="tab-wrap__content dummy"></div>
        @endfor
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-wrap__label');
        const tabContents = document.querySelectorAll('.tab-wrap__group');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // すべてのタブからactiveクラスを外す
                tabs.forEach(t => t.classList.remove('active'));
                // クリックされたタブにactiveクラスを付ける
                tab.classList.add('active');

                // すべてのコンテンツを非表示にする
                tabContents.forEach(content => {content.classList.remove('active');
                content.style.display = 'none';
            });


                // 対応するコンテンツを表示する
                const target = tab.getAttribute('data-tab');
                const activeContent = document.getElementById(target);
                activeContent.classList.add('active');
                activeContent.style.display = 'flex';
            });
        });
    });
</script>
@endsection