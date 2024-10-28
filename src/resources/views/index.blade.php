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
    <div class="tab-wrap">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="tab-wrap__label active" data-tab="recommendation">おすすめ</div>

        <div class="tab-wrap__label" data-tab="mylist">マイリスト</div>
               
        <div class="tab-wrap__group active" id="recommendation">
                @foreach ($items as $item)
                    <div class="tab-wrap__content">
                        @if ($item->soldToUsers()->exists())
                            <div class="sold-out__mark">SOLD OUT</div>
                        @endif
                        <a class="tab-wrap__content-link" href="/item/{{ $item->id }}">
                            <img class="tab-wrap__content-image" src="{{ $item->img_url }}">
                        </a>
                    </div>
                @endforeach

                <!-- ページネーションのリンク -->
                <div class="pagination"> 
                {{ $items->links('vendor.pagination.items') }}
                </div>

                @for ($i = 0; $i < 10; $i++)
                    <div class="tab-wrap__content dummy"></div>
                @endfor  
        </div>

        <div class="tab-wrap__group" id="mylist">
            @auth      
                @forelse ($likeItems as $item)
                <div class="tab-wrap__content">
                    @if ($item->soldToUsers()->exists())
                        <div class="sold-out__mark">SOLD OUT</div>
                    @endif
                        <a class="tab-wrap__content-link" href="/item/{{ $item->id }}">
                            <img class="tab-wrap__content-image" src="{{ $item->img_url }}">
                        </a>
                    </div>
                @empty
                    <p class="no-message">マイリストはありません</p>
                @endforelse

                <!-- ページネーションのリンク -->
                <div class="pagination">
                {{ $likeItems->links('vendor.pagination.items') }}
                </div>

                @for ($i = 0; $i < 10; $i++)
                    <div class="tab-wrap__content dummy"></div>
                @endfor
            @else
                <div class="tab-wrap__group-link-1">
                    <a class="link-button-1" href="/register" >会員登録</a>
                    <span class="tab-wrap__group-1">及び</span>
                    <a class="link-button-1" href="/login">ログイン</a>
                    <span class="tab-wrap__group-1">が必要です</span>
                </div>
            @endauth
        </div>
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
                tabContents.forEach(content => content.classList.remove('active'));
                // 対応するコンテンツを表示する
                const target = tab.getAttribute('data-tab');
                document.getElementById(target).classList.add('active');
            });
        });
    });
</script>
@endsection

