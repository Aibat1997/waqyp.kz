@extends('layouts.app')
@section('content')
  <div class="section-rows">
    <div class="block-f">
      <p class="title-page">@lang('static.projects_archive')</p>
      <div class="row">
        <div class="col-md-8">
          <div class="input-group search-archive">
            <form action="/projects-archive" method="GET" style="display: table-footer-group;">
              <input class="form-control" type="text" name="query" placeholder="Поиск по архиву">
              <div class="input-group-btn ">
                <button class="btn btn-green" type="submit">@lang('static.search')</button>
              </div>
            </form>
          </div>
          <div class="list-projects">
            @if(count($rows['projects']))
              @foreach($rows['projects'] as $project)
                <a href="/{{$lang}}/projects/{{$project['id']}}">
                  <div class="item-project clearfix">
                    <img src="/{{$project['img']}}">
                    <div class="inf-project">
                      <p class="title3">{{$project['title_'.$lang]}}</p>
                      @php $in_project = $project->in_projects; @endphp
                      @if(count($in_project))
                        <ul>
                          @foreach($in_project as $k=>$d)
                            <li> {{$d['title_'.$lang]}}</li>
                          @endforeach
                        </ul>
                      @endif
                    </div>
                  </div>
                </a>
              @endforeach
            @endif

          </div>
          @php
            $paginator = $rows['projects'];
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