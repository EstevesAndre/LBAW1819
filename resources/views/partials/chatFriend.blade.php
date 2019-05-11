<a class="friend-list list-group-item list-group-item-action" id="{{ $user->id }}" data-toggle="list" href="#list-{{ $user->id }}" aria-controls="{{ $user->id }}">
    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25" class="border bg-warning img-fluid rounded-circle">
    {{ $user->name }}
</a>