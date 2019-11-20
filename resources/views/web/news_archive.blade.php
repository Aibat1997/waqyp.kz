@extends('layouts.app')
@section('content')
  <div class="section-rows">
    <div class="block-f">
      <p class="title-page">@lang('static.archive_news')</p>
      <div class="row">
        <div class="col-md-9">
          <div class="input-group search-archive">
            <form action="/news-archive" method="GET" style="display: table-footer-group;">
              <input class="form-control" name="query" type="text" placeholder="Поиск по архиву">
              <div class="input-group-btn ">
                <button class="btn btn-green" type="submit">@lang('static.search')</button>
              </div>
            </form>
          </div>
          <div class="list-projects news">
            @if(count($rows['news_archive']))
              @foreach($rows['news_archive'] as $news)
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
            @endif

          </div>
          @php
            $paginator = $rows['news_archive'];
          @endphp
          @if ($paginator->lastPage() > 1)
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li {{ ($paginator->currentPage() == 1) ? 'page-item disabled' : 'page-item' }}>
                  <a class="page-link" href="{{ $paginator->url(1) }}">
                    <img src="/web/img/icons/arrow-l.png"></a></li>
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                  <li class="{{ ($paginator->currentPage() == $i) ? 'page-item actives' : 'page-item' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{$i}}</a></li>
                @endfor

                <li
                  class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'page-item disabled' : 'page-item' }}">
                  <a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}">
                    <img src="/web/img/icons/arrow-r.png"></a></li>
              </ul>
            </nav>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection