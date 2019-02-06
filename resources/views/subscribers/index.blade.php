@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Подписчики</h4>
        </div>

        <div class="card-body p-0">
            <table class="table table-border table-hover mb-0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Согласие на рассылку</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscribers as $subscriber)
                    <tr>
                        <td>
                            <a href="https://vk.com/id{{ $subscriber->id }}" target="_blank">
                                {{ $subscriber->id }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('subscribers.show', ['id' => $subscriber->id]) }}">
                                {{ $subscriber->full_name }}
                            </a>
                        </td>
                        <td>
                            {{-- Тут есть смайлики, которые могут не отображаться некоторыми шрифтами --}}
                            @if($subscriber->deleted_at)
                                ❌ Нет
                            @else
                                ✔️ Да
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

