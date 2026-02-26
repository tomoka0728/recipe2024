@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('column') }}
    <x-guest-layout>
        <div id="container" class="wrapper">
            <main>
                <article>
                    <div class="column">
                        <div class="title2">
                            コラム
                        </div>
                        <div class="title3">
                            Column
                        </div>
                    </div>
                    <div class="column-content">
                        <!-- コラム1 -->
                        <article class="column-article">
                            <div class="article-thumbnail">
                                <img src="{{ Storage::disk('s3')->url('column1.png') }}"alt="">
                            </div>
                            <div class="article-text">
                                <header>
                                    <h2 class="article-title">朝ごはんが変わる！一日の始まりに必要な栄養とは？</h2>
                                    <div class="article-meta">
                                        2025年5月8日
                                        <span class="article-tag">健康</span>
                                    </div>
                                </header>
                                <div class="article-body">
                                    <p>朝食を抜くと集中力や代謝に影響が出ることをご存じですか？一日のパフォーマンスに直結する朝の栄養、見直してみましょう。</p>
                                    <p>おすすめは、タンパク質＋炭水化物＋ビタミンをバランスよく摂ること。手軽なレシピも紹介します。...</p>
                                </div>
                            </div>
                        </article>

                        <!-- コラム2 -->
                        <article class="column-article">
                            <div class="article-thumbnail">
                                <img src="{{ Storage::disk('s3')->url('column2.png') }}"alt="">
                            </div>
                            <div class="article-text">
                                <header>
                                    <h2 class="article-title">疲れやすい人必見！鉄分不足のサインと食事での補い方</h2>
                                    <div class="article-meta">
                                        2025年5月8日
                                        <span class="article-tag">健康</span>
                                    </div>
                                </header>
                                <div class="article-body">
                                    <p>立ちくらみや倦怠感が続くと感じたら、鉄分不足かもしれません。特に女性に多い栄養トラブルです。</p>
                                    <p>レバーや小松菜など、身近な食材でもしっかり補える方法をご紹介します。...</p>
                                </div>
                            </div>
                        </article>

                        <!-- コラム3 -->
                        <article class="column-article">
                            <div class="article-thumbnail">
                                <img src="{{ Storage::disk('s3')->url('column3.png') }}"alt="">
                            </div>
                            <div class="article-text">
                                <header>
                                    <h2 class="article-title">おにぎりの具から見る日本の食文化</h2>
                                    <div class="article-meta">
                                        2025年5月8日
                                        <span class="article-tag">食文化</span>
                                    </div>
                                </header>
                                <div class="article-body">
                                    <p>梅干し、昆布、ツナマヨ…おにぎりの具は地域性や家庭の味が現れる、日本ならではの食文化の象徴です。</p>
                                    <p>海外でも注目されるおにぎり文化、その背景にある歴史や意味を掘り下げてみましょう。...</p>
                                </div>
                            </div>
                        </article>
                        <!-- コラム4 -->
                        <article class="column-article">
                            <div class="article-thumbnail">
                                <img src="{{ Storage::disk('s3')->url('column4.png') }}"alt="">
                            </div>
                            <div class="article-text">
                                <header>
                                    <h2 class="article-title">料理にまつわるちょっと笑える失敗談</h2>
                                    <div class="article-meta">
                                        2025年5月8日
                                        <span class="article-tag">その他</span>
                                    </div>
                                </header>
                                <div class="article-body">
                                    <p>塩と砂糖を間違えた、お米を研がずに炊いた…誰にでもある“あるある”失敗談を集めました。</p>
                                    <p>思わず笑ってしまうけれど、次からはちょっと気をつけようと思えるエピソードばかりです。...</p>
                                </div>
                            </div>
                        </article>
                </div>
            </main>

            <aside id="sidebar">
                <section class="ranking">
                    <h3 class="side-title">カテゴリ</h3>
                    <ul>
                        <li><p class="subject">健康</a></p></li>
                        <li><p class="subject">栄養</a></p></li>
                        <li><p class="subject">食文化</a></p></li>
                        <li><p class="subject">調味料</a></p></li>
                        <li><p class="subject">アレルギー</a></p></li>
                        <li><p class="subject">ダイエット</a></p></li>
                        <li><p class="subject">保存のコツ</a></p></li>
                        <li><p class="subject">その他</a></p></li>
                    </ul>
                </section>

                <section class="cm">
                    <a href="{{ url('/form') }}"><img src="{{ Storage::disk('s3')->url('toiawase.png') }}" alt=""></a>
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
    @vite(['resources/css/ranking.css', 'resources/css/column.css'])
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    @vite('resources/js/app.js')
@endpush
