document.addEventListener("DOMContentLoaded", function () {
    const usePointRadio = document.getElementById("use_point");
    const notUsePointRadio = document.getElementById("not_use");
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
            $('#new-address-fields').show().find('input,select').prop('disabled', false);
        } else {
            $('#new-address-fields').hide().find('input,select').prop('disabled', true);
        }
    }

    $('input[name="address_type"]').on('change', toggleAddressFields);
    toggleAddressFields();
});
