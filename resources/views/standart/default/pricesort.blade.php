<form method="GET" action="" class="priceSort">
<div>
<input type="text" placeholder="{{_('Min')}}" value="{{ !empty($pricemin)? floatval($pricemin) : '' }}" name="pricemin"/>
<input type="text" placeholder="{{_('Max')}}" value="{{ !empty($pricemax)? floatval($pricemax) : '' }}" name="pricemax"/>
</div>
<button type="submit">{{_('Ok')}}</button> 
</form>