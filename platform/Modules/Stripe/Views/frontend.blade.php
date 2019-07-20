<!-- keep this hidden element -->
 <input type="hidden" class="stripe_token" autocomplete="off" name="stripe_token" value="" />
 
<label>
      <input type="radio" name="payment" value="Stripe" class="payment_method" data-unic="stripePayment"> <!-- The name of your plugin -->
          @if(!empty($data['logo']))
             <img style="max-width: 250px;" src="{{ \Wh::logo_payment(@$data['logo']) }}">
           @endif 
         {{ @$data['title'] }} 
      <div class="clear"></div>
</label>

<div class="info-payment stripePayment">
     <div class="clear_10px"></div>
     <div id="card-element">
       <!-- A Stripe Element will be inserted here. -->
      </div>
    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert" style="color: red;"></div>
    
    <small><i>{!! @$data['description'] !!}</i></small> 

</div>

@if(isset($data['pk_publish']))
     <script src="https://js.stripe.com/v3/"></script>
     
     <script type="text/javascript">
       <!--
    	 var stripe_public = '{{ @$data["pk_publish"] }}';
       -->
     </script>
     
    <script src="{{url('/platform/Modules/Stripe/js/stripe.js')}}"></script>
@endif  
  