@props(['items' => []])

@if(!empty($items))
<div class="breadcrumb-container mb-4">
    <nav aria-label="breadcrumb" class="bg-white rounded-3 shadow-sm py-2 px-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none d-flex align-items-center">
                    <i class="fas fa-home me-1"></i>
                    <span class="d-none d-sm-inline">Dashboard</span>
                </a>
            </li>
            
            @foreach($items as $index => $item)
                @if($index === count($items) - 1)
                    <li class="breadcrumb-item active d-flex align-items-center" aria-current="page">
                        @if(isset($item['icon']))
                            <i class="{{ $item['icon'] }} me-1"></i>
                        @endif
                        <span>{{ $item['title'] }}</span>
                    </li>
                @else
                    <li class="breadcrumb-item d-flex align-items-center">
                        @if(isset($item['url']))
                            <a href="{{ $item['url'] }}" class="text-decoration-none d-flex align-items-center">
                                @if(isset($item['icon']))
                                    <i class="{{ $item['icon'] }} me-1"></i>
                                @endif
                                <span>{{ $item['title'] }}</span>
                            </a>
                        @else
                            @if(isset($item['icon']))
                                <i class="{{ $item['icon'] }} me-1"></i>
                            @endif
                            <span>{{ $item['title'] }}</span>
                        @endif
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>

<style>
.breadcrumb {
    --bs-breadcrumb-padding-y: 0.5rem;
    --bs-breadcrumb-padding-x: 0;
    --bs-breadcrumb-margin-bottom: 0;
    --bs-breadcrumb-bg: transparent;
    --bs-breadcrumb-border-radius: 0;
    --bs-breadcrumb-divider-color: #6c757d;
    --bs-breadcrumb-item-padding-x: 0.5rem;
    --bs-breadcrumb-item-active-color: #6c757d;
    font-size: 0.875rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: var(--bs-breadcrumb-divider, ">");
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    opacity: 0.6;
}

.breadcrumb-item a {
    color: var(--bs-primary);
    transition: color 0.2s ease-in-out;
}

.breadcrumb-item a:hover {
    color: var(--bs-primary-dark);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--bs-gray-700);
    font-weight: 500;
}

.breadcrumb-container {
    margin-top: 1rem;
    margin-left: -0.75rem;
    margin-right: -0.75rem;
}

@media (max-width: 767.98px) {
    .breadcrumb {
        white-space: nowrap;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 0.5rem;
    }
    
    .breadcrumb::-webkit-scrollbar {
        height: 4px;
    }
    
    .breadcrumb::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.1);
        border-radius: 2px;
    }
}
</style>
@endif