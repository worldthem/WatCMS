@if(!empty($settings_attributes['variations']))
<div class="inner_row background_variation">
     
       <div class="col_1_05">
         <label>{{ _l('Price') }}</label> <br/>
         <input type="text" class="form-control" name="variation[][price]" value="{{@number_format(@$variation['price'], 2, '.', '')}}">
       </div>
     
       <div class="col_2">
          <label>{{ _l('SKU') }} </label> <br/>
           <input type="text" class="form-control" name="variation[][sku]" value="{{@$variation['sku']}}">
      </div>
     <div class="col_1_05">
           <label>{{ _l('Quantity') }}</label> <br/>
           <input type="text" class="form-control" name="variation[][qtu]" value="{{@$variation['qtu']}}">
      </div>
     
     <div class="col_1_05">
            <label>{{ _l('Weight') }}({{_l("KG")}}) </label> <br/>
            <input type="text" class="form-control" name="variation[][weight]" value="{{@number_format(@$variation['weight'], 2, '.', '')}}">
      </div>
     <?php 
         echo @count(@$settings_attributes['variations'])>3? '<div class="clear"></div>':'';
      ?>
      
     @foreach ($settings_attributes['variations'] as $key=>$row)
       <div class="col_2 position_relatie">
           <label>{{@$row['all']['name']}}</label> <br/>
           <input type="text" class="form-control wsugestion" data-name="{{$key}}" name="variation[][{{@$key}}]" autocomplete="off" value="{{@$row["sugestion"][$variation[$key]]}}">
           <div class="sugestion_elements"></div>
      </div>
    @endforeach 
       <div class="clear"></div>
          <a href="#" onclick="return remove_element(this);" title="Delete"  class="fa_delete float_right"></a>
          <a href="#" onclick="dublicate(this); return false;" title="Dublicate"  class="fa_dublicate float_right"></a>
       <div class="height5px"></div>
   </div>
 @endif  