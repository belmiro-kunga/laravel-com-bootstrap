@props(['count' => 0, 'class' => ''])

@if($count > 0)
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge {{ $class }}">
        {{ $count > 99 ? '99+' : $count }}
    </span>
@endif 