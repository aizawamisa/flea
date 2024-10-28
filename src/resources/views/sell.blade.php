@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('main')
    @if (session('success'))
        <div class="message-success" id="message">
            {{ session('success') }}
    @endif

    <h2 class="main-title">商品の出品</h2>
    <form class="form-wrap" action="{{ isset($item_id) ? '/sell/' . $item_id : '/sell' }}" method="post" enctype="multipart/form-data">
        @csrf
        <span class="form-wrap__label">商品画像
            <div class="image-group">            
            @if($item)
                <a class="image-link" href="{{ $item->img_url}}">
                    <img class="preview-image" id="preview-image" src="{{ $item->img_url }}">
                </a>
            @else
                <img class="preview-image" id="preview-image" style="display: none">
            @endif            
                <label class="image-group__label">
                    <input class="image-group__input" type="file" id="image" name="img_url" onchange="previewFile()">画像を選択する
                </label>
            </div>
        </span>
        @error('img_url')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <h3 class="form-wrap__title">商品の詳細</h3>
        <label class="form-wrap__label">カテゴリー
            <select class="form-wrap__select" name="category_id">
                <option disabled {{ old('category_id') ? '' : 'selected' }}>---選択---</option>
                @foreach ($selectedCategories as $category)
                    <option value="{{ $category['id'] }}" {{ old('category_id', $category['id']) == $category['id'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                @endforeach
            </select>
        </label>
        @error('category_id')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <label class="form-wrap__label">商品の状態
            <select class="form-wrap__select" name="condition_id">
                <option disabled {{ old('condition_id') ? '' : 'selected' }}>---選択---</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}"  {{ old('condition_id', $condition->id) == $condition->id ? 'selected' : '' }}>{{ $condition->condition }}</option>
                @endforeach
            </select>
        </label>
        @error('condition_id')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <h3 class="form-wrap__title">商品名と説明</h3>
        <label class="form-wrap__label">商品名
            <input class="form-wrap__input" type="text" name="name" value="{{ old('name', $item->name ?? '') }}">
        </label>
        @error('name')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <label class="form-wrap__label">商品の説明
            <textarea class="form-wrap__textarea" name="description" cols="30" rows="5">{{ old('description', $item->description ?? '') }}</textarea>
        </label>
        @error('description')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <h3 class="form-wrap__title">販売価格</h3>
        <label class="form-wrap__label">販売価格
            <div class="input-wrap">
                <span class="input-wrap">¥</span>
                <input class="form-wrap__input input-price" type="text" id="price" name="price" value="{{ old('price', $item->price ?? '') }}">
            </div>
        </label>
        @error('price')
            <div class="form-wrap__error">{{ $message }}</div>
        @enderror

        <input type="hidden" value="{{ Auth::id() }}" name="user_id">
        <button class="form-wrap__button" type="submit" onclick="return confirm('出品しますか？')">{{ $item ? '修正する' : '出品する'}}</button>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function previewFile() {
            var preview = document.getElementById('preview-image');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            if (file) {
                reader.onloadend = function () {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }      

        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('price');

            const formatToCommaSeparated = (value) => {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            };

            if (amountInput.value) {
                amountInput.value = formatToCommaSeparated(amountInput.value);
            }

            amountInput.addEventListener('focus', function(e) {
                let value = e.target.value;
                e.target.value = value.replace(/,/g, '');
            });

            amountInput.addEventListener('blur', function(e) {
                let value = e.target.value;

                value = value.replace(/[０-９]/g, function(s) {
                    return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
                }).replace(/[^0-9]/g, '');

                e.target.value = formatToCommaSeparated(value);
            });

            document.querySelector("form").addEventListener("submit", function() {
                const priceInput = document.getElementById("price");
                priceInput.value = priceInput.value.replace(/,/g, ''); // ここでカンマを取り除く

                if (!isNaN(priceInput.value) && priceInput.value >= 1) {
                    return true; // 金額が正しい場合は送信
                } else {
                    alert("1円以上の金額を入力してください");
                    return false; // エラー時は送信しない
                }
            });
        });
    </script>
@endsection