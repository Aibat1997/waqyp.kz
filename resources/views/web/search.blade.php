@extends('layouts.app')
@section('content')
    <div class="row section-rows">
        <div class="col-md-8">
            <p class="title-page">🔍 {{trans("static.search")}}</p>
            <div class="input-group search-archive">
                <form action="/search" method="GET" style="display: table-footer-group;">
                    <input class="form-control" type="text" name="query" placeholder="Введите слово ">
                    <div class="input-group-btn ">
                        <button class="btn btn-green" type="submit">Найти</button>
                    </div>
                </form>
            </div>
            @if($rows['result']['success'])
                <div class="list-projects news">
                    @foreach($rows['result']['data'] as $news)
                        <a href="/{{$lang}}/news/{{$news['id']}}">
                            <div class="item-project clearfix"><img src="/{{$news['img']}}">
                                <div class="inf-project">
                                    <p class="text-green">{{\Carbon\Carbon::parse($news->created_at)->diffForHumans()}}</p>
                                    <p class="f-16"><b>{{$news['title_'.$lang]}}</b>
                                    </p>
                                    <p class="text-grey">{{$news['sh_desc_'.$lang]}}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p>ничего не найдено</p>
            @endif
        </div>
    </div>
@endsection