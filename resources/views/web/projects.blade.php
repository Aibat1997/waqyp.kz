@extends('layouts.app')
@section('content')
  <div class="section-rows">
    <div class="block-f">
      <p class="title-page"><i class="icons i-light"></i>@lang('static.projects')</p>
      @if(count($rows['projects']))
        @foreach($rows['projects'] as $item)
          @if($loop->iteration % 2)
            <a href="/{{$lang}}/projects/{{$item['id']}}">
              <div class="clearfix">
                <div class="i-box">
                  <div class="text-box">
                    <p class="title-box">{{$item['title_'.$lang]}}</p>
                    <p class="font-blue">
                      @php $in_project = $item->in_projects; @endphp
                      @if(count($in_project))
                        @foreach($in_project as $k=>$d)
                          {{$d['title_'.$lang]}}
                          @if(isset($in_project[$k+1]))
                            •
                          @endif
                        @endforeach
                      @endif
                    </p>
                  </div>
                  <div class="min-box-img"><img src="/{{$item['img']}}"></div>
                </div>
              </div>
            </a>
          @else
            <a href="/{{$lang}}/projects/{{$item['id']}}">
              <div class="clearfix">
                <div class="i-box text-r">
                  <div class="text-box">
                    <p class="title-box">{{$item['title_'.$lang]}}</p>
                    <p class="font-blue">
                      @php $in_project = $item->in_projects; @endphp
                      @if(count($in_project))
                        @foreach($in_project as $k=>$d)
                          {{$d['title_'.$lang]}}
                          @if(isset($in_project[$k+1]))
                            •
                          @endif
                        @endforeach
                      @endif
                    </p>
                  </div>
                  <div class="min-box-img"><img src="/{{$item['img']}}"></div>
                </div>
              </div>
            </a>
          @endif
        @endforeach
      @endif
    </div>
  </div>
@endsection