$(document).ready(function() {
    $('input[name="status"]').on('change', function() {
        // PHPから渡された一般会員の値と一致するかをチェック
        if ($(this).val() == generalStatusValue) {
            const confirmChange = confirm("無料会員に戻すと、現在の有料会員の特典はなくなりますが、よろしいですか？");
            
            if (!confirmChange) {
                // 「キャンセル」の場合は選択肢を戻す
                $('input[name="status"]').prop('checked', false); // ラジオボタンをリセット
                window.location.reload(); 
            }
        }
    });
});



document.addEventListener('DOMContentLoaded', function() {
    const faqButtons = document.querySelectorAll('.faq-btn');
    
    faqButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const index = button.getAttribute('data-index');
            const answer = document.getElementById('faq-answer-' + index);
            const icon = button.querySelector('.arrow-icon');
            
            // デバッグ用ログ
            console.log(answer, icon);

            // Toggle answer visibility
            answer.classList.toggle('hidden');
            console.log('Answer visibility:', answer.classList.contains('hidden'));
            
            // Toggle arrow direction
            if (answer.classList.contains('hidden')) {
                icon.classList.remove('rotate-180');
            } else {
                icon.classList.add('rotate-180');
            }
        });
    });
});
