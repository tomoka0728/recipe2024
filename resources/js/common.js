// WebApiクラスの定義
export class WebApi {
    constructor(options) {
        this.options = options;
    }

    async call(url, method, data = {}, json = false) {
        // API呼び出し処理
        const response = await fetch(url, {
            method: method,
            body: json ? JSON.stringify(data) : data,
            headers: {
                'Content-Type': 'application/json'
            }
        });
        return await response.json();
    }
}

// LoadingCircleクラスの定義
export class LoadingCircle {
    constructor(options) {
        // ローディング円の表示に関する設定
    }

    show() {
        console.log("Loading...");
    }

    hide() {
        console.log("Loaded");
    }
}

// Modalクラスの定義（例）
export class Modal {
    constructor() {
        // Modalの初期化や設定
        console.log('Modal is ready');
    }

    open() {
        console.log('Opening Modal');
        // モーダルを開く処理
    }

    close() {
        console.log('Closing Modal');
        // モーダルを閉じる処理
    }
}

