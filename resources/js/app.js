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
