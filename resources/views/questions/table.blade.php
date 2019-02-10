<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Вопросы</h4>
    </div>
    <div class="card-body p-0">
        <table class="table table-border table-hover mb-0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Тест</th>
                <th>Вопрос</th>
                @isset($test)
                @else
                    <th>Правильный ответ</th>
                @endisset
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    @isset($test)
                    @else
                        <td>
                            <a href="{{ route('tests.show', ['id' => $question->test->id]) }}">
                                {{ $question->test->name }}
                            </a>
                        </td>
                    @endisset
                    <td>
                        <a href="{{ route('questions.show', ['id' => $question->id]) }}" style="white-space: pre-line">{{ $question->text }}</a>
                    </td>
                    <td>{{ $question->correct_answer }}</td>
                    <td>
                        <a href="{{ route('questions.edit', ['id' => $question->id]) }}" class="btn btn-sm btn-outline-success">Редактировать</a>
                        <a href="{{ route('questions.show', ['id' => $question->id]) }}" class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); $('#del_q_{{ $question->id }}').submit();">Удалить</a>
                        <form action="{{ route('questions.destroy', ['id' => $question->id]) }}" id="del_q_{{ $question->id }}" method="post" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>