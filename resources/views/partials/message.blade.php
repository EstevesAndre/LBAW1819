@if($message->receiver == Auth::user()->id)
<div class="my-3 incoming_msg">
    <div class="incoming_msg_img"> <img src="{{ asset('assets/logo.png') }}"> </div>
    <div class="received_msg">
        <div class="received_withd_msg">
            <p>{{$message->message_text}}</p>
            <span class="mt-0 pt-0 time_date">&nbsp&nbsp{{substr($message->date, 0, 10)}}&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp{{substr($message->date, 11, -3)}}</span>
        </div>
    </div>
</div>
@else
<div class="my-3 outgoing_msg">
    <div class="sent_msg">
        <p>{{$message->message_text}}</p>
        <span class="text-right mt-0 pt-0 time_date">{{substr($message->date, 0, 10)}}&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp{{substr($message->date, 11, -3)}}&nbsp&nbsp</span>
    </div>
</div>
@endif