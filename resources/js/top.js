console.log("top.js loaded");
/*==================================
スライダーのためのjs
===================================*/
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('slider');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    const dotsContainer = document.getElementById('dots');

    const visibleSlides = 4;  // ここで表示する枚数を4に変更
    let currentIndex = 0;
    const totalSlides = slides.length;
    const maxIndex = totalSlides - visibleSlides;

    // ドットの作成
    for (let i = 0; i <= maxIndex; i++) {
        const dot = document.createElement('span');
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
            currentIndex = i;
            updateSlider();
        });
        dotsContainer.appendChild(dot);
    }

    const dots = dotsContainer.querySelectorAll('span');

    function updateSlider() {
        const slideWidth = slides[0].offsetWidth;
        slider.style.transform = `translateX(-${slideWidth * currentIndex}px)`;

        // ドットのアクティブ状態を更新
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[currentIndex]) {
            dots[currentIndex].classList.add('active');
        }
    }

    prevBtn.addEventListener('click', () => {
        // ループ処理、最後に達したら最初に戻る
        currentIndex = (currentIndex - 1 + (maxIndex + 1)) % (maxIndex + 1);
        updateSlider();
    });

    nextBtn.addEventListener('click', () => {
        // ループ処理、最後に達したら最初に戻る
        currentIndex = (currentIndex + 1) % (maxIndex + 1);
        updateSlider();
    });

    // 初期化
    window.addEventListener('resize', updateSlider);
    updateSlider();

    const autoplayInterval = 3000;
    setInterval(() => {
        currentIndex = (currentIndex + 1) % (maxIndex + 1);
        updateSlider();
    }, autoplayInterval);
});

/*==================================
上部広告用のスライダーのためのjs
===================================*/

document.addEventListener('DOMContentLoaded', function () {
    // 広告用スライダーの処理
    const adSlider = document.getElementById('ad-slider');
    const adSlides = document.querySelectorAll('.ad-slide');
    const adPrevBtn = document.getElementById('ad-prev');
    const adNextBtn = document.getElementById('ad-next');
    const adThumbnailsContainer = document.getElementById('ad-thumbnails');

    const adVisibleSlides = 1; // 広告用スライダーは1枚表示
    let adCurrentIndex = 0;
    const adMaxIndex = adSlides.length - adVisibleSlides;

    // サムネイルを作成
    adSlides.forEach((slide, index) => {
        const thumbnail = document.createElement('img');
        thumbnail.src = slide.querySelector('img').src;
        thumbnail.alt = 'Thumbnail';
        thumbnail.addEventListener('click', () => {
            adCurrentIndex = index;
            updateAdSlider();
        });
        adThumbnailsContainer.appendChild(thumbnail);
    });

    const adThumbnails = adThumbnailsContainer.querySelectorAll('img');

    function updateAdSlider() {
        const slideWidth = adSlides[0].offsetWidth;
        adSlider.style.transform = `translateX(-${slideWidth * adCurrentIndex}px)`;

        adThumbnails.forEach((thumb, index) => {
            thumb.classList.remove('active');
            if (index === adCurrentIndex) {
                thumb.classList.add('active');
            }
        });
    }

    // 初期化
    window.addEventListener('resize', updateAdSlider);
    updateAdSlider();

    const autoplayInterval = 5000;
    setInterval(() => {
        adCurrentIndex = (adCurrentIndex + 1) % (adMaxIndex + 1);
        updateAdSlider();
    }, autoplayInterval);
});



/*==================================
モーダル用のjs
===================================*/
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.getElementById('premiumModalTrigger');
    const modal = document.getElementById('premiumModal');
    const closeBtn = document.querySelector('.modal .close');

    if (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            modal.style.display = 'block';
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', function (e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    });
});