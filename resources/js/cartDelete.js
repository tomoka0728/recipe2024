document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach(form => {
        const button = form.querySelector(".remove-button");

        console.log(button); // ボタンが取得されているか確認
        console.log("削除ボタンがクリックされました"); // ボタンがクリックされたか確認

        button.addEventListener("click", function (e) {
            e.preventDefault(); // フォームの送信を防ぐ

            const ingredientUuid = form.dataset.ingredientUuid;
            console.log(`削除リクエスト送信: /cart/remove/${ingredientUuid}`);

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
                        // 削除成功時に該当の商品を画面から削除
                        form.closest(".cart-item").remove();

                        // 合計金額を更新
                        document.getElementById("total-price").textContent = data.sum.toLocaleString() + "円";
                        document.getElementById("total-sum").textContent = data.total.toLocaleString() + "円";
                    } else {
                        alert("削除に失敗しました。");
                    }
                })
                .catch(error => {
                    console.error("削除エラー:", error);
                    alert("削除中にエラーが発生しました。");
                });
        });
    });
});