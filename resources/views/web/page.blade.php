@extends('layouts.app')
@section('content')
  <div class="section-rows">
    <p class="title-page">{{$rows['page']['title_'.$lang]}}</p>
    <div class="row">
      <div class="col-md-8 item-box">
        {!! $rows['page']['desc_'.$lang] !!}
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        <ul class="nav tab-link">
          @php
            $categories = $rows['page']->categories;
          @endphp
          @if(count($categories))
            @foreach($categories as $d=>$category)
              <li @if($d == 0 )class="active" @endif>
                <a data-toggle="pill" href="#tab{{$category['id']}}">{{$category['title_'.$lang]}}</a>
              </li>
            @endforeach
          @endif
        </ul>
      </div>
      <div class="col-md-8">
        <div class="tab-content">
          @if(count($categories))
            @foreach($categories as $d=>$category)
              @if($category['template'] == 0)
                @php
                  $posts = $category->posts[0];
                @endphp
                <div class="tab-pane fade in active" id="tab{{$category['id']}}">
                  <p class="title-tab">{{$posts['title_'.$lang]}}</p>
                  {!! $posts['desc_'.$lang] !!}
                </div>
              @elseif($category['template'] == 1)
                @php
                  $posts = $category->posts;
                @endphp
                <div class="tab-pane fade" id="tab{{$category['id']}}">
                  <p class="title-tab">{{$category['title_'.$lang]}}</p>
                  <div class="row">
                    @if(count($posts))
                      @foreach($posts as $post)
                        <div class="col-sm-3 col-xs-6"><a href="#"><img src="/{{$post['img']}}"></a></div>
                      @endforeach
                    @endif
                  </div>
                </div>
              @elseif($category['template'] == 2)
                @php
                  $posts = $category->posts;
                @endphp
                <div class="tab-pane fade" id="tab{{$category['id']}}">
                  <p class="title-tab">{{$category['title_'.$lang]}}</p>
                  <div class="row comands">
                    @if(count($posts))
                      @foreach($posts as $post)
                        <div class="col-md-4 col-sm-4 col-xs-6">
                          <a href="#">
                            <div class="item-comands"><img src="/{{$post['img']}}">
                              <p class="name-com">{{$post['title_'.$lang]}}</p>
                              {!! $post['desc_'.$lang] !!}
                            </div>
                          </a></div>
                      @endforeach
                    @endif
                  </div>
                </div>
              @elseif($category['template'] == 3)
                @php
                  $posts = $category->posts;
                @endphp
                <div class="tab-pane fade" id="tab{{$category['id']}}">
                  <p class="title-tab">{{$category['title_'.$lang]}}</p>
                  <div class="row parners">
                    @if(count($posts))
                      @foreach($posts as $post)
                        <div class="col-sm-6"><a target="_blank" href="{{$post['link']}}"><img src="/{{$post['img']}}"></a>
                        </div>
                      @endforeach
                    @endif

                  </div>
                </div>
              @endif
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection