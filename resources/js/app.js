import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import $ from 'jquery';  // jQueryのインポート
import { WebApi, LoadingCircle, Modal } from './common';  // 他のモジュールをインポート
import { addToCart, updatePrice } from './ingredients';  // カート関連の処理

// 初期化処理や他の設定
window.onload = (event) => {
    updatePrice();
    addToCart();
};

const modal = new Modal();  // Modalのインスタンスを作成
modal.open();  // モーダルを開く処理


document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#header-search-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const searchType = document.querySelector('input[name="search_type"]:checked').value;
        const keyword = document.querySelector('input[name="search"]').value;

        let url;
        if (searchType === 'ingredient') {
            url = new URL(window.appRoutes.ingredientIndex, window.location.origin);
        } else if (searchType === 'recipe') {
            url = new URL(window.appRoutes.recipeIndex, window.location.origin);
        } else {
            alert('検索タイプが不正です');
            return;
        }

        // 検索タイプとキーワードをURLに追加
        if (searchType) {
            url.searchParams.set('search_type', searchType);  // search_typeの追加
        }
        if (keyword) {
            url.searchParams.set('search', keyword);  // キーワードの追加
        }

        // URLに遷移
        window.location.href = url.toString();
    });
});

