@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ $list->name }}</h4>
        </div>
        <div class="card-body">
            <h5>Подписчики</h5>
            <p>{!! $list->subscribers->implode('id', '<br>') !!}</p>
            <h5>Рассылки</h5>
            <p>{!! $list->mailings->implode('name', '<br>') !!}</p>
        </div>
    </div>
@endsection

