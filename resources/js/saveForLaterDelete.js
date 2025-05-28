document.addEventListener("DOMContentLoaded", function () {
    // 動的追加にも対応するため、bodyにイベントデリゲーション
    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("save-for-later-delete")) {
            e.preventDefault();
            const button = e.target;
            const ingredientUuid = button.dataset.ingredientUuid;
            fetch(`/save-for-later/${ingredientUuid}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 「あとで買う」リストから該当アイテムを削除
                    const laterItem = button.closest(".later-item");
                    if (laterItem) laterItem.remove();

                    // 「あとで買う」リストが空になったら見出しとリストも削除
                    const laterBox = document.querySelector('.later-box');
                    if (laterBox && laterBox.querySelectorAll('.later-item').length === 0) {
                        const heading = document.querySelector('.item-in-later');
                        if (heading) heading.remove();
                        laterBox.remove();
                    }
                } else {
                    alert(data.message || "削除に失敗しました。");
                }
            })
            .catch(() => {
                alert("通信エラーが発生しました。");
            });
        }
    });
});