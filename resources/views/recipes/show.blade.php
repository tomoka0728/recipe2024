@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('recipes.show', $recipe) }}
    <x-guest-layout>

        <div id="container2" class="wrapper2">
            <div class="top_title">
                <h1>{{ $recipe->title }}</h1>
            </div>
        </div>

        <!-- SNS共有・印刷・ブックマークボタン -->
        <div class="recipe-actions-container">
            <div class="recipe-actions">
                <!-- SNS共有ボタン -->
                <button class="action-btn sns-btn" title="X(Twitter)で共有">
                    <i class="fab fa-x-twitter"></i>
                </button>
                <button class="action-btn sns-btn" title="Facebookで共有">
                    <i class="fab fa-facebook-f"></i>
                </button>
                <button class="action-btn sns-btn" title="LINEで共有">
                    <i class="fab fa-line"></i>
                </button>
                <button class="action-btn sns-btn" title="リンクをコピー">
                    <i class="fas fa-link"></i>
                </button>

                <!-- 印刷ボタン -->
                <button class="action-btn print-btn" title="印刷する">
                    <i class="fas fa-print"></i>
                    <span>印刷する</span>
                </button>

                <!-- ブックマークボタン -->
                @auth
                <button id="bookmark-btn"
                        data-item-type="recipe"
                        data-item-uuid="{{ $recipe->uuid }}"
                        class="action-btn bookmark-btn {{ $isBookmarked ? 'bookmarked' : '' }}"
                        title="{{ $isBookmarked ? 'ブックマーク済み' : 'ブックマークに追加' }}">
                    <i class="fas fa-bookmark"></i>
                    <span class="bookmark-text">{{ $isBookmarked ? 'ブックマーク済み' : 'ブックマークに追加' }}</span>
                </button>
                @else
                <button id="bookmark-login-btn" class="action-btn bookmark-btn" title="ブックマークに追加">
                    <i class="fas fa-bookmark"></i>
                    <span>ブックマーク</span>
                </button>
                @endauth
            </div>
        </div>

        {{-- ブックマークモーダル --}}
        <div id="bookmarkModal" class="modal" style="display: none;">
            <div class="modal-content" style="padding: 30px; position: relative; text-align: center; background: #fff; border-radius: 10px; max-width: 600px; margin: 0 auto;">
                <span class="close" id="bookmarkModalClose" style="position: absolute; top: 10px; right: 15px; font-size: 28px; cursor: pointer;">&times;</span>

                <!-- アイコン -->
                <img src="{{ Storage::disk('s3')->url('premium.png') }}" alt="" style="width: 80px; height: auto; margin: 0 auto; display: block;">

                <!-- タイトル -->
                <h2 style="font-size: 28px; color: #d4af37; font-weight: bold; margin-bottom: 20px;">プレミアム会員限定</h2>

                <!-- 比較表 -->
                <table style="width: 100%; font-size: 16px; border-collapse: collapse; margin-bottom: 30px;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 12px;">　</th>
                            <th style="padding: 12px;">無料</th>
                            <th style="background-color: #fffae7; padding: 12px;">シルバー</th>
                            <th style="background-color: #fffae7; padding: 12px;">ゴールド</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="text-align: left; padding: 12px;">すべてのレシピ閲覧</td>
                            <td><i class="fa-solid fa-check" style="color: #a0a0a0;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-check" style="color: #d4af37;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-check" style="color: #d4af37;"></i></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="text-align: left; padding: 12px;">広告なし</td>
                            <td><i class="fa-solid fa-xmark" style="color: #a0a0a0;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-check" style="color: #d4af37;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-check" style="color: #d4af37;"></i></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="text-align: left; padding: 12px;">人気ランキング</td>
                            <td><i class="fa-solid fa-xmark" style="color: #a0a0a0;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-check" style="color: #d4af37;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-check" style="color: #d4af37;"></i></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="text-align: left; padding: 12px;">ブックマーク保存数</td>
                            <td style="color: #a0a0a0;">10件</td>
                            <td style="background-color: #fffae7; color: #a0a0a0;">50件</td>
                            <td style="background-color: #fffae7; color: #d4af37;">100件</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="text-align: left; padding: 12px;">ポイント還元率</td>
                            <td style="color: #a0a0a0;">1%</td>
                            <td style="background-color: #fffae7; color: #a0a0a0;">3%</td>
                            <td style="background-color: #fffae7; color: #d4af37;">5%</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="text-align: left; padding: 12px;">レシピ登録</td>
                            <td><i class="fa-solid fa-xmark" style="color: #a0a0a0;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-xmark" style="color: #a0a0a0;"></i></td>
                            <td style="background-color: #fffae7;"><i class="fa-solid fa-check" style="color: #d4af37;"></i></td>
                        </tr>
                    </tbody>
                </table>

                <!-- 登録ボタン -->
                @guest
                    <a href="{{ route('register') }}" class="btn" style="background-color: #d4af37; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                        まずは会員登録から
                    </a>
                @else
                    <a href="{{ route('membership.edit') }}" class="btn" style="background-color: #d4af37; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                        有料会員に登録する
                    </a>
                @endguest
            </div>
        </div>

        <div id="container" class="wrapper">
            <main>
                <div class="comment">
                    <article>
                        {!! nl2br(e($recipe->description)) !!}
                    </article>
                </div>
                <div class="count">
                    <article>
                        【所要時間：{{ $recipe->cooking_time }}分】
                    </article>
                </div>

                <article>
                    <h2 class="article-title">作り方</h2>
                    @foreach ($recipe->steps as $step)
                        <div class="process">
                            <div class="balloon3-right">{{ $step->step_number }}</div>
                            <p class="text">{!! nl2br(e(str_replace('\n', "\n", $step->description))) !!}</p>
                            @if ($step->image_path)
                                <div class="box-img">
                                    <img src="{{ Storage::disk('s3')->url($step->image_path) }}" alt="">
                                </div>
                            @endif
                        </div>
                        <hr>
                    @endforeach
                </article>
            </main>
            <aside id="sidebar">
                <section class="author">
                    <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="">
                </section>

                <section class="item">
                    <h3 class="side-title">材料(4人前)</h3>
                    <ul>
                        @foreach ($recipe->recipeIngredients as $ingredient)
                            <li>
                                {{-- DBに存在する場合はリンクを表示 --}}
                                {{-- @if ($ingredient->ingredient && $ingredient->ingredient->exists_in_db) --}}
                                {{-- 上記をやめてDB上で値段が1円以上のものにする※未販売のものも一応DBに登録しているため --}}
                                @if ($ingredient->ingredient->price > 0)
                                    <p class="subject">
                                        <a href="{{ route('ingredients.show', ['uuid' => $ingredient->ingredient->uuid]) }}"
                                            class="ingredient-link">
                                            {{ $ingredient->ingredient->name }}
                                        </a>
                                    </p>
                                @else
                                    {{-- DBに存在しない場合はリンクなしでグレー文字 --}}
                                    <p class="subject">
                                        <span
                                            class="ingredient-not-available">{{ $ingredient->ingredient->name ?? '不明な材料' }}</span>
                                    </p>
                                @endif
                                <p class="amount">{{ $ingredient->quantity }}{{ $ingredient->unit }}</p>
                            </li>
                        @endforeach
                    </ul>
                </section>
                <section class="cm">
                    <a href="{{ url('/form') }}"><img src="{{ Storage::disk('s3')->url('toiawase.png') }}"
                            alt=""></a>
                </section>

                @if (!(Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value))
                    <section class="cm">
                        <a href="#"><img src="{{ Storage::disk('s3')->url('cm.png') }}" alt=""></a>
                    </section>

                    <section class="cm">
                        <a href="#"><img src="{{ Storage::disk('s3')->url('cm2.png') }}" alt=""></a>
                    </section>
                @endif
            </aside>
        </div>

    </x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/recipe.css'])
@endpush

@push('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
    $(document).ready(function() {
        // ブックマークボタンのクリック
        $('#bookmark-btn').click(function(e) {
            e.preventDefault();
            const btn = $(this);
            const itemType = btn.data('item-type');
            const itemUuid = btn.data('item-uuid');
            const isBookmarked = btn.hasClass('bookmarked');

            const url = isBookmarked ? '{{ route("bookmarks.destroy") }}' : '{{ route("bookmarks.store") }}';
            const method = isBookmarked ? 'DELETE' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    item_type: itemType,
                    item_uuid: itemUuid,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (isBookmarked) {
                        btn.removeClass('bookmarked');
                        btn.find('.bookmark-text').text('ブックマークに追加');
                    } else {
                        btn.addClass('bookmarked');
                        btn.find('.bookmark-text').text('ブックマーク済み');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 400 && xhr.responseJSON?.limit_exceeded) {
                        // 上限超過時はモーダルを表示
                        $('#bookmarkModal').fadeIn();
                    } else {
                        alert(xhr.responseJSON?.message || 'エラーが発生しました');
                    }
                }
            });
        });

        // ログインしていないユーザーがブックマークボタンをクリック
        $('#bookmark-login-btn').click(function(e) {
            e.preventDefault();
            $('#bookmarkModal').fadeIn();
        });

        // モーダルを閉じる
        $('#bookmarkModalClose').click(function() {
            $('#bookmarkModal').fadeOut();
        });

        // モーダル外をクリックしたら閉じる
        $('#bookmarkModal').click(function(e) {
            if (e.target.id === 'bookmarkModal') {
                $(this).fadeOut();
            }
        });
    });
    </script>

    <style>
    /* レシピアクションコンテナ */
    .recipe-actions-container {
        display: flex;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .recipe-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* アクションボタン共通 */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1rem;
        border: 1px solid #d1d5db;
        background-color: white;
        color: #374151;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
        text-decoration: none;
    }

    .action-btn:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }

    /* SNSボタン */
    .sns-btn {
        width: 2.5rem;
        height: 2.5rem;
        padding: 0;
        justify-content: center;
    }

    .sns-btn i {
        font-size: 1.125rem;
    }

    .sns-btn:nth-child(1):hover {
        background-color: #000000;
        color: white;
        border-color: #000000;
    }

    .sns-btn:nth-child(2):hover {
        background-color: #1877f2;
        color: white;
        border-color: #1877f2;
    }

    .sns-btn:nth-child(3):hover {
        background-color: #06c755;
        color: white;
        border-color: #06c755;
    }

    .sns-btn:nth-child(4):hover {
        background-color: #6366f1;
        color: white;
        border-color: #6366f1;
    }

    /* 印刷ボタン */
    .print-btn {
        font-weight: 500;
    }

    .print-btn:hover {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    /* ブックマークボタン */
    .bookmark-btn {
        font-weight: 500;
    }

    .bookmark-btn.bookmarked {
        background-color: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    .bookmark-btn.bookmarked:hover {
        background-color: #dc2626;
        border-color: #dc2626;
    }

    /* モーダル */
    .modal {
        display: none; /* デフォルトで非表示 */
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
    }

    .modal-content {
        margin: 5% auto;
    }

    /* レスポンシブ対応 */
    @media (max-width: 640px) {
        .recipe-actions {
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.813rem;
        }

        .sns-btn {
            width: 2.25rem;
            height: 2.25rem;
        }

        .sns-btn i {
            font-size: 1rem;
        }
    }
    </style>
@endpush
