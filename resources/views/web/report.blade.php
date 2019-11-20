@extends('layouts.app')
@section('content')
  <div class="section-rows">
    <p class="title-box">{{$rows['reports']['title_'.$lang]}}</p>
    <div class="block-f">
      @if(count($rows['reports']))
        @foreach($rows['reports']->reports as $i)
          <div class="clearfix item-otchet">
            <div class="i-box">
              <div class="text-box">
                <p class="text-green">@lang("static.sum")</p>
                <p class="title-box">{{$i['sum_'.$lang]}}</p>
                <div class="row mb-20">
                  <div class="col-md-6">
                    <p class="text-green">@lang('static.help')</p>
                    <p class="f-24">{{$i['recipient_'.$lang]}}</p>
                  </div>
                  <div class="col-md-6">
                    <p class="text-green">@lang('static.helped')</p>
                    <p class="f-24">{{$i['helped_'.$lang]}}</p>
                  </div>
                </div>
                <p class="text-green">@lang('static.purpose')</p>
                <p class="f-24">{{$i['target_'.$lang]}}</p>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
@endsection