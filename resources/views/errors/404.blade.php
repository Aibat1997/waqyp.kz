@extends('layouts.app')
@section('content')
    <p class="word-404">404</p>
    <p class="f-24">Страница которую вы искали не существует.<span class="d-block">Попровуйте<a class="text-blue" href="{{$lang}}/search">
              <u>поискать</u></a></span></p>
@endsection