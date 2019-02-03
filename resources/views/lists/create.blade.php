@extends('layouts.app')

<!-- TODO: Заменить вшитые строки на локализацию -->
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Новый список рассылки</h4>
        </div>
        <div class="card-body">
            @include('errors')
            <form action="{{ route('lists.store') }}" method="post">
                @csrf
                @include('lists.form')
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

