@extends('layouts.app')
@section('content')
  <div class="section-rows">
    <div class="block-f">
      <p class="title-page">📰 @lang("static.news")</p>
    </div>
    <div class="list-press">
      @if(count($rows['news']))
        @foreach($rows['news'] as $news)
          <a href="/{{$lang}}/news/{{$news['id']}}">
            <div class="item-press"><img src="/{{$news['img']}}">
              <div class="text-press">
                @php \Carbon\Carbon::setLocale($lang); @endphp
                <p class="text-green">{{\Carbon\Carbon::parse($news['created_at'])->format('d-m-Y H:i')}}</p>
                <p class="f-24">{{$news['title_'.$lang]}}</p>
                <p class="text-grey">{{$news['sh_desc_'.$lang]}}</p>
              </div>
            </div>
          </a>
        @endforeach
      @endif
    </div>
    @php
      $paginator = $rows['news'];
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
@endsection