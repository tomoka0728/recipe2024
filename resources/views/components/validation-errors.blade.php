@if ($errors->any())
    <div class="p-4 mb-4 bg-red-100 text-red-800 rounded mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
