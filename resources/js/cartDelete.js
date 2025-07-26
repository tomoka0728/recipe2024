document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-button") && e.target.classList.contains("remove-cart-item")) {
            e.preventDefault();
            const button = e.target;
            const ingredientUuid = button.dataset.ingredientUuid;
            fetch(`/cart/remove/${ingredientUuid}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json",
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 区切り線も正しく消す
                    const cartItem = button.closest(".cart-item");
                    if (cartItem) {
                        let prev = cartItem.previousElementSibling;
                        if (prev && prev.tagName === 'HR') {
                            prev.remove();
                        } else if (!prev) {
                            let next = cartItem.nextElementSibling;
                            if (next && next.tagName === 'HR') {
                                next.remove();
                            }
                        }
                        cartItem.remove();
                    }

                    // カートが空になった場合の処理
                    const cartBox = document.querySelector('.cart-items');
                    if (cartBox && cartBox.querySelectorAll('.cart-item').length === 0) {
                        // 商品リストを非表示または削除
                        cartBox.remove();
                        // 「カートが空」メッセージを表示
                        if (!document.querySelector('.cart-empty-message')) {
                            const emptyMsg = document.createElement('p');
                            emptyMsg.className = 'cart-empty-message';
                            emptyMsg.textContent = 'カートに商品が入っていません。';
                            const itemInCart = document.querySelector('.item-in-cart');
                            if (itemInCart && itemInCart.parentNode) {
                                itemInCart.parentNode.insertBefore(emptyMsg, itemInCart.nextSibling);
                            } else {
                                document.querySelector('.cart-content').prepend(emptyMsg);
                            }
                        }
                        // 注文ボタンを非活性化
                        const checkoutBtn = document.getElementById('checkout-button');
                        if (checkoutBtn) {
                            if (checkoutBtn.tagName === 'A') {
                                // aタグの場合は無効化
                                checkoutBtn.classList.add('disabled');
                                checkoutBtn.setAttribute('aria-disabled', 'true');
                                checkoutBtn.style.pointerEvents = 'none';
                                checkoutBtn.style.opacity = '0.5';
                            } else {
                                // ボタンの場合はdisabled
                                checkoutBtn.disabled = true;
                            }
                        }
                    }

                    // ここで各種金額を更新
                    document.getElementById("total-price").textContent = data.sum.toLocaleString() + "円";
                    document.getElementById("tax-price").textContent = data.tax.toLocaleString() + "円";
                    document.getElementById("shipping-price").textContent = data.sendPrice.toLocaleString() + "円";
                    document.getElementById("total-sum").textContent = data.total.toLocaleString() + "円";

                    // カートバッジを更新
                    if (data.cartCount !== undefined && window.updateCartBadge) {
                        window.updateCartBadge(data.cartCount);
                    }
                } else {
                    alert("削除に失敗しました。");
                }
            })
            .catch(error => {
                console.error(error);
                alert("削除中にエラーが発生しました。");
            });
        }
    });
});
