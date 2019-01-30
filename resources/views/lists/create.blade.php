@extends('layouts.app')

<!-- TODO: Заменить вшитые строки на локализацию -->
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Новая рассылка</h5>
            <form action="{{ route('lists.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="nameId">Название</label>
                    <input type="text"
                           class="form-control" name="name" id="nameId" aria-describedby="nameHelpId" placeholder="">
                    <small id="nameHelpId" class="form-text text-muted">Введите название рассылки. Оно должно быть уникальным</small>
                </div>
                <div class="form-group">
                    <label for="subscribersId">Получатели</label>
                    <select multiple class="form-control" name="subscribers[]" aria-describedby="subscribersHelpId" id="subscribersId">
                        @foreach($subscribers as $subscriber)
                            <option value="{{ $subscriber->id }}">{{ $subscriber->id }}</option>
                        @endforeach
                    </select>
                    <small id="subscribersHelpId" class="form-text text-muted">Выбирать и убирать нескольких получателей можно с помощью зажатой кнопки <kbd>Ctrl</kbd></small>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

