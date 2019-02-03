@if ($errors->any())
    <div class="alert alert-danger">
        <h6>Что-то пошло не так</h6>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif