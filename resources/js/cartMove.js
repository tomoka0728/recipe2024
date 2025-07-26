document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("click", function (e) {
        // 「あとで買う」ボタン
        if (e.target.classList.contains("save-for-later-ajax")) {
            const button = e.target;
            const ingredientUuid = button.dataset.ingredientUuid;

            fetch(`/save-for-later/${ingredientUuid}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // カートから商品を消すとき、区切り線も正しく消す
                        const cartItem = button.closest(".cart-item");
                        if (cartItem) {
                            // 直前の<hr>を1つだけ削除
                            let prev = cartItem.previousElementSibling;
                            if (prev && prev.tagName === 'HR') {
                                prev.remove();
                            } else if (!prev) {
                                // 先頭アイテムの場合は直後の<hr>を1つだけ削除
                                let next = cartItem.nextElementSibling;
                                if (next && next.tagName === 'HR') {
                                    next.remove();
                                }
                            }
                            cartItem.remove();
                        }
                        // カート本体（.cart-items）を取得
                        const cartBox = document.querySelector('.cart-items');
                        // カートが空になったら見出しとリストを削除
                        if (cartBox && cartBox.querySelectorAll('.cart-item').length === 0) {
                            cartBox.querySelectorAll('hr').forEach(hr => hr.remove());
                            // 既に「カートが空」のメッセージがなければ新しい<p>要素を作成
                            if (!document.querySelector('.cart-empty-message')) {
                                const emptyMsg = document.createElement('p');
                                emptyMsg.className = 'cart-empty-message';
                                emptyMsg.textContent = 'カートに商品が入っていません。';
                                // カート本体の直前に挿入
                                cartBox.parentNode.insertBefore(emptyMsg, cartBox);
                            }
                            // 注文ボタンを非活性化
                            const checkoutBtn = document.getElementById('checkout-button');
                            if (checkoutBtn) {
                                if (checkoutBtn.tagName === 'BUTTON') {
                                    checkoutBtn.disabled = true;
                                    checkoutBtn.textContent = 'ご注文手続きに進む';
                                    checkoutBtn.removeAttribute('onclick');
                                } else if (checkoutBtn.tagName === 'A') {
                                    checkoutBtn.classList.add('disabled');
                                    checkoutBtn.style.pointerEvents = 'none';
                                    checkoutBtn.style.opacity = '0.5';
                                    checkoutBtn.removeAttribute('href');
                                }
                            }
                        }
                        // 合計金額0で注文手続きボタンを非活性にする
                        if (typeof updateCheckoutButton === "function") {
                            updateCheckoutButton(0);
                        }
                    }

                    // 「あとで買う」リストに商品を追加
                    let laterBox = document.querySelector(".later-box");
                    if (!laterBox) {
                        // カートリストの直後に見出しとリストを挿入
                        const cartSection = document.querySelector(".cart-items");
                        // 見出し
                        const heading = document.createElement("div");
                        heading.className = "item-in-later";
                        heading.textContent = "あとで買う";
                        // リスト本体
                        laterBox = document.createElement("div");
                        laterBox.className = "later-box";
                        if (cartSection && cartSection.parentNode) {
                            cartSection.parentNode.insertBefore(heading, cartSection.nextSibling);
                            cartSection.parentNode.insertBefore(laterBox, heading.nextSibling);
                        } else {
                            document.body.appendChild(heading);
                            document.body.appendChild(laterBox);
                        }
                    }
                    if (data.item) {
                        const existing = laterBox.querySelector(`.later-item[data-ingredient-uuid="${data.item.uuid}"]`);
                        if (existing) {
                            // 既存商品の数量を加算
                            const quantitySpan = existing.querySelector('.item-quantity');
                            if (quantitySpan) {
                                const match = quantitySpan.textContent.match(/\d+/);
                                let currentQty = match ? parseInt(match[0], 10) : 0;
                                const newQty = currentQty + data.item.quantity;
                                quantitySpan.textContent = `数量：${newQty}`;
                            }
                        } else {
                            // 新規追加
                            const html = `
                                <div class="later-item" data-ingredient-uuid="${data.item.uuid}">
                                    <div class="item-img">
                                        <a href="/ingredients/${data.item.uuid}">
                                            <img src="${data.item.image_path}" alt="商品画像">
                                        </a>
                                    </div>
                                    <div class="item-details">
                                        <div class="item-info-row">
                                            <span class="item-name">
                                                <a href="/ingredients/${data.item.uuid}">${data.item.name}</a>
                                            </span>
                                            <span class="item-price">価格：${Math.round(data.item.price)}円</span>
                                            <span class="item-quantity">数量：${data.item.quantity}</span>
                                            <div class="item-actions">
                                                <div class="save-for-later-item">
                                                    <button type="button"
                                                        class="save-for-later-delete"
                                                        data-ingredient-uuid="${data.item.uuid}">
                                                        削除
                                                    </button>
                                                </div>
                                                <button type="button"
                                                    class="move-to-cart-ajax move-back-button"
                                                    data-ingredient-uuid="${data.item.uuid}">
                                                    カートに戻す
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            laterBox.insertAdjacentHTML('beforeend', html);
                        }
                    }
                    updateSummary(data);

                    // カートバッジを更新
                    if (data.cartCount !== undefined && window.updateCartBadge) {
                        window.updateCartBadge(data.cartCount);
                    }
                })
                .catch(error => {
                    console.error('fetch error:', error);
                });
        }

        // 「カートに戻す」ボタン
        if (e.target.classList.contains("move-to-cart-ajax")) {
            const button = e.target.closest(".move-to-cart-ajax");
            if (!button) return;
            const ingredientUuid = button.dataset.ingredientUuid;
            fetch(`/move-to-cart/${ingredientUuid}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // 「あとで買う」から商品を消す
                        const laterItem = button.closest(".later-item");
                        if (laterItem) laterItem.remove();

                        // 「あとで買う」リストが空になったら見出しとリストを削除
                        let laterBox = document.querySelector('.later-box');
                        if (laterBox && laterBox.querySelectorAll('.later-item').length === 0) {
                            const heading = document.querySelector('.item-in-later');
                            if (heading) heading.remove();
                            laterBox.remove();
                        }

                        // カート側に商品を追加する
                        let cartBox = document.querySelector(".cart-items");
                        if (!cartBox) {
                            cartBox = document.createElement("div");
                            cartBox.className = "cart-items";
                            const cartHeading = document.querySelector(".item-in-cart");
                            if (cartHeading && cartHeading.parentNode) {
                                cartHeading.parentNode.insertBefore(cartBox, cartHeading.nextSibling);
                            } else {
                                const cartContent = document.querySelector(".cart-content");
                                if (cartContent) {
                                    cartContent.appendChild(cartBox);
                                } else {
                                    document.body.appendChild(cartBox);
                                }
                            }
                        }
                        const emptyMsg = document.querySelector('.cart-empty-message');
                        if (emptyMsg) emptyMsg.remove();
                        if (data.item) {
                            const existing = cartBox.querySelector(`.cart-item[data-ingredient-uuid="${data.item.uuid}"]`);
                            if (existing) {
                                // カート側はinputなのでvalueを書き換える
                                const quantityInput = existing.querySelector('input.quantity-input');
                                if (quantityInput) {
                                    quantityInput.value = parseInt(quantityInput.value, 10) + data.item.quantity;
                                }
                            } else {
                                // 既存のカートアイテム数を取得
                                const cartItems = cartBox.querySelectorAll('.cart-item');
                                let html = `
                                    <div class="cart-item" data-ingredient-uuid="${data.item.uuid}">
                                        <div class="item-img">
                                            <a href="/ingredients/${data.item.uuid}">
                                                <img src="${data.item.image_path}" alt="商品画像">
                                            </a>
                                        </div>
                                        <div class="item-details">
                                            <div class="item-info-row">
                                                <span class="item-name">
                                                    <a href="/ingredients/${data.item.uuid}">${data.item.name}</a>
                                                </span>
                                                <span class="item-price">価格：${Math.round(data.item.price)}円</span>
                                                <span class="item-quantity">
                                                    数量
                                                    <input type="number" name="quantity[${data.item.uuid}]"
                                                        value="${data.item.quantity}"
                                                        min="1" class="quantity-input"
                                                        data-price="${data.item.price}"
                                                        data-ingredient-uuid="${data.item.uuid}" />
                                                </span>
                                                <div class="item-actions">
                                                    <button type="button"
                                                        class="remove-button remove-cart-item"
                                                        data-ingredient-uuid="${data.item.uuid}">
                                                        削除
                                                    </button>
                                                    <button type="button"
                                                        class="save-for-later-ajax save-button"
                                                        data-ingredient-uuid="${data.item.uuid}">
                                                        あとで買う
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;

                                // 既存アイテムが1つ以上ある場合、直前のカートアイテムの後ろに<hr>を追加
                                if (cartItems.length > 0) {
                                    cartItems[cartItems.length - 1].insertAdjacentHTML('afterend', '<hr>');
                                }
                                cartBox.insertAdjacentHTML('beforeend', html);
                            }
                        }
                        updateSummary(data);

                        // カートバッジを更新
                        if (data.cartCount !== undefined && window.updateCartBadge) {
                            window.updateCartBadge(data.cartCount);
                        }

                        // ボタンのテキストと状態も更新
                        const checkoutBtn = document.getElementById('checkout-button');
                        if (checkoutBtn && data.sum > 0) {
                            if (checkoutBtn.tagName === 'BUTTON') {
                                checkoutBtn.textContent = 'ご注文手続きに進む';
                            }
                        }
                    } else {
                        alert(data.message || "移動に失敗しました");
                    }
                })
                .catch(error => {
                    console.error('fetch error:', error);
                });
        }
    });

    // 合計金額などを更新する関数
    function updateSummary(data) {
        if (typeof data.sum !== "undefined") {
            const totalPrice = document.getElementById("total-price");
            if (totalPrice) totalPrice.textContent = data.sum.toLocaleString() + "円";
        }
        if (typeof data.tax !== "undefined") {
            const taxPrice = document.getElementById("tax-price");
            if (taxPrice) taxPrice.textContent = data.tax.toLocaleString() + "円";
        }
        if (typeof data.sendPrice !== "undefined") {
            const shippingPrice = document.getElementById("shipping-price");
            if (shippingPrice) {
                shippingPrice.textContent = data.sendPrice.toLocaleString() + "円";
                shippingPrice.dataset.sendPrice = data.sendPrice;
            }
        }
        if (typeof data.total !== "undefined") {
            const totalSum = document.getElementById("total-sum");
            if (totalSum) totalSum.textContent = data.total.toLocaleString() + "円";
        }
        if (typeof updateCheckoutButton === "function" && typeof data.sum !== "undefined") {
            updateCheckoutButton(data.sum);
        }
    }
    function updateCheckoutButton(sum) {
        const checkoutBtn = document.getElementById('checkout-button');
        if (checkoutBtn) {
            if (checkoutBtn.tagName === 'A') {
                if (sum === 0) {
                    checkoutBtn.classList.add('disabled');
                    checkoutBtn.setAttribute('aria-disabled', 'true');
                    checkoutBtn.style.pointerEvents = 'none';
                    checkoutBtn.style.opacity = '0.5';
                    checkoutBtn.removeAttribute('href');
                } else {
                    checkoutBtn.classList.remove('disabled');
                    checkoutBtn.removeAttribute('aria-disabled');
                    checkoutBtn.style.pointerEvents = '';
                    checkoutBtn.style.opacity = '';
                    if (!checkoutBtn.getAttribute('href')) {
                        checkoutBtn.setAttribute('href', '/payment');
                    }
                }
            } else {
                if (sum === 0) {
                    checkoutBtn.disabled = true;
                    checkoutBtn.removeAttribute('onclick');
                } else {
                    checkoutBtn.disabled = false;
                    if (!checkoutBtn.getAttribute('onclick')) {
                        checkoutBtn.setAttribute('onclick', "location.href='/payment'");
                    }
                }
            }
        }
    }
});
