@extends('layouts.app')
@push('style')
<link rel="stylesheet" href="{{asset('web/plugins/slick/slick-theme.css')}}">
<link rel="stylesheet" href="{{asset('web/plugins/slick/slick.css')}}">
<link rel="stylesheet" href="{{asset('web/css/lightgallery.min.css')}}">
@endpush

@section('content')
    <style>
        .ya-share2__badge {
            padding: 5px;
            border-radius: 20px;
            margin-bottom: 15px;
        }
        
        .social-i a {
            padding: 0;
        }
    </style>
    <div class="social-i">
        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="//yastatic.net/share2/share.js"></script>
        <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp,telegram"></div>
    </div>
    <div class="section-rows">
        <div class="in-prods clearfix">
            <img src="/{{$rows['project']['img']}}">
            <div class="text-in-prod">
                @php
                    \Carbon\Carbon::setLocale($lang);
                @endphp
                <!--<p class="text-blue">{{\Carbon\Carbon::parse($rows['project']['created_at'])->diffForHumans()}}</p>-->
                <p class="title-box">{{$rows['project']['title_'.$lang]}}</p>
                {!! $rows['project']['desc_'.$lang] !!}
                <button class="btn btn-green2" type="button">Помочь</button>
            </div>
        </div>
    </div>
    <div class="section-rows">
        <div class="row">
            <div class="col-md-2">
                @php
                    $categories = $rows['project']->in_projects;
                @endphp
                @if(count($categories))
                    <ul class="nav tab-link">
                        @foreach($categories as $d=>$category)
                            <li @if($d == 0 ) class="active" @endif>
                                <a data-toggle="pill" href="#tab{{$category['id']}}">{{$category['title_'.$lang]}}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-8">
                <div class="tab-content">
                    @if(count($categories))
                        @foreach($categories as $d=>$category)
                            <div class="tab-pane fade in @if($d == 0 ) active @endif f-24" id="tab{{$category['id']}}">
                                <p class="title-tab">{{$category['title_'.$lang]}}</p>
                                {!! $category['desc_'.$lang] !!}
                                @if($category['is_report'])
                                    <p class="title-tab">@lang('static.report')</p>
                                    <ul class="list-file">
                                        @php
                                            $reports = $category->reports;
                                        @endphp
                                        @if(count($reports))
                                            @foreach($reports as $r)
                                                <li>
                                                    <a class="text-green"
                                                       href="/{{$lang}}/report/{{$r['id']}}">{{$r['title_'.$lang]}}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                @endif
                                @if(!is_null($category['images']))
                                    @php
                                        $images = json_decode($category['images']);
                                    @endphp
                                    @if(count($images))
                                        
                                        @php
                                            $images = json_decode($category['images']);
                                        @endphp
                                        @if(count($images))
                                            <div class="sl-bottom selector1">
                                                @foreach($images as $item)
                                                    <a href="#">
                                                        <div class="sl-item item"
                                                             data-src="/{{$item}}">
                                                            <img src="/{{$item}}" alt="">
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    @endif
                
                
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script src="{{asset('web/plugins/slick/slick.js')}}"></script>
<script>
    //  SLIDER
    $('.sl-bottom').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
        centerMode: false,
        responsive: [
            {
                breakpoint: 1190,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    centerMode: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    centerMode: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
</script>
<script src="{{asset('web/js/lightgallery.min.js')}}"></script>
<script src="{{asset('web/js/lg-fullscreen.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.selector1').lightGallery({
            selector: '.item'
        });
    });
</script>
@endpush