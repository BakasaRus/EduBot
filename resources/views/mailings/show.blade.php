@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $mailing->name }}</h4>
            <h5>Текст</h5>
            <p>{!! $mailing->text !!}</p>
            <h5>Прикрепления</h5>
            <p>{{ $mailing->attachments ?? "Отсутствуют" }}</p>
            <h5>Время рассылки</h5>
            <p>{{ $mailing->send_at ?? "Не задано" }}</p>
        </div>
    </div>
@endsection

