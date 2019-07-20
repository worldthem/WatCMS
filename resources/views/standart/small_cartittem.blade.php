      <?php $total_cart = \Wh::get_cart();
            $total = 0;
       ?>
       <ul> 
         @foreach($total_cart as $v)
          <?php 
            $options = @json_decode($v->attr);
            $total = $total + \Wh::subTotal($v);
           ?>
            <li> 
                 <a href="{{\Wh::product_url($v->cpu,$v->cat)}}" >
                    <img src="{{ @\Wh::get_thumbnail(@$v->optionsdata) }}" alt="" class="img-responsive"  />
                    {{$v->title}} <br/>
                     @if(is_numeric($v->options_id))
                     <i>{{ @\Wh::ret_option(@$options->variation[$v->options_id]) }}</i>
                     <br/>
                     @endif
                     <b> {{!empty($options->variation)? $v->qty." x ".\Wh::get_price_number($v->price, @$v->sale_price, @$options->variation[$v->options_id]->price) : "x ".$v->qty }} </b>
                  </a>
                  <div class="clear_5px"></div>
            </li>
          @endforeach 
          
           <li>
             {{_l('Total')}} : {!! @\Wh::calcTotal(@$total, "full")  !!} 
          </li>
        </ul>
   
    