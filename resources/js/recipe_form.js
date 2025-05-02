document.addEventListener('DOMContentLoaded', function () {
    const ingredientList = document.getElementById('ingredient-list');
    const addIngredientBtn = document.getElementById('add-ingredient');

    // 材料の追加処理
    addIngredientBtn.addEventListener('click', () => {
        const newItem = document.createElement('div');
        newItem.classList.add('flex', 'items-center', 'mb-2', 'ingredient-item');

        newItem.innerHTML = `
            <input type="hidden" name="ingredient_uuids[]" value="">
            <input type="text" name="ingredient_names[]" class="mr-2 flex-1 ingredient-name rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="材料名" required autocomplete="off">
            <div class="relative">
                <ul class="autocomplete-list absolute z-10 bg-white border border-gray-300 rounded-md shadow-md max-h-40 overflow-y-auto hidden"></ul>
            </div>
            <input type="text" name="quantities[]" class="mr-2 w-24 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="分量" required>
            <input type="text" name="units[]" class="mr-2 w-20 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="単位">
            <button type="button" class="text-red-600 text-sm remove-ingredient hover:underline">削除</button>
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
        const list = document.createElement('ul');
        list.className = 'autocomplete-list absolute z-10 bg-white border border-gray-300 rounded-md shadow-md max-h-40 overflow-y-auto hidden';
        input.parentElement.appendChild(list);

        input.addEventListener('input', async function () {
            const query = this.value.trim();
            const uuidInput = input.closest('.ingredient-item').querySelector('input[name="ingredient_uuids[]"]');

            if (query.length < 1) {
                list.classList.add('hidden');
                return;
            }

            try {
                const response = await fetch(`/admin/ingredients/search?q=${encodeURIComponent(query)}`);
                const suggestions = await response.json();

                list.innerHTML = '';
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
            if (!input.parentElement.contains(e.target)) {
                list.classList.add('hidden');
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const categoryList = document.getElementById('category-list');
    const categorySelect = document.getElementById('categories');
    const selectedCategories = [];

    // 画面表示時にすでに選択されているカテゴリをUIに表示
    const initiallySelected = Array.from(categorySelect.selectedOptions);
    initiallySelected.forEach(option => {
        const uuid = option.value;
        const name = option.textContent;

        if (!selectedCategories.includes(uuid)) {
            selectedCategories.push(uuid);
            addCategoryToUI(name, uuid);
        }
    });

    // カテゴリの選択処理
    categorySelect.addEventListener('change', function () {
        const selectedOptions = Array.from(categorySelect.selectedOptions);
        selectedOptions.forEach(option => {
            const categoryUuid = option.value;
            const categoryName = option.textContent;

            if (!selectedCategories.includes(categoryUuid)) {
                selectedCategories.push(categoryUuid);
                addCategoryToUI(categoryName, categoryUuid);
            }
        });
    });

    // 選択されたカテゴリの背景色を更新
    updateCategoryStyles();

    // 選択されたカテゴリの背景色を更新する関数
    function updateCategoryStyles() {
        Array.from(categorySelect.options).forEach(option => {
            if (option.selected) {
                option.style.backgroundColor = '#d1d5db'; // グレーの背景色
            } else {
                option.style.backgroundColor = ''; // 背景色をリセット
            }
        });
    }

    // 初期状態で選択されたカテゴリに背景色を適用
    updateCategoryStyles();

    // カテゴリをUIに追加する処理
    function addCategoryToUI(name, uuid) {
        const tag = document.createElement('div');
        tag.className = 'inline-flex items-center text-sm font-medium mr-2 mb-2';
        tag.style.color = '#000';
        tag.style.padding = '0.4rem 0.75rem';
        tag.style.borderRadius = '9999px';
        tag.style.border = '1px solid #F97316';
        tag.style.gap = '0.5rem';

        const span = document.createElement('span');
        span.textContent = name;
        tag.appendChild(span);

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.innerHTML = '&times;';
        removeBtn.style.color = '#EA580C';
        removeBtn.style.display = 'flex';
        removeBtn.style.alignItems = 'center';
        removeBtn.style.justifyContent = 'center';
        removeBtn.style.background = 'transparent';
        removeBtn.style.border = 'none';
        removeBtn.style.padding = '0';
        removeBtn.style.cursor = 'pointer';
        removeBtn.style.fontSize = '1.2rem';
        removeBtn.style.lineHeight = '1';
        removeBtn.style.transition = 'transform 0.2s ease';

        // Hover時にボタンを拡大する効果
        removeBtn.addEventListener('mouseenter', () => {
            removeBtn.style.transform = 'scale(1.3)';
        });
        removeBtn.addEventListener('mouseleave', () => {
            removeBtn.style.transform = 'scale(1)';
        });

        // クリック時に削除処理
        removeBtn.addEventListener('click', () => {
            tag.remove();
            selectedCategories.splice(selectedCategories.indexOf(uuid), 1);
            const optionToUnselect = categorySelect.querySelector(`option[value="${uuid}"]`);
            if (optionToUnselect) {
                optionToUnselect.selected = false;
            }

            // 背景色を更新
            updateCategoryStyles();
        });

        tag.appendChild(removeBtn);
        categoryList.appendChild(tag);
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
