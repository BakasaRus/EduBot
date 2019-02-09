@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    {{ $test->name }} ({{ $test->is_available ? 'Доступен' : 'Недоступен' }})
                </h4>
                <div>
                    <a href="{{ route('questions.create') }}" class="btn btn-primary btn-sm">Новый вопрос</a>
                    <a href="{{ route('tests.edit', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-success">Редактировать</a>
                    <a href="{{ route('tests.show', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); $('#del_{{ $test->id }}').submit();">Удалить</a>
                    <form action="{{ route('tests.destroy', ['id' => $test->id]) }}" id="del_{{ $test->id }}" method="post" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h5>Описание</h5>
            <p>{!! $test->description !!}</p>
            <h5>Вопросы</h5>
        </div>
        <table class="table table-border table-hover mb-0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Вопрос</th>
                <th>Правильный ответ</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($test->questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->text }}</td>
                    <td>{{ $question->correct_answer }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

