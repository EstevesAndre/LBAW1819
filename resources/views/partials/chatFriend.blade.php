<a class="friend-list list-group-item list-group-item-action" id="{{ $user->id }}" data-toggle="list" href="#list-{{ $user->id }}" aria-controls="{{ $user->id }}">
    <img src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}" alt="logo" width="25" class="mr-2 border bg-warning img-fluid rounded-circle">
    {{ $user->name }}
</a>