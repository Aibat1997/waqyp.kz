<!DOCTYPE html>
<html>
<head>
    <title>waqyp.kz</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('web/css/libs.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/plugins/toastify/toastify.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/main.css')}}">
    <link rel="icon" href="{{asset('web/img/icons/favicon.png')}}">
    @stack("style")
</head>
<body>
<div class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="left-head">
                    <div class="menu-i"><a class="logo" href="/{{$lang}}"><img src="/web/img/logo/logo.png"></a>
                        <span class="hidden-xs hidden-sm">
              @if(count($menu))
                                @foreach($menu as $item)
                                    @php $child = $item->child;@endphp
                                    @if(count($child))
                                        <span class="dropcollap">
                    <a href="#">{{$item['title_'.$lang]}}</a>
                        <ul class="in-menu">
                          @foreach($child as $child_item)
                                <li><a href="/{{$lang}}/{{$child_item['link']}}">{{$child_item['title_'.$lang]}}</a></li>
                            @endforeach
                        </ul>
                  </span>
                                    @else
                                        <a href="/{{$lang}}/{{$item['link']}}">{{$item['title_'.$lang]}}</a>
                                    @endif
                                @endforeach
                            @endif
            </span>
                    </div>
                    <div class="icons-social hidden-xs hidden-sm">
                        @php
                            $block = \App\Block::where('status',1)->get();
                        @endphp
                        @php $social = $block->where('id',13)->first();  @endphp
                        {!! is_null($social) ? '' :$social['desc_'.$lang] !!}
                    </div>
                </div>
                <div class="right-head">
                    <a href="{{$lang}}/search"><i class="icons ic-sr"></i></a>
                    <a class="hidden-xs" href="/{{$lang}}/want-to-help">
                        <button class="btn btn-red" type="button">
                            <img class="ic-like" src="/web/img/icons/ic-like.png">@if($lang == "en")  I want to help @elseif($lang == "ru") Хочу помочь @else Көмектескім келеді @endif
                        </button>
                    </a><span class="lang"><a @if($lang == "kk")  class="active" @endif href="/kk">Қз</a><a
                                @if($lang == "ru")  class="active" @endif  href="/ru">Ру</a><a
                                href="/en" @if($lang == "en")  class="active" @endif >En</a></span><i
                            class="icons ic-menu hidden-lg hidden-md"></i></div>
            </div>
            <div class="mob-menu hidden-md hidden-lg">
                <div class="l-menu">
                    @if(count($menu))
                        @foreach($menu as $item)
                            @php $child = $item->child;@endphp
                            @if(count($child))
                                <span class="dropcollap">
                    <a href="{{$item['link']}}">{{$item['title_'.$lang]}}</a>
                        <ul class="in-menu">
                            @foreach($child as $child_item)
                                <li><a href="/{{$lang}}/{{$child_item['link']}}">{{$child_item['title_'.$lang]}}</a></li>
                            @endforeach
                        </ul>
                  </span>
                            @else
                                <a href="/{{$lang}}/{{$item['link']}}">{{$item['title_'.$lang]}}</a>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="text-center">
                    <div class="icons-social">
                        {!! is_null($social) ? '' :$social['desc_'.$lang] !!}
                    </div>
                    <a href="help.html">
                        <button class="btn btn-red" type="button">
                            <img class="ic-like" src="/web/img/icons/ic-like.png"> @if($lang == "en")  I want to help @elseif($lang == "ru") Хочу помочь@else Көмектескім келеді @endif
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="container">
        <div class="contacts">
            <p class="title2 text-center">@lang('static.contact')</p>
            <div class="row inf-address">
                <div class="col-md-6 col-sm-4">
                    @php $address = $block->where('id',15)->first();  @endphp
                    {!! is_null($address) ? '' :$address['desc_'.$lang] !!}
                </div>
                <div class="col-md-3 col-sm-4">
                    @php $phone = $block->where('id',16)->first();  @endphp
                    {!! is_null($phone) ? '': $phone['desc_'.$lang] !!}
                </div>
                <div class="col-md-3 col-sm-4">
                    @php $email = $block->where('id',17)->first();  @endphp
                    {!! is_null($email) ? '': $email['desc_'.$lang] !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('web/js/lib.min.js')}}"></script>
<script src="{{asset('web/plugins/toastify/toastify.js')}}"></script>
<script src="{{asset('web/js/common.js')}}"></script>
@stack("script")
</body>
</html>