@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ $list->name }}</h4>
        </div>
        <div class="card-body">
            <h5>Подписчики</h5>
            <ul>
                @foreach($list->subscribers as $subscriber)
                    <li>
                        <a href="{{ route('subscribers.show', ['id' => $subscriber->id]) }}">
                            {{ $subscriber->full_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <h5>Рассылки</h5>
            <ul>
                @foreach($list->mailings as $mailing)
                    <li>
                        <a href="{{ route('mailings.show', ['id' => $mailing->id]) }}">
                            {{ $mailing->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

