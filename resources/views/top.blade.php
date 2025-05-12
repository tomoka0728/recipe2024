@extends('layouts.app')
@section('content')
    <x-guest-layout>

        <div id="container" class="wrapper">
            <main>
                <article>
                    <div class="ad-slider-wrapper">
                        <div class="ad-slider" id="ad-slider">
                            <div class="ad-slide">
                                <a href="{{ url('item_ranking') }}">
                                    <img src="{{ Storage::disk('s3')->url('summersail.jpg') }}" alt="">
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
                                {{-- @foreach ($popularRecipes as $recipe)
                                    <div class="slide">
                                        <a href="{{ route('recipes.show', $recipe->uuid) }}">
                                            <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="">
                                            <p class="title">{{ $recipe->title }}</p>
                                        </a>
                                    </div>
                                @endforeach --}}
                                <div class="slide">
                                    <a href="{{ route('recipes.show', ['uuid' => 'uuid-1']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">肉じゃがの黄金比レシピ</p>
                                    </a>
                                </div>
                                <div class="slide">
                                    <a href="{{ route('recipes.show', ['uuid' => 'uuid-2']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">簡単きんぴらごぼう</p>
                                    </a>
                                </div>
                                <div class="slide">
                                    <a href="{{ route('recipes.show', ['uuid' => 'uuid-3']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">ご飯がすすむ麻婆茄子</p>
                                    </a>
                                </div>
                                <div class="slide">
                                    <a href="{{ route('recipes.show', ['uuid' => 'uuid-4']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">春キャベツとツナのパスタ</p>
                                    </a>
                                </div>
                                <div class="slide">
                                    <a href="{{ route('recipes.show', ['uuid' => 'uuid-4']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">春キャベツとツナのパスタ</p>
                                    </a>
                                </div>
                                <div class="slide">
                                    <a href="{{ route('recipes.show', ['uuid' => 'uuid-4']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">春キャベツとツナのパスタ</p>
                                    </a>
                                </div>
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
                                <li><a href="{{ url('/butakoma') }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">黄金比で簡単肉じゃが</p>
                                    </a></li>
                                <li><a
                                        href="{{ route('ingredients.show', ['uuid' => '591af533-d3a8-4ebf-9c37-c35575b9a047']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">黄金比で簡単肉じゃが</p>
                                    </a></li>
                                <li><a href="{{ url('recipe_norisio') }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">黄金比で簡単肉じゃが</p>
                                    </a></li>
                            </ul>
                        </div>
                        <div class="more-wrapper">
                            @if (Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value)
                                <a href="{{ route('ranking.redirect') }}" class="more">
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
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('meat.png') }}" alt="">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="{{ url('recipe') }}">豚肉</a></p>
                                            <li>
                                                <p class="subject"><a href="#">鶏肉</a></p>
                                            <li>
                                                <p class="subject"><a href="#">牛肉</a></p>
                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">鴨肉</a></p>
                                            <li>
                                                <p class="subject"><a href="#">加工肉</a></p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('seafood.png') }}" alt="">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">鮭</a></p>
                                            <li>
                                                <p class="subject"><a href="#">さば</a></p>
                                            <li>
                                                <p class="subject"><a href="#">ぶり</a></p>

                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">鯛</a></p>
                                            <li>
                                                <p class="subject"><a href="#">はんぺん</a></p>
                                            <li>
                                                <p class="subject"><a href="#">あさり</a></p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('rice.png') }}" alt="">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">丼もの</a></p>
                                            <li>
                                                <p class="subject"><a href="#">炊き込み</a></p>
                                            <li>
                                                <p class="subject"><a href="#">炒めもの</a></p>
                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">雑炊</a></p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('noodl.png') }}" width="200px">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">パスタ</a></p>
                                            <li>
                                                <p class="subject"><a href="#">うどん</a></p>
                                            <li>
                                                <p class="subject"><a href="#">やきそば</a></p>
                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">ラーメン</a></p>
                                            <li>
                                                <p class="subject"><a href="#">フォー</a></p>
                                            <li>
                                                <p class="subject"><a href="#">ビーフン</a></p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('salad.png') }}" alt="">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">和風</a></p>
                                            <li>
                                                <p class="subject"><a href="#">中華</a></p>
                                            <li>
                                                <p class="subject"><a href="#">洋風</a></p>
                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">温かいサラダ</a></p>
                                            <li>
                                                <p class="subject"><a href="#">ポテトサラダ</a></p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('soup.png') }}" alt="">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">お味噌汁</a></p>
                                            <li>
                                                <p class="subject"><a href="#">中華</a></p>
                                            <li>
                                                <p class="subject"><a href="#">コンソメ</a></p>
                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">トマト</a></p>
                                            <li>
                                                <p class="subject"><a href="#">ポタージュ</a></p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('side.png') }}" alt="">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">ほうれん草</a></p>
                                            <li>
                                                <p class="subject"><a href="#">じゃがいも</a></p>
                                            <li>
                                                <p class="subject"><a href="#">きのこ</a></p>
                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">にんじん</a></p>
                                            <li>
                                                <p class="subject"><a href="#">小松菜</a></p>
                                            <li>
                                                <p class="subject"><a href="#">豆腐</a></p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="{{ Storage::disk('s3')->url('party.png') }}" alt="">
                                <div class="menu-m">
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">お祝い</a></p>
                                            <li>
                                                <p class="subject"><a href="#">前菜</a></p>
                                            <li>
                                                <p class="subject"><a href="#">大皿・メイン</a></p>
                                        </ul>
                                    </div>
                                    <div class="menu-s">
                                        <ul>
                                            <li>
                                                <p class="subject"><a href="#">おつまみ</a></p>
                                            <li>
                                                <p class="subject"><a href="#">お弁当</a></p>
                                        </ul>
                                    </div>
                                </div>
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
