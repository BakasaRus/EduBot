@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Редактирование вопроса</h4>
        </div>
        <div class="card-body">
            @include('errors')
            <form action="{{ route('questions.update', ['id' => $question->id]) }}" method="post">
                @csrf
                @method('PATCH')
                @include('questions.form')
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
@endsection

