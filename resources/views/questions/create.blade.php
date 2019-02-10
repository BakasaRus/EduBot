@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Новый вопрос</h4>
        </div>
        <div class="card-body">
            @include('errors')
            <form action="{{ route('questions.store') }}" method="post">
                @csrf
                @include('questions.form')
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

