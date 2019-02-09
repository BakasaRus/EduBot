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
                <div class="form-group">
                    <label for="nameId">Название</label>
                    <input type="text"
                           class="form-control" name="name" id="nameId" aria-describedby="nameHelpId" placeholder="">
                    <small id="nameHelpId" class="form-text text-muted">Название теста должно быть уникальным</small>
                </div>
                <div class="form-group">
                    <label for="descriptionId">Описание</label>
                    <textarea class="form-control" name="description" id="descriptionId" aria-describedby="descriptionHelpId" rows="3"></textarea>
                    <small id="descriptionHelpId" class="form-text text-muted">Описание должно пояснять смысл теста, так как оно будет отображаться в боте вместе с названием</small>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="is_available" id="isAvailableId" value="checkedValue">
                        Доступен для прохождения
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

