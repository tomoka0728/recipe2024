// オートコンプリート機能の実装
document.addEventListener('DOMContentLoaded', function () {
    const ingredientList = document.getElementById('ingredient-list');
    const addIngredientBtn = document.getElementById('add-ingredient');
    const autoCompleteURL = document.querySelector('meta[name="autocomplete-url"]').content;

    // 材料の追加処理
    addIngredientBtn.addEventListener('click', () => {
    const newItem = document.createElement('div');
    newItem.classList.add('flex', 'items-center', 'mb-2', 'ingredient-item');

        newItem.innerHTML = `
            <input type="hidden" name="ingredient_uuids[]" value="">
            <input type="text" name="ingredient_names[]"
                    class="ingredient-name mr-2 flex-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                    placeholder="材料名" required>
            <div class="relative">
                <ul class="autocomplete-list z-10 bg-white border border-gray-300 rounded-md shadow-md max-h-50 overflow-y-auto hidden"></ul>
            </div>
            <input type="text" name="quantities[]" class="mr-2 w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" placeholder="分量" required>
            <input type="text" name="units[]" class="mr-2 w-28 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" placeholder="単位">
            <button type="button" class="remove-ingredient text-red-600 text-sm hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none">削除</button>
        `;

        ingredientList.appendChild(newItem);
        initAutocomplete(newItem.querySelector('.ingredient-name'));
    });

    // 材料の削除処理
    ingredientList.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-ingredient')) {
            e.target.closest('.ingredient-item').remove();
        }
    });

    // 既存の材料にもオートコンプリートを設定
    document.querySelectorAll('.ingredient-name').forEach(input => initAutocomplete(input));

    // オートコンプリートの初期化
    function initAutocomplete(input) {
        const list = input.closest('.ingredient-item').querySelector('.autocomplete-list');

        input.addEventListener('input', async function () {
            const query = this.value.trim();
            const uuidInput = input.closest('.ingredient-item').querySelector('input[name="ingredient_uuids[]"]');

            if (query.length < 1) {
                list.classList.add('hidden');
                return;
            }

            try {
                const url = document.querySelector('meta[name="autocomplete-url"]').content;
                const response = await fetch(ingredientSearchUrl + "?q=" + encodeURIComponent(query));
                const suggestions = await response.json();

                list.innerHTML = ''; // 古いリストをクリア

                suggestions.forEach(item => {
                    const option = document.createElement('li');
                    option.classList.add('px-3', 'py-1', 'cursor-pointer', 'hover:bg-indigo-100');
                    option.textContent = item.name;
                    option.dataset.uuid = item.uuid;

                    option.addEventListener('click', () => {
                        input.value = item.name;
                        uuidInput.value = item.uuid;
                        list.classList.add('hidden');
                    });

                    list.appendChild(option);
                });

                list.classList.remove('hidden');
            } catch (error) {
                console.error('オートコンプリートエラー:', error);
                list.classList.add('hidden');
            }
        });

        // 外部クリックで非表示
        document.addEventListener('click', (e) => {
            if (!input.closest('.ingredient-item').contains(e.target)) {
                list.classList.add('hidden');
            }
        });
    }
});


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
