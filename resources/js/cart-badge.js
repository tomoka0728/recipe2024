/**
 * カートバッジのリアルタイム更新機能
 */

// カートバッジを更新する関数
function updateCartBadge(count) {
    const cartBadge = document.getElementById('cart-badge');
    const cartCount = document.getElementById('cart-count');

    if (cartBadge && cartCount) {
        if (count > 0) {
            cartCount.textContent = count;
            cartBadge.classList.remove('hidden');
        } else {
            cartBadge.classList.add('hidden');
        }
    }
}

// サーバーからカート数を取得してバッジを更新
function fetchCartCount() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartBadge(data.count);
        }
    })
    .catch(error => {
        console.error('カート数の取得に失敗しました:', error);
    });
}

// カートに商品を追加した時にバッジを更新
function addToCartWithBadgeUpdate(ingredientId, quantity = 1) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ingredient_id: ingredientId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartBadge(data.cartCount);
            // 成功メッセージがあれば表示
            if (data.message) {
                // 既存の通知システムがあれば使用
                console.log(data.message);
            }
        }
    })
    .catch(error => {
        console.error('カートへの追加に失敗しました:', error);
    });
}

// カートから商品を削除した時にバッジを更新
function removeFromCartWithBadgeUpdate(ingredientId) {
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ingredient_id: ingredientId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartBadge(data.cartCount);
        }
    })
    .catch(error => {
        console.error('カートからの削除に失敗しました:', error);
    });
}

// ページ読み込み時にカート数を取得
document.addEventListener('DOMContentLoaded', function() {
    fetchCartCount();
});

// グローバルに関数を公開
window.updateCartBadge = updateCartBadge;
window.fetchCartCount = fetchCartCount;
window.addToCartWithBadgeUpdate = addToCartWithBadgeUpdate;
window.removeFromCartWithBadgeUpdate = removeFromCartWithBadgeUpdate;
