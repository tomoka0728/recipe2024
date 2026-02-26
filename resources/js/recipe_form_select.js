// Select2を使った材料選択フォーム
document.addEventListener('DOMContentLoaded', function () {
    const ingredientList = document.getElementById('ingredient-list');
    const addIngredientBtn = document.getElementById('add-ingredient');

    // Select2を適用する前にオプションのHTMLを保存
    const originalSelect = document.querySelector('select[name="ingredient_uuids[]"]');
    const ingredientOptionsTemplate = originalSelect.innerHTML;

    // 既存のセレクトボックスにSelect2を適用
    $('.ingredient-select').select2({
        placeholder: '材料を選択',
        allowClear: true,
        width: 'resolve'
    });

    // 材料の追加処理
    addIngredientBtn.addEventListener('click', () => {
        const newItem = document.createElement('div');
        newItem.classList.add('flex', 'items-center', 'justify-around', 'mb-2', 'ingredient-item');

        newItem.innerHTML = `
            <select name="ingredient_uuids[]"
                class="ingredient-select mr-2 w-64 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                required>
                ${ingredientOptionsTemplate}
            </select>
            <input type="text" name="quantities[]" class="mr-2 w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" placeholder="分量" required>
            <input type="text" name="units[]" class="mr-2 w-28 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" placeholder="単位">
            <button type="button" class="remove-ingredient text-red-600 text-sm hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none">削除</button>
        `;

        ingredientList.appendChild(newItem);

        // 新しく追加したセレクトボックスにSelect2を適用
        $(newItem).find('.ingredient-select').select2({
            placeholder: '材料を選択',
            allowClear: true,
            width: 'resolve'
        });
    });

    // 材料の削除処理
    ingredientList.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-ingredient')) {
            const item = e.target.closest('.ingredient-item');
            // Select2を破棄してから要素を削除
            $(item).find('.ingredient-select').select2('destroy');
            item.remove();
        }
    });
});


// 手順の追加・削除処理
document.addEventListener('DOMContentLoaded', () => {
    const stepsContainer = document.getElementById('steps-container');
    const addStepButton = document.getElementById('add-step');

    addStepButton.addEventListener('click', () => {
        const stepItems = stepsContainer.querySelectorAll('.step-item');
        const stepCount = stepItems.length;

        // 現在の最大ステップ番号 + 1
        const nextStepNumber = stepCount + 1;

        const stepHtml = `
            <div class="step-item mb-4 p-4 border border-gray-300 rounded-md relative">
                <input type="hidden" name="step_uuids[]" value="">

                <p class="text-sm text-gray-500 mb-2">ステップ ${nextStepNumber}</p>

                <textarea name="step_descriptions[]" rows="3" placeholder="説明"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm mb-2"
                    required></textarea>

                <input type="file" name="step_images[]" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                <button type="button"
                    class="remove-step text-red-600 text-sm hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none hover:underline  absolute top-2 right-2">削除</button>
            </div>
        `;

        stepsContainer.insertAdjacentHTML('beforeend', stepHtml);
    });

    stepsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-step')) {
            e.target.closest('.step-item').remove();
        }
    });
});
