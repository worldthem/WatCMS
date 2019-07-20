<?php $currency = @_CURRENCIES_;
  ?>

@if(!empty($currency) || count($currency)>1) 

        <div class="btn-group pull-left">
            <div class="btn-group show_currency">
                 <button type="button" class="btn btn-default dropdown-toggle usa">
                    {!! @CURENCY_CODE_KEY."(". @CURENCY_CODE.")" !!}
                    <span class="caret"></span>
                </button>
                
                 <ul class="dropdown-menu currency_meu">
                  @foreach($currency as $k_c=>$v_c)
                    <li><a href="{{url('/setup-currency/'.$k_c)}}">{!! @$k_c." (".$v_c['code'].")" !!}</a></li>
                  @endforeach  
                 </ul>
            </div>
        </div>
        
@endif