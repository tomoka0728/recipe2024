@extends('layouts.app')
@section('content')
    <x-guest-layout>
        <div id="container" class="wrapper">
            <main>
                <article>
                    <div class="recipe">
                        <div class="title2">
                            特集一覧
                        </div>
                        <div class="title3">
                            Featured Topics
                        </div>
                        <div class="recipe3-grid">
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('bread.png') }}" alt="Bread">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('picnic.png') }}" alt="Picnic">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('sushi.png') }}" alt="Sushi">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('izakaya.png') }}" alt="Izakaya">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('anniversary.png') }}" alt="Anniversary">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('renchin.png') }}" alt="Renchin">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('soup2.png') }}" alt="Soup">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('world.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('breakfast.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('sutamina.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('jitan.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('kouji.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('Hamburg.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('gattsuri.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('jaga.png') }}" alt="World">
                                </a>
                            </div>
                            <div class="recipe-item">
                                <a href="#">
                                    <img src="{{ Storage::disk('s3')->url('sandwich.png') }}" alt="World">
                                </a>
                            </div>
                        </div>
                        @if (!(Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value))
                            <div class="cm2">
                                <img src="{{ Storage::disk('s3')->url('cm3.png') }}" alt="cm3">
                                <img src="{{ Storage::disk('s3')->url('cm5.png') }}" alt="cm5">
                            </div>
                        @endif
                    </div>
                </article>
            </main>
        </div>
    </x-guest-layout>
@endsection
@push('styles')
    @vite(['resources/css/top.css'])
@endpush
