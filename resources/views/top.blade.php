@extends('layouts.app')
@section('content')
    <x-guest-layout>

        <div id="container" class="wrapper">
            <main>
                <article>
                    <a href="{{ url('item_ranking') }}"><img src="{{ Storage::disk('s3')->url('sail.png') }}"
                            alt=""></a>
                    <div class="recipe">
                        <div class="title2">
                            旬の野菜レシピ特集
                        </div>
                        <div class="title3">
                            seasonal Recipes
                        </div>
                        <div class="recipe2">
                            <ul class="slider">
                                {{-- @foreach ($popularRecipes as $recipe)
                                    <li>
                                        <a href="{{ route('recipes.show', $recipe->uuid) }}">
                                            <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="">
                                            <p class="title">{{ $recipe->title }}</p>
                                        </a>
                                    </li>
                                @endforeach --}}
                                <li><a href="{{ url('/butakoma') }}">
                                    <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                    <p class="title">黄金比で簡単肉じゃが</p>
                                </a></li>
                                <li><a href="{{ route('ingredients.show', ['uuid' => '591af533-d3a8-4ebf-9c37-c35575b9a047']) }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">黄金比で簡単肉じゃが</p>
                                    </a>
                                </li>
                                <li><a href="{{ url('recipe_norisio') }}">
                                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                                        <p class="title">黄金比で簡単肉じゃが</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
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
            </main>
            <aside id="sidebar">
                <section class="author">
                    <a href="#"><img src="{{ Storage::disk('s3')->url('silver.gif') }}" alt=""></a>
                </section>

                <section class="author">
                    <a href="#"><img src="{{ Storage::disk('s3')->url('gold.png') }}" alt="">
                </section>

                <section class="author">
                    <a href="{{ url('/form') }}"><img src="{{ Storage::disk('s3')->url('toiawase.png') }}"
                            alt=""></a>
                </section>

                <section class="author">
                    <a href="#"><img src="{{ Storage::disk('s3')->url('cm.png') }}" alt="">
                </section>

                <section class="author">
                    <a href="#"><img src="{{ Storage::disk('s3')->url('cm2.png') }}" alt="">
                </section>
            </aside>
        </div>
    </x-guest-layout>
@endsection
@push('styles')
    @vite(['resources/css/top.css'])
@endpush

@push('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!--自作のJS-->
    @vite('resources/js/top.js')
@endpush
