@unless ($breadcrumbs->isEmpty())

    <ol class="bc">
        @foreach ($breadcrumbs as $breadcrumb)

            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li class="bc-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="bc-item active">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>

@endunless
