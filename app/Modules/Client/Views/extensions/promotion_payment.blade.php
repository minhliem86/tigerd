@if(!Cart::getConditions()->isEmpty())
    <p class="float-left">Khuyến mãi áp dụng</p>
    <div class="float-right">
        @foreach(Cart::getConditions() as $cartCondition)
            {!! Form::hidden('promotion_name', $cartCondition->getName()) !!}
            <span class="badge badge-info">{!! $cartCondition->getName() !!}</span>
        @endforeach
    </div>
@endif