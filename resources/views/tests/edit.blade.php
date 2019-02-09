@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Редактирование теста</h4>
        </div>
        <div class="card-body">
            @include('errors')
            <form action="{{ route('tests.update', ['id' => $test->id]) }}" method="post">
                @csrf
                @method('PATCH')
                @include('tests.form')
                <button type="submit" class="btn btn-primary">Обновить</button>
            </form>
        </div>
    </div>
@endsection

