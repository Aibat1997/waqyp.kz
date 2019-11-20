@extends('layouts.app')
@section('content')
    <div class="section-rows">
        <div class="item-box">
            <div class="row">
                <div class="col-md-6">
                    <p class="title-box">{{$rows['news']['title_'.$lang]}}</p>
                </div>
                <div class="col-md-6"><img class="img-100" src="/{{$rows['news']['img']}}"></div>
            </div>
            <div class="block-f f-24">
                <div class="mb-20">
                    <p class="text-blue">{{\Carbon\Carbon::parse($rows['news']['created_at'])->diffForHumans()}}</p>
                    {!! $rows['news']['desc_'.$lang] !!}
                </div>
                <div style="display: flex">
                    <p class="f-16" style="margin-right: 20px">Поделитьcя новостью </p>
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp,telegram"></div>
                </div>
            </div>
        </div>
        <p class="title2">@lang('static.latest_news')</p>
        <div class="list-press">
            @if(count($rows['latest_news']))
                @foreach($rows['latest_news'] as $l)
                    <a href="/{{$lang}}/news/{{$l['id']}}">
                        <div class="item-press"><img src="/{{$l['img']}}">
                            <div class="text-press">
                                <p class="text-green">{{\Carbon\Carbon::parse($l['created_at'])->diffForHumans()}}</p>
                                <p class="f-24">{{$l['title_'.$lang]}}</p>
                                <p class="text-grey">{{$l['sh_dec_'.$lang]}}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection