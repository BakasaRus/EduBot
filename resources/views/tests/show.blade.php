@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">
                {{ $test->name }} ({{ $test->is_available ? 'Доступен' : 'Недоступен' }})
            </h4>
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

