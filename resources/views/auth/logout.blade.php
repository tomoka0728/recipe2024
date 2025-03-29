@extends('layouts.app')
@section('content')

<x-guest-layout>
<div id="container" class="wrapper">
    <main>
        <div class="container">
            <p class="text">
            <br><br><br><br>
                ログアウトしました<br><br><br><br>
            </p>
            <a href="{{ url('top') }}" class="btn btn--pink btn--radius">トップページへ</a>
        </div>
    </main>
</div>
</x-guest-layout>
@endsection
