<li class="p-2 ml-3">
    <a  class="box-link no-hover" href="/user/{{ $user->username}}">  
        <div class="d-flex align-items-center row">
            <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                <img width="50" class="border bg-warning img-fluid rounded-circle border"
                src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}" alt="User">
            </div>
            <div class="col-6 col-sm-5 col-md-6 pr-1 text-left">{{$user->name}}</div>
            <div class="col-3 col-sm-4 col-md-4 px-0 text-right search-info">
                @if($user->clan()->get()->isEmpty())
                    <div><i class="fas fa-users"></i> <span>No clan</span></div>
                @else
                    <div><i class="fas fa-users"></i> <span>Clan: {{ $user->clan()->get()[0]->name }}</span></div>
                @endif
            <div><i class="fas fa-flag"></i> <span>Race: {{$user->race}}</span></div>
            </div>
        </div>
    </a>
    </li>