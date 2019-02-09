@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Тесты</h4>
                <a href="{{ route('tests.create') }}" class="btn btn-primary btn-sm">Новый тест</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-border table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Количество вопросов</th>
                        <th>Доступность</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tests as $test)
                    <tr>
                        <td>{{ $test->id }}</td>
                        <td>
                            <a href="{{ route('tests.show', ['id' => $test->id]) }}">
                                {{ $test->name }}
                            </a>
                        </td>
                        <td>{{ $test->questions_count }}</td>
                        <td>{{ $test->is_available ? 'Да' : 'Нет' }}</td>
                        <td>
                            <a href="{{ route('tests.edit', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-success">Редактировать</a>
                            <a href="{{ route('tests.show', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); $('#del_{{ $test->id }}').submit();">Удалить</a>
                            <form action="{{ route('tests.destroy', ['id' => $test->id]) }}" id="del_{{ $test->id }}" method="post" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

