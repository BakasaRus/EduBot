@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Редактирование рассылки</h5>
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

