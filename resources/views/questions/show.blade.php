@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Карточка вопроса</h4>
        </div>
        <div class="card-body">
            <h5>Вопрос</h5>
            <p style="white-space: pre-wrap;">{{ $question->text }}</p>
            <h5>Правильный ответ</h5>
            <p>{{ $question->correct_answer }}</p>
        </div>
    </div>
@endsection

