@extends('layouts.app')
@section('content')
  @php
    $main_text = \App\Block::where('status',1)->where('id',14)->first();
  @endphp
  <div class="top-box">
    {!! is_null($main_text) ? '' :$main_text['desc_'.$lang] !!}
  </div>
  <div class="block-f">
    @if(count($rows['main_projects']))
      @foreach($rows['main_projects'] as $item)
        @if($loop->iteration % 2)
          <a href="">
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
          <a href="">
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
@endsection