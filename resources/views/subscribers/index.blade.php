@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Подписчики</h4>
        </div>

        <div class="card-body p-0">
            <table class="table table-border mb-0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Создан</th>
                    <th>Изменён</th>
                    <th>Удалён</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscriber->id }}</td>
                        <td>
                            <a href="{{ route('subscribers.show', ['id' => $subscriber->id]) }}">
                                {{ $subscriber->full_name }}
                            </a>
                        </td>
                        <td>{{ $subscriber->created_at }}</td>
                        <td>{{ $subscriber->updated_at }}</td>
                        <td>{{ $subscriber->deleted_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

