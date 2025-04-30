import { showAlert, toggleLoading } from './common';

document.addEventListener('DOMContentLoaded', () => {
    console.log('Admin dashboard scripts loaded.');

    // フラッシュメッセージの自動非表示
    const flashMessage = document.querySelector('.flash-message');
    if (flashMessage) {
        setTimeout(() => {
            flashMessage.style.opacity = '0';
            setTimeout(() => flashMessage.remove(), 500);
        }, 3000);
    }

    // 削除ボタンの確認ダイアログ
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const confirmDelete = confirm('本当に削除しますか？');
            if (!confirmDelete) {
                e.preventDefault();
            }
        });
    });

    // ローディングサークルの表示例
    const loadButton = document.querySelector('#load-data');
    if (loadButton) {
        loadButton.addEventListener('click', () => {
            toggleLoading(true);
            setTimeout(() => toggleLoading(false), 2000); // 2秒後に非表示
        });
    }
});