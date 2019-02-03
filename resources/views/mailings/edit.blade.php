@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Редактирование рассылки</h4>
        </div>
        <div class="card-body">
            @include('errors')
            <form action="{{ route('mailings.update', ['id' => $mailing->id]) }}" method="post">
                @csrf
                @method('PATCH')
                @include('mailings.form')
                <button type="submit" class="btn btn-primary">Обновить</button>
            </form>
        </div>
    </div>
@endsection

