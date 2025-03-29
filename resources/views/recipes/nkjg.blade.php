@extends('layouts.app')
@section('content')
<x-guest-layout>

    <div id="container2" class="wrapper2">
        <div class="top_title">
            <h1>黄金比で簡単肉じゃが</h1>
        </div>
    </div>
    <div class="favo"><a href="" class="btn-flat-border"><i class="fas fa-star"></i>お気に入りに追加</a></div>



    <div id="container" class="wrapper">
        <main>
            <div class="comment">
                <article>
                    おふくろの味の定番！<br>
                    黄金比で覚えやすく簡単、ホクホク、味しみしみです。<br>
                    <br>
                    牛肉で作ると味わい深くコクのある仕上がり、豚肉では牛肉よりあっさり仕上がります。お好みでお試し下さい。<br>
                    新じゃがは柔らかく煮崩れしやすいので、男爵やメークインなどがおすすめです。<br>
                </article>
            </div>
            <div class="count">
                <article>
                    【所要時間：60分】
                </article>
            </div>

            <div class="follow">
                <ul class="follow-me">
                    <li><a href="https://x.com"></a></li>
                    <li><a href="https://www.facebook.com"></a></li>
                    <li><a href="/feed"></a></li>
                </ul>
            </div>

            <article>
                <h2 class="article-title">作り方</h2>
                <div class="process">
                    <div class="balloon3-right">1</div>
                    <p class="text">
                    材料の下準備をします。<br>
                    ・豚小間は食べやすいサイズに、じゃが芋とにんじんは乱切りに、玉ねぎはくし形切りにします。<br>
                    ・しらたきはさっと茹でてアク抜きをしておきましょう。<br>
                    ・インゲンも塩少々を加えた熱湯でさっと固めに茹でておきます。
                    </p>
                    <div class="box-img">
                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg1.jpg') }}" alt="">
                    </div>
                </div>
                <hr>

                <div class="process">
                    <div class="balloon3-right">2</div>
                    <p class="text">
                    鍋にサラダ油を入れ中火で熱し、豚肉を炒めていきます。<br>
                    肉の色が変わったら、じゃがいも、にんじん、玉ねぎの順に加えて炒めます。
                    </p>
                    <div class="box-img">
                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg2.jpg') }}" alt="">
                    </div>
                </div>
                <hr>

                <div class="process">
                    <div class="balloon3-right">3</div>
                    <p class="text">
                    煮汁の材料を加え、煮立ったらアクを取り除き、しらたきを加えます。<br>
                    蓋をして、中火のまま落し蓋をし10分ほど煮詰めます。
                    </p>
                    <div class="box-img">
                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg3.jpg') }}" alt="">
                    </div>
                </div>
                <hr>

                <div class="process">
                    <div class="balloon3-right">4</div>
                    <p class="text">
                    インゲンをさっと混ぜ合わせ更に10分煮詰めていきます。<br>
                    煮汁がなくなったら火を止め落し蓋をしたまま10分蒸らして完成です。
                    </p>
                    <div class="box-img">
                        <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
                    </div>
                </div>
            </article>


        </main>

        <aside id="sidebar">

            <section class="author">
            <img src="{{ Storage::disk('s3')->url('recipe/nkjg4.jpg') }}" alt="">
            </section>

            <section class="item">
                <h3 class="side-title">材料(4人前)</h3>
                <ul>
                <li><p class="subject"><a href="{{ route('butakoma') }}">豚肉こま切れ</a></p><p class="amount">400g</p></li>
                <li><p class="subject"><a href="{{ url('/jagaimo') }}">じゃがいも</a></p><p class="amount">6個</p></li>
                <li><p class="subject"><a href="#">にんじん</a></p><p class="amount">1本</p></li>
                <li><p class="subject"><a href="#">玉ねぎ</a></p><p class="amount">1個</p></li>
                <li><p class="subject"><a href="#">しらたき</a></p><p class="amount">1袋</p></li>
                <li><p class="subject"><a href="#">インゲン</a></p><p class="amount">6本程度</p></li>
                <li><p class="subject">水</a></p><p class="amount">400cc</p></li>
                <li><p class="subject">醤油・酒・砂糖・みりん</a></p><p class="amount">大4</p></li>
                <li><p class="subject">ほんだし</a></p><p class="amount">大1</p></li>

                </ul>
            </section>

            <section class="cm">
            <img src="{{ asset('img/toiawase.png') }}" alt="">
            </section>

            <section class="cm">
            <img src="{{ asset('img/cm.png') }}" alt="">
            </section>

            <section class="cm">
            <img src="{{ asset('img/cm2.png') }}" alt="">
            </section>
        </aside>
        </div>

</x-guest-layout>

@endsection
@push('styles')
    @vite(['resources/css/recipe.css'])
@endpush

@push('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endpush
