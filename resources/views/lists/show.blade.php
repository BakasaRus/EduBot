@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $list->name }}</h4>
            <h5>Подписчики</h5>
            <p>{!! $list->subscribers->implode('id', '<br>') !!}</p>
            <h5>Рассылки</h5>
            <p>{!! $list->mailings->implode('name', '<br>') !!}</p>
        </div>
    </div>
@endsection

