import $ from 'jquery';

// 数量変更時に価格を更新する処理
export function updatePrice() {
    // 数量変更時のイベントリスナー
    $('.quantity-select').on('change', function() {
        const item3 = $(this).closest('.item3');  // .item3 を取得
        const quantity = parseInt($(this).val());  // 選択された数量を取得
        const price = parseFloat($(this).data('price'));  // 税抜き価格
        const taxPrice = parseFloat($(this).data('tax-price'));  // 税込み価格

        const totalPrice = price * quantity;  // 税抜き価格 × 数量
        const totalTaxPrice = taxPrice * quantity;  // 税込み価格 × 数量

        // 価格の更新
        const priceElement = item3.find('.price');
        const totalPriceElement = item3.find('.total-price-display');


        if (priceElement.length) {
            priceElement.text(numberWithCommas(totalPrice) + '円');
        }

        if (totalPriceElement.length) {
            totalPriceElement.text(numberWithCommas(totalTaxPrice) + '円');
        }
    });
}

// 数値をカンマ区切りでフォーマットする関数
function numberWithCommas(x) {
    const roundedValue = Math.floor(x);
    return roundedValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Ajaxでカートに追加する処理
export function addToCart() {
    console.log('add to cart');
    $('.into-cart').on('click', function () {
        console.log('click');
        const button = $(this);
        const form = button.closest('.item3, .all-products-item');
        const ingredientUuid = $(this).data('ingredient-id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        let quantity = $(this).data('quantity');  // ここでデフォルトで1を設定
        if (!quantity) {
            quantity = $(this).closest('.item3').find('select').val();  // 他のページでは数量選択を取得
        }

        $.ajax({
            url: "/cart/add",
            type: "POST",
            data: {
                ingredientUuid: ingredientUuid,
                num: quantity
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken,  // metaタグからCSRFトークンを取得
            },

            beforeSend: function() {
                button.prop('disabled', true);  // 二重クリック防止
            },
            success: function(response) {
                const cartPush = form.find('.cart-push, .cart-push2');

                // 他のメッセージを非表示にする
                $('.cart-push, .cart-push2').fadeOut();

                // メッセージを表示
                cartPush.fadeIn("slow", function () {
                    $(this).delay(1500).fadeOut("slow");
                });

                console.log('カートの中身:', response.carts); // 追加後のカートの中身を表示
            },
            error: function(xhr, status, error) {
                console.error("エラー発生:", xhr.responseJSON.message);
                alert("カートに追加できませんでした。" +xhr.responseJSON.message);
            },
            complete: function() {
                button.prop('disabled', false);  // ボタンを有効化
            }
        });
    });
}

//TODO: 以下の処理をコメントアウトしても動作するので、不要な処理の可能性がある
// ページ読み込み時に処理を初期化
// $(function() {
//     updatePrice();
//     addToCart();
// });