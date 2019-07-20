<label>
      <input type="radio" name="payment" value="Paypal" class="payment_method" data-unic="paypalPayment"> <!-- The name of your plugin -->
          @if(!empty($data['logo']))
             <img style="max-width: 250px;" src="{{ \Wh::logo_payment(@$data['logo']) }}">
           @endif 
         {{ @$data['title']  }}
</label>

 <div class="clear"></div>
     
  <div class="info-payment paypalPayment"> 
    <small><i>{!! @$data['description'] !!}</i></small> 
  </div> 