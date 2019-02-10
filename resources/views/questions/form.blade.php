<div class="form-group">
    <label for="textId">Текст вопроса</label>
    <textarea class="form-control" name="text" id="textId" rows="3">{{ old('text') ?? $question->text ?? "" }}</textarea>
    <small id="answerHelpId" class="form-text text-muted">Задавайте вопрос так, чтобы на него был только один ответ</small>
</div>
<div class="form-group">
    <label for="correctAnswerId">Правильный ответ</label>
    <input type="text"
           class="form-control" name="correct_answer" id="correctAnswerId"
           aria-describedby="answerHelpId"
           value="{{ old('correct_answer') ?? $question->correct_answer ?? "" }}">
</div>
@isset($tests)
    <div class="form-group">
        <label for="testId">Тест</label>
        <select class="form-control" name="test_id" id="testId">
            @foreach($tests as $test)
                <option value="{{ $test->id }}" {{ (old('test_id') ?? $question->test->id) == $test->id ? "selected" : "" }}>{{ $test->name }}</option>
            @endforeach
        </select>
    </div>
@else
    <input type="text" name="test_id" style="display: none" value="{{ $test->id }}">
@endisset