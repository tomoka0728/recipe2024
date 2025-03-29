<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@vite(['resources/css/top.css'])
</head>
<body class="top-page">
<x-header />
<div id="container" class="wrapper">
    <main>
        <article>
        <a href="{{ url('item_ranking') }}"><img src="{{ asset('img/shopping.png') }}" alt=""></a>
        <div class="recipe">
            <div class="title2">
                旬の野菜レシピ特集
            </div>
            <div class="title3">
                seasonal Recipes
            </div>
            <div class="recipe2">
                <ul class="slider">
                    <li><a href="{{ url('/recipe_hakusaicyapucye') }}">
                        <img src="{{ asset('img/hakusaicyapucye.jpg') }}" alt="">
                        <p class="title">白菜チャプチェ</p></a></li>
                    <li><a href="{{ url('/recipe_kabupotohu') }}">
                        <img src="{{ asset('img/kabupotohu.jpg') }}" alt="">
                        <p class="title">かぶと鶏だんごの和風ポトフ</p></a></li>
                    <li><a href="{{ url('recipe_karihurawa') }}">
                        <img src="{{ asset('img/karihurawa-kuri-mu.jpg') }}" alt="">
                        <p class="title">カリフラワーのクリーム煮</p></a></li>
                    <li><a href="{{ url('recipe_syungiku') }}">
                        <img src="{{ asset('img/syungikuohitasi.jpg') }}" alt="">
                        <p class="title">春菊のおひたし</p></a></li>
                    <li><a href="{{ url('#') }}">
                        <img src="{{ asset('img/komatunacyuukamusi.jpg') }}" alt="">
                        <p class="title">あさりと小松菜の中華蒸し</p></a></li>
                    <li><a href="{{ url('#') }}">
                        <img src="{{ asset('img/misosiru.jpg') }}" alt="">
                        <p class="title">菜の花の具だくさん味噌汁</p></a></li>
                    <li><a href="{{ url('#') }}">
                        <img src="{{ asset('img/amazu.jpg') }}" alt="">
                        <p class="title">鶏もも肉とレンコンの甘酢炒め</p></a></li>
                    <li><a href="{{ url('#') }}">
                        <img src="{{ asset('img/hakusaima-bo-.jpg') }}" alt="">
                        <p class="title">ピリ辛麻婆白菜</p></a></li>
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
                    <li><a href="{{ url('/recipe_nkjg') }}">
                        <img src="{{ asset('img/nikujaga.jpg') }}" alt="">
                        <p class="title">黄金比で簡単肉じゃが</p></a></li>
                    <li><a href="{{ url('/recipe_ancyobipasta') }}">
                        <img src="{{ asset('img/ancyobipasta.jpg') }}" alt="">
                        <p class="title">きのこのアンチョビパスタ</p></a></li>
                    <li><a href="{{ url('recipe_norisio') }}">
                        <img src="{{ asset('img/jagaimonorisio.jpg') }}" alt="">
                        <p class="title">新じゃがのり塩バター</p></a></li>
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
                <img src="{{ asset('img/meat.png') }}" alt="">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="{{ url('recipe') }}">豚肉</a></p>
                                <li><p class="subject"><a href="#">鶏肉</a></p>
                                <li><p class="subject"><a href="#">牛肉</a></p>
                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">鴨肉</a></p>
                                <li><p class="subject"><a href="#">加工肉</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ asset('img/seafood.png') }}" alt="">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">鮭</a></p>
                                <li><p class="subject"><a href="#">さば</a></p>
                                <li><p class="subject"><a href="#">ぶり</a></p>

                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">鯛</a></p>
                                <li><p class="subject"><a href="#">はんぺん</a></p>
                                <li><p class="subject"><a href="#">あさり</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                <img src="{{ asset('img/rice.png') }}" alt="">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">丼もの</a></p>
                                <li><p class="subject"><a href="#">炊き込み</a></p>
                                <li><p class="subject"><a href="#">炒めもの</a></p>
                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">雑炊</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                <img src="{{ asset('img/noodl.png') }}" width="200px">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">パスタ</a></p>
                                <li><p class="subject"><a href="#">うどん</a></p>
                                <li><p class="subject"><a href="#">やきそば</a></p>
                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">ラーメン</a></p>
                                <li><p class="subject"><a href="#">フォー</a></p>
                                <li><p class="subject"><a href="#">ビーフン</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                <img src="{{ asset('img/salad.png') }}" alt="">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">和風</a></p>
                                <li><p class="subject"><a href="#">中華</a></p>
                                <li><p class="subject"><a href="#">洋風</a></p>
                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">温かいサラダ</a></p>
                                <li><p class="subject"><a href="#">ポテトサラダ</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                <img src="{{ asset('img/soup.png') }}" alt="">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">お味噌汁</a></p>
                                <li><p class="subject"><a href="#">中華</a></p>
                                <li><p class="subject"><a href="#">コンソメ</a></p>
                                <li><p class="subject"><a href="#">トマト</a></p>
                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">トマト</a></p>
                                <li><p class="subject"><a href="#">ポタージュ</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                <img src="{{ asset('img/side.png') }}" alt="">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">ほうれん草</a></p>
                                <li><p class="subject"><a href="#">じゃがいも</a></p>
                                <li><p class="subject"><a href="#">きのこ</a></p>
                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">にんじん</a></p>
                                <li><p class="subject"><a href="#">小松菜</a></p>
                                <li><p class="subject"><a href="#">豆腐</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                <img src="{{ asset('img/party.png') }}" alt="">
                    <div class="menu-m">
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">お祝い</a></p>
                                <li><p class="subject"><a href="#">前菜</a></p>
                                <li><p class="subject"><a href="#">大皿・メイン</a></p>
                            </ul>
                        </div>
                        <div class="menu-s">
                            <ul>
                                <li><p class="subject"><a href="#">おつまみ</a></p>
                                <li><p class="subject"><a href="#">お弁当</a></p>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </main>
      <aside id="sidebar">
        <section class="author">
            <a href="#"><img src="{{ asset('img/silver.gif') }}" alt=""></a>
        </section>

        <section class="author">
            <a href="#"><img src="{{ asset('img/gold.png') }}" alt="">
        </section>

        <section class="author">
            <a href="{{ url('/form') }}"><img src="{{ asset('img/toiawase.png') }}" alt=""></a>
        </section>

        <section class="author">
            <a href="#"><img src="{{ asset('img/cm.png') }}" alt="">
        </section>

        <section class="author">
            <a href="#"><img src="{{ asset('img/cm2.png') }}" alt="">
        </section>
      </aside>
    </div>
<x-footer />
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!--自作のJS-->
<script src="js/top.js"></script>
</body>
</html>
