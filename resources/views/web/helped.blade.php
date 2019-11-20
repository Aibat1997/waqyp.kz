@extends('layouts.app')
@section('content')
    <div class="row section-rows text-center">
        <div class="col-md-8 col-md-offset-2">
            @if(count($errors))
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(!is_null(\Illuminate\Support\Facades\Request::session()->get('status')))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ \Illuminate\Support\Facades\Request::session()->get('status') }}</li>
                    </ul>
                </div>
            @endif
            <div class="item-box">
                <p class="title-page">❤ @lang('static.want_helped')</p>
                <div class="mb-20">
                    <input class="input-h" type="text" name="money" placeholder="@lang("static.p_want")">
                    <p>@lang("static.min_sum")</p>
                </div>
                <button class="btn btn-orange" type="button" onclick="Pay.send($(this));">@lang("static.online")</button>
            </div>
            @php
                $block = \App\Block::where('status',1)->get();
            @endphp
            <button class="btn-blue btn" type="button" data-toggle="modal" data-target="#myModal">@lang("static.val")</button>
            <div class="ab-call">
                @php
                    $fio = $block->where('id',19)->first();
                @endphp
                {!! is_null($fio) ? '' :$fio['desc_'.$lang] !!}
            </div>
        </div>
    </div>
    <div class="modal fade modal-v" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                        <img src="/web/img/icons/ic-x.png"></span>
                    </button>
                    <p class="title-modal">@lang("static.val")</p>
                </div>
                <div class="modal-body">
                    <form action="/want" method="POST">
                        {{csrf_field()}}
                        <div class="item-form">
                            <div class="text-f"><span>@lang("static.name")</span></div>
                            <div class="input-f">
                                <input class="form-control" name="first_name" type="text">
                            </div>
                        </div>
                        <div class="item-form">
                            <div class="text-f"><span>@lang("static.fio")</span></div>
                            <div class="input-f">
                                <input class="form-control" name="last_name" type="text">
                            </div>
                        </div>
                        <div class="item-form">
                            <div class="text-f"><span>@lang("static.phone")</span></div>
                            <div class="input-f">
                                <input class="form-control" name="phone" type="text">
                            </div>
                        </div>
                        <div class="item-form">
                            <div class="text-f"><span>@lang("static.email")</span></div>
                            <div class="input-f">
                                <input class="form-control" name="email" type="text">
                            </div>
                        </div>
                        <div class="item-form">
                            <div class="text-f"><span>@lang("static.about")</span></div>
                            <div class="input-f">
                                <textarea class="form-control" name="about" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="item-form">
                            <button class="send" type="submit">@lang("static.send")</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection