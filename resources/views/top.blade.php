@extends('layouts.app')
@section('content')
    <x-guest-layout>

        <div id="container" class="wrapper">
            <main>
                <article>
                    <div class="ad-slider-wrapper">
                        <div class="ad-slider" id="ad-slider">
                            <div class="ad-slide">
                                {{-- <a href="{{ url('item_ranking') }}"> --}}
                                    <img src="{{ Storage::disk('s3')->url('sail.png') }}" alt="">
                                </a>
                            </div>
                            <div class="ad-slide">
                                {{-- <a href="{{ url('item_ranking') }}"> --}}
                                    <img src="{{ Storage::disk('s3')->url('freeze.jpg') }}" alt="">
                                {{-- </a> --}}
                            </div>
                            <div class="ad-slide">
                                {{-- <a href="{{ url('item_ranking') }}"> --}}
                                    <img src="{{ Storage::disk('s3')->url('campaign.png') }}" alt="">
                                {{-- </a> --}}
                            </div>
                        </div>

                        <div class="ad-slider-controls">
                            <div class="ad-thumbnails" id="ad-thumbnails"></div>
                        </div>
                    </div>
                    <div class="recipe">
                        <div class="title2">
                            旬の野菜レシピ特集
                        </div>
                        <div class="title3">
                            seasonal Recipes
                        </div>
                        {{--  ここからスライダー --}}
                        <div class="slider-wrapper">
                            <div class="slider" id="slider">
                                @foreach ($seasonalRecipes as $recipe)
                                    <div class="slide">
                                        <a href="{{ route('recipes.show', ['uuid' => $recipe->uuid]) }}">
                                            <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="">
                                            <p class="title">{{ $recipe->title }}</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="slider-controls">
                                <button class="nav prev" id="prev">&#10094;</button>
                                <div class="dots" id="dots"></div>
                                <button class="nav next" id="next">&#10095;</button>
                            </div>
                        </div>
                        {{--  ここまでスライダー --}}
                        <hr class="cp_hr11" />
                    </div>
                    <div class="recipe">
                        <div class="title2">
                            人気レシピトップ３
                        </div>
                        <div class="title3">
                            Recipes Ranking
                        </div>
                        <div class="recipe3">
                            <ul class="ranking">
                                @foreach ($popularRecipes as $recipe)
                                    <li><a href="{{ route('recipes.show', $recipe->uuid) }}">
                                            <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="">
                                            <p class="title">{{ $recipe->title }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="more-wrapper">
                            @if (Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value)
                                <a href="{{ route('recipes.index', ['sort' => 'favorites']) }}" class="more">
                                    ランキングをもっと見る →
                                </a>
                            @else
                                <a href="#" class="more" id="premiumModalTrigger">
                                    ランキングをもっと見る →
                                </a>
                            @endif
                        </div>
                        <hr class="cp_hr11" />
                    </div>
                    <div class="recipe">
                        <div class="title2">
                            おすすめ特集
                        </div>
                        <div class="title3">
                            Pick Up
                        </div>
                        <div class="recipe3-grid">
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('bread.png') }}" alt="">
                            </div>
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('picnic.png') }}" alt="">
                            </div>
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('sushi.png') }}" alt="">
                            </div>
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('izakaya.png') }}" alt="">
                            </div>
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('anniversary.png') }}" alt="">
                            </div>
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('renchin.png') }}" alt="">
                            </div>
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('soup2.png') }}" alt="">
                            </div>
                            <div class="recipe-item">
                                <img src="{{ Storage::disk('s3')->url('world.png') }}" alt="">
                            </div>
                        </div>
                        <hr class="cp_hr11" />
                    </div>
                    <div class="recipe4">
                        <div class="title2">
                            カテゴリで探す
                        </div>
                        <div class="title3">
                            categories Search
                        </div>
                        <div class="recipe5">
                            @foreach ($categories as $groupName => $groupCategories)
                                @if (isset($groupImages[$groupName]))
                                    <div class="item">
                                        <img src="{{ Storage::disk('s3')->url($groupImages[$groupName]) }}" alt="{{ $groupName }}">

                                        <div class="menu-m">
                                            @php
                                                $chunks = $groupCategories->chunk(ceil($groupCategories->count() / 2));
                                            @endphp

                                            @foreach ($chunks as $chunk)
                                                <div class="menu-s">
                                                    <ul>
                                                        @foreach ($chunk as $category)
                                                            <li>
                                                                <p class="subject">
                                                                    <a href="{{ route('recipes.category', ['category' => $category->uuid]) }}">
                                                                        {{ $category->name }}
                                                                    </a>
                                                                </p>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </article>
            </main>

            {{-- ▼▼ モーダルHTML ▼▼ --}}
            <div id="premiumModal" class="modal" style="display: none;">
                <div class="modal-content" style="padding: 30px; position: relative; text-align: center; background: #fff; border-radius: 10px; max-width: 600px; margin: 0 auto;">
                    <span class="close" id="premiumModalClose" style="position: absolute; top: 10px; right: 15px; font-size: 28px; cursor: pointer;">&times;</span>

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
                                <td style="text-align: left; padding: 12px;">ポイント還元率</td>
                                <td style="color: #a0a0a0;">1%</i></td>
                                <td style="background-color: #fffae7; color: #a0a0a0;"></i>3%</td>
                                <td style="background-color: #fffae7; color: #d4af37;"></i>5%</td>
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

            {{-- ▲▲ モーダルHTMLここまで ▲▲ --}}

            <aside id="sidebar">
                <section class="author">
                    <a href="{{ route('membership.silver') }}"><img src="{{ Storage::disk('s3')->url('silver.gif') }}" alt=""></a>
                </section>

                <section class="author">
                    <a href="{{ route('membership.gold') }}"><img src="{{ Storage::disk('s3')->url('gold.png') }}" alt="">
                </section>

                <section class="author">
                    <a href="{{ url('/form') }}"><img src="{{ Storage::disk('s3')->url('toiawase.png') }}"
                            alt=""></a>
                </section>
                @if (!(Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value))
                    <section class="author">
                        <a href="#"><img src="{{ Storage::disk('s3')->url('cm.png') }}" alt="">
                    </section>

                    <section class="author">
                        <a href="#"><img src="{{ Storage::disk('s3')->url('cm2.png') }}" alt="">
                    </section>
                @endif
            </aside>
        </div>
    </x-guest-layout>
@endsection
@push('styles')
    @vite(['resources/css/top.css'])
@endpush

@push('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @vite('resources/js/top.js')
@endpush
