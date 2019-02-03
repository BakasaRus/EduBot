@extends('layouts.app')

<!-- TODO: Заменить вшитые строки на локализацию -->
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Новый список рассылки</h5>
            @include('errors')
            <form action="{{ route('lists.store') }}" method="post">
                @csrf
                @include('lists.form')
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

