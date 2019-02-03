@extends('layouts.app')

<!-- TODO: Заменить вшитые строки на локализацию -->
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Редактирование списка рассылки</h4>
        </div>
        <div class="card-body">
            @include('errors')
            <form action="{{ route('lists.update', ['id' => $list->id]) }}" method="post">
                @csrf
                @method('PATCH')
                @include('lists.form')
                <button type="submit" class="btn btn-primary">Обновить</button>
            </form>
        </div>
    </div>
@endsection

