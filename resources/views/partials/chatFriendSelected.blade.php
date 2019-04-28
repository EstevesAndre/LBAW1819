<div class="tab-pane fade show active" id="list-{{ $user->id }}" role="tabpanel" aria-labelledby="list-{{ $user->id }}-list">
    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25" class="border bg-warning img-fluid rounded-circle">
    <a href="/user/{{ $user->id }}">{{ $user->name }}</a>
</div>