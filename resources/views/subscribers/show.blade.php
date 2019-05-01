@extends('layouts.app')

@section('content')
    <div class="card mb-3">
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
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Тесты пользователя</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-border table-hover mb-0">
                <thead>
                <tr>
                    <th>Тест</th>
                    <th>Потрачено попыток</th>
                    <th>Набранные баллы</th>
                    <th>Время старта последней попытки</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($subscriber->tests as $test)
                        <tr>
                            <td>{{ $test->name }}</td>
                            <td>{{ $test->info->attempts }} из {{ $test->max_attempts }}</td>
                            <td>{{ $test->info->points }} из {{ $test->info->max_points }}</td>
                            <td>{{ $test->info->started_at }}</td>
                            <td>
                                <a href="{{ route('tests.results.index', [$subscriber, $test]) }}" class="btn btn-sm btn-outline-primary">Просмотреть попытку</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Сбросить попытки</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

