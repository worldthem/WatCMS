<label>
      <input type="radio" name="payment" value="BankTransfer" class="payment_method" data-unic="banktransferPayment"> <!-- The name of your plugin -->
          @if(!empty($data['logo']))
             <img style="max-width: 250px;" src="{{ \Wh::logo_payment(@$data['logo']) }}">
           @endif 
         {{ @$data['title'] }} 
      <div class="clear"></div>
        <div class="info-payment banktransferPayment"> 
            <small><i>{!! @$data['description'] !!}</i></small> 
          </div>
</label>