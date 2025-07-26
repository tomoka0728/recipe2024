document.addEventListener("DOMContentLoaded", function () {

        window.updateCheckoutButton = function(sum) {
        const btn = document.getElementById('checkout-button');
        if (!btn) return;
        btn.disabled = !(sum > 0);
    };

    const quantityInputs = document.querySelectorAll(".quantity-input");

    quantityInputs.forEach(input => {
        input.addEventListener("input", function () {
            updateTotalPrice(input);
            updateCartOnServer(input);
        });
    });

    function updateTotalPrice(changedInput) {
        let total = 0;
        const cartItems = document.querySelectorAll(".cart-item");

        cartItems.forEach(item => {
            const price = parseFloat(item.querySelector(".quantity-input").dataset.price);
            const quantity = parseInt(item.querySelector(".quantity-input").value) || 0;
            total += price * quantity;
        });

        // 合計金額を更新
        const totalPriceElement = document.getElementById("total-price");
        const totalSumElement = document.getElementById("total-sum");
        const shippingPriceElement = document.getElementById("shipping-price");
        const taxPriceElement = document.getElementById("tax-price");

        // 送料をHTMLから取得
        const sendPrice = shippingPriceElement ? parseFloat(shippingPriceElement.dataset.sendPrice) : 0;

        // 消費税を計算
        const tax = Math.floor(total * 0.1);

        if (totalPriceElement) {
            totalPriceElement.textContent = total.toLocaleString() + "円";
        }
        if (taxPriceElement) {
            taxPriceElement.textContent = tax.toLocaleString() + "円";
        }
        if (totalSumElement) {
            totalSumElement.textContent = (total + sendPrice + tax).toLocaleString() + "円";
        }

        // ログ出力
        console.log('Total Price:', total);
        console.log('Send Price:', sendPrice);
        console.log('Total Sum:', total + sendPrice);
        console.log('Total Sum:', total + sendPrice + tax);
    }


    // サーバーに更新された数量を送信する関数（Ajax）
    function updateCartOnServer(changedInput) {
        const ingredientUuid = changedInput.dataset.ingredientUuid;
        const quantity = changedInput.value;

        fetch('/cart/update', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                ingredientUuid: ingredientUuid,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // サーバーから返された最新の金額を更新
                document.getElementById("total-price").textContent = data.sum.toLocaleString() + "円";
                document.getElementById("shipping-price").textContent = data.sendPrice.toLocaleString() + "円";
                document.getElementById("shipping-price").dataset.sendPrice = data.sendPrice;
                document.getElementById("tax-price").textContent = data.tax.toLocaleString() + "円";
                document.getElementById("total-sum").textContent = data.total.toLocaleString() + "円";
                updateCheckoutButton(data.sum);

                // カートバッジを更新
                if (data.cartCount !== undefined && window.updateCartBadge) {
                    window.updateCartBadge(data.cartCount);
                }
            } else {
                console.error('Failed to update cart');
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
        });
    }


    document.addEventListener("DOMContentLoaded", function () {
        const usedPointsInput = document.getElementById('point-input');
        const pointUsageRadio = document.getElementById('use-point');
        const notUseRadio = document.getElementById('not-use-point');

        function recalcTotal() {
            let total = 0;
            document.querySelectorAll(".cart-item").forEach(item => {
                const price = parseFloat(item.querySelector(".quantity-input")?.dataset.price || 0);
                const quantity = parseInt(item.querySelector(".quantity-input")?.value || 0);
                total += price * quantity;
            });
            const sendPrice = parseFloat(document.getElementById("shipping-price")?.dataset.sendPrice || 0);
            const tax = Math.floor(total * 0.1);
            let usedPoints = pointUsageRadio.checked ? parseInt(usedPointsInput.value) || 0 : 0;
            const userPoints = parseInt(usedPointsInput.max) || 0;
            usedPoints = Math.min(usedPoints, userPoints, total + sendPrice + tax);

            document.getElementById("total-price").textContent = total.toLocaleString() + "円";
            document.getElementById("tax-price").textContent = tax.toLocaleString() + "円";
            document.getElementById("used-points").textContent = usedPoints > 0 ? '-' + usedPoints.toLocaleString() + "円" : '0円';
            document.getElementById("total-sum").textContent = (total + sendPrice + tax - usedPoints).toLocaleString() + "円";
        }

        if (usedPointsInput && pointUsageRadio && notUseRadio) {
            usedPointsInput.addEventListener('input', recalcTotal);
            pointUsageRadio.addEventListener('change', function() {
                usedPointsInput.disabled = !this.checked;
                recalcTotal();
            });
            notUseRadio.addEventListener('change', function() {
                usedPointsInput.disabled = true;
                recalcTotal();
            });
            // 初期状態
            usedPointsInput.disabled = !pointUsageRadio.checked;
            recalcTotal();
        }
    });
});
