@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Протокол ответов ({{ $subscriber->full_name }}, тест "{{ $test->name }}")</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-border table-hover mb-0">
                <thead>
                <tr>
                    <th>ID вопроса</th>
                    <th>Вопрос</th>
                    <th>Внесённый ответ</th>
                    <th>Верный ответ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->text }}</td>
                        <td>{{ $question->results->answer }}</td>
                        <td>{{ $question->correct_answer }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

