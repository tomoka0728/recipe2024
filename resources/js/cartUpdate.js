document.addEventListener("DOMContentLoaded", function () {

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

        // 送料をHTMLから取得
        const sendPrice = shippingPriceElement ? parseFloat(shippingPriceElement.dataset.sendPrice) : 0;

        if (totalPriceElement) {
            totalPriceElement.textContent = total.toLocaleString() + "円";
        }
        if (totalSumElement) {
            totalSumElement.textContent = (total + sendPrice).toLocaleString() + "円";
        }

        // ログ出力
        console.log('Total Price:', total);
        console.log('Send Price:', sendPrice);
        console.log('Total Sum:', total + sendPrice);
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
                document.getElementById("total-sum").textContent = data.total.toLocaleString() + "円";
            } else {
                console.error('Failed to update cart');
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
        });
    }
});
