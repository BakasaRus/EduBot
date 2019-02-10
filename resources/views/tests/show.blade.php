@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    {{ $test->name }} ({{ $test->is_available ? 'Доступен' : 'Недоступен' }})
                </h4>
                <div>
                    @if($test->is_available)
                        <a href="{{ route('tests.show', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-secondary" onclick="event.preventDefault(); $('#change_{{ $test->id }}').submit();">Убрать из бота</a>
                    @else
                        <a href="{{ route('tests.show', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-primary" onclick="event.preventDefault(); $('#change_{{ $test->id }}').submit();">Добавить в бота</a>
                    @endif
                    <a href="{{ route('tests.edit', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-success">Редактировать</a>
                    <a href="{{ route('tests.show', ['id' => $test->id]) }}" class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); $('#del_{{ $test->id }}').submit();">Удалить</a>
                    <form action="{{ route('tests.destroy', ['id' => $test->id]) }}" id="del_{{ $test->id }}" method="post" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                    <form action="{{ route('tests.update', ['id' => $test->id]) }}" id="change_{{ $test->id }}" method="post" style="display: none;">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="name" value="{{ $test->name }}">
                        <textarea name="description">{{ $test->description }}</textarea>
                        <input type="text" name="is_available" value="{{ (int)!($test->is_available) }}">
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h5>Описание</h5>
            <p style="white-space: pre-wrap">{{ $test->description }}</p>
        </div>
    </div>

    @include('questions.table', ['questions' => $test->questions])

    {{-- Грязный хак, без которого форма ниже заполняется последним вопросом из цикла --}}
    @php unset($question); @endphp

    <div class="card mt-3">
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

