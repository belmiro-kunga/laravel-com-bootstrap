@props(['items' => []])

@if(!empty($items))
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                <i class="fas fa-home"></i>
                <span class="d-none d-sm-inline">Dashboard</span>
            </a>
        </li>
        
        @foreach($items as $index => $item)
            @if($index === count($items) - 1)
                <li class="breadcrumb-item active" aria-current="page">
                    @if(isset($item['icon']))
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    {{ $item['title'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}" class="text-decoration-none">
                            @if(isset($item['icon']))
                                <i class="{{ $item['icon'] }}"></i>
                            @endif
                            {{ $item['title'] }}
                        </a>
                    @else
                        @if(isset($item['icon']))
                            <i class="{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['title'] }}
                    @endif
                </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif 