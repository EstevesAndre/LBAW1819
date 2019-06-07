<li class="text-left list-group-item border-0 list-group-item-action">
    <div class="d-flex align-items-center row">
        <div class="col-2 col-sm-1 friend-img">
            @if(file_exists('assets/clanImgs/'.$clan[0]->id.'.png'))
            <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan[0]->id.'.png')}}" alt="Clan">
            @else
            <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png')}}" alt="Clan">
            @endif
        </div>
        <div class="col-7 col-sm-6 text-left">{{ $clan[0]->name }}</div>
        <div class="col-7 col-sm-5 text-right">{{ $clan[1] }}</div>
    </div>
</li>