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


$(function () {
        function toggleAddressFields() {
            const selectedType = $('input[name="address_type"]:checked').val();
            if (selectedType === 'new') {
                $('#new-address-fields').show();
                $('#existing-address-select').hide();
            } else {
                $('#new-address-fields').hide();
                $('#existing-address-select').show();
            }
        }

        $('input[name="address_type"]').on('change', toggleAddressFields);

        // 初回ロード時
        toggleAddressFields();

        // 確認: フォーム送信時にconsole.logで確認
        $('form').on('submit', function () {
            console.log('送信値確認', {
                address_type: $('input[name="address_type"]:checked').val(),
                existing_address_id: $('#existing-address-select').val()
            });
        });
    });