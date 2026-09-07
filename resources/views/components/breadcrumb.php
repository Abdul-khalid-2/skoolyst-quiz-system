<div class="sk-breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a></li>
                @foreach($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['label'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>