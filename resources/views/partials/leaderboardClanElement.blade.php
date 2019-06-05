<button type="button" class="text-left list-group-item border-0 list-group-item-action">
    <li class="ml-3">
        <div class="d-flex align-items-center row">
            <div class="col-2 col-sm-1 friend-img">
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan->id.'.png')}}" alt="Clan">
            </div>
            <div class="col-7 col-sm-6 text-left">{{ $clan->name }}</div>
        </div>
    </li>
</button>