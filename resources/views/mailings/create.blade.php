@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Новая рассылка</h5>
            @include('errors')
            <form action="{{ route('mailings.store') }}" method="post">
                @csrf
                @include('mailings.form')
                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection

