<label>
      <input type="radio" name="payment" value="CheckPayment" class="payment_method" data-unic="checkPayment"> <!-- The name of your plugin -->
          @if(!empty($data['logo']))
             <img style="max-width: 250px;" src="{{ \Wh::logo_payment(@$data['logo']) }}">
           @endif 
         {{ @$data['title'] }} 
      <div class="clear"></div>
          <div class="info-payment checkPayment"> 
            <small><i>{!! @$data['description'] !!}</i></small> 
          </div> 
</label>