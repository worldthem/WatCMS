<?php $recent="";?>
@if($fields)
 
 @if(isset($fields['enable']) && $key_ship == "sipping_")
       <label class="chckbox_show show_shipping">
        <input type="checkbox" name="_differentaddres" class="differentaddress" value="yes" onclick="hide_show_is(this,  '.shipping_address');"> 
        {{ _l('Ship to different address') }}
      </label>
 @endif
 
 <div class="{{$key_ship == 'sipping_' ? 'shipping_address':'billing_address'}}" >
 <div class="register-reqs">{{@$fields['header']['name']}}</div>
 
   @foreach($fields as $k=>$v)
     @if(isset($v['type']) || $k=="country")
       <?php 
           $class_1 =@$v['mode']=="full" ?"full-width":"small_input"; 
           $last= @$last_address[@$key_ship.$k];
           $requiared= isset($v['required']) ? " require":'';
        ?>
             <div class="{{$class_1}} {{@$recent=="half" && $v['mode']=="half"? " right_inp":''}}">
         
             {!! isset($v['show_title']) && $k!="password" ? @$v['name'].'<br />':'' !!}
              @if(@$v['type']=="textbox" && $k!="password"&& $k!="email")
                 <input type="{{$k=="password" ? "password":"text"}}" name="{{@$key_ship.$k}}" class="cl_{{@$key_ship.$k.$requiared}}" value="{{@$last}}" placeholder="{{@$v['name']}}" />
              @elseif(@$k=="password" && !Auth::check() )
                 {!! isset($v['show_title'])? @$v['name'].'<br />':'' !!}
                 <input type="password" name="{{@$key_ship.$k}}" class="cl_{{@$key_ship.$k.$requiared}}" value="" placeholder="{{@$v['name']}}" />
               
               @elseif(@$k=="email")
                 <input type="email" name="{{@$key_ship.$k}}" class="cl_{{@$key_ship.$k.$requiared}}" value="{{Auth::check() ? @\Wh::get_user_name('current', 'email'): @$last}}" placeholder="{{@$v['name']}}" />
                   
              @elseif(@$v['type']=="select" || $k=="country" )
                 <select name="{{@$key_ship.$k}}" class="cl_{{@$key_ship.$k.$requiared}}" {!! $k=="country"? "onchange=\"wajax('.deliverylist', 'action=shipping_get&id='+ this.value +'&kg=".$kg."&total=".$total."');\"":"" !!}>
                  <option value=""> Select  {{@$v['name']}} </option>
                  <?php 
                       $select_val = $k=="country"? \Wh::list_countries_db():
                                           @explode("\n", $v['sugestion']); 
                     ?>
                  @foreach($select_val as $val_s)
                     <?php $option =@$k=="country"? $val_s->id:$val_s; ?>
                        <option value="{{@$option}}" {!! @$option == $last  ? "selected=''":"" !!}>
                           {{@$k=="country"? $val_s->country:$val_s}}
                       </option>
                  @endforeach
                 </select>
             @elseif(@$v['type']=="textarea")
                <textarea name="{{@$key_ship.$k}}" value="" placeholder="{{@$v['name']}}" class="cl_{{@$key_ship.$k.$requiared}}" />{{@$last}}</textarea>
             @endif
         </div>
          <?php 
           if(@$recent=="half" && $v['mode']=="half"){
            $recent= '';
            echo "<div class='clear'></div>";// make sure it's working for all browsers'
           }else{
            $recent= @$v['mode'];
           }
          ?>
         
     @endif
  @endforeach
  
  </div>
    
 @endif  