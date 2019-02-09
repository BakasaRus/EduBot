@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Новый тест</h4>
        </div>
        <div class="card-body">
            @include('errors')
            <form action="{{ route('tests.store') }}" method="post">
                @csrf
                @include('tests.form')
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

