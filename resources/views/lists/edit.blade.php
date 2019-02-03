@extends('layouts.app')

<!-- TODO: Заменить вшитые строки на локализацию -->
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Редактирование списка рассылки</h5>
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

