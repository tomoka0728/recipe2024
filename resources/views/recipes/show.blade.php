@extends('layouts.app')
@section('content')
    {{-- {{ Breadcrumbs::render('recipes.show', $recipe) }} --}}
    <x-guest-layout>

        <div id="container2" class="wrapper2">
            <div class="top_title">
                <h1>{{ $recipe->title }}</h1>
            </div>
        </div>

        <div class="favo">
            <a href="" class="btn-flat-border"><i class="fas fa-star"></i>お気に入りに追加</a>
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
                            <p class="text">{!! nl2br(e($step->description)) !!}</p>
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

                <section class="cm">
                    <a href="#"><img src="{{ Storage::disk('s3')->url('cm.png') }}" alt=""></a>
                </section>

                <section class="cm">
                    <a href="#"><img src="{{ Storage::disk('s3')->url('cm2.png') }}" alt=""></a>
                </section>
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
@endpush
