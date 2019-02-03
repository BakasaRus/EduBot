@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $subscriber->full_name }}</h4>
                <a href="https://vk.com/id{{ $subscriber->id }}" target="_blank" class="btn btn-primary btn-sm">Открыть профиль ВК</a>
            </div>
        </div>
        <div class="card-body">
            <h5>Подписки на следующие рассылки</h5>
            <ul>
                @foreach($subscriber->lists as $list)
                    <li>
                        <a href="{{ route('lists.show', ['id' => $list->id]) }}">
                            {{ $list->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

