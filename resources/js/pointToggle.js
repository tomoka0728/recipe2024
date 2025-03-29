document.addEventListener("DOMContentLoaded", function () {
    const usePointRadio = document.getElementById("use-point");
    const notUsePointRadio = document.getElementById("not-use-point");
    const pointInput = document.getElementById("point-input");

    function togglePointInput() {
        if (usePointRadio.checked) {
            pointInput.removeAttribute("disabled");
        } else {
            pointInput.setAttribute("disabled", "true");
            pointInput.value = ""; // 「利用しない」を選んだら値をクリア
        }
    }

    usePointRadio.addEventListener("change", togglePointInput);
    notUsePointRadio.addEventListener("change", togglePointInput);

    // 初期状態のチェック（ページ読み込み時）
    togglePointInput();
});
