 @extends('admin.layouts.default')

@section('title', _l('General Settings'))
@section('content')
 
<div class="col-md-12">
   <div class="card">
       
<div class="col-md-6"> 

<h3>{{ _l('Email Settings') }}</h3>
@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
<form action="{{URL::to('/')}}/admin/mail/store" method="post" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="col-md-12">
       <input type="submit" class="btn btn_small" value="{{ _l('Update') }}"/>
     </div> 
             <table  class="table_admin_settings">
               <tr>
                     <th> {{ _l("Mail Driver") }} </th>
                     <td>
                        <div class="col-md-12">
                            <select name="mailDRIVER" class="form-control">
                                @foreach($drivers as $driver)
                                   <option value="{{ $driver }}" {{@$driver== @$array['mailDRIVER'] ? 'selected=""':'' }} >{{ $driver }}</option>
                                 @endforeach                                           
                             </select>
                        </div>   
                     </td> 
               </tr>
               <tr>
                     <th> {{ _l("SMTP Host Address") }} </th>
                     <td>
                       <div class="col-md-12">
                             <input type="text" class="form-control" name="mailHOST" value="{{ @$array['mailHOST'] }}" />
                        </div>   
                     </td> 
               </tr>
                 <tr>
                     <th> {{ _l("SMTP Host Port") }} </th>
                     <td>
                       <div class="col-md-12">
                             <input type="text" class="form-control" name="mailPORT" value="{{ @$array['mailPORT'] }}" />
                        </div>   
                     </td> 
               </tr>
               <tr>
                     <th> {{ _l('Global "From" Address') }} </th>
                     <td>
                       <div class="col-md-12">
                             <input type="text" class="form-control" name="mailFROM_ADDRESS" value="{{ @$array['mailFROM_ADDRESS'] }}" />
                        </div>   
                     </td> 
               </tr>
               <tr>
                     <th> {{ _l('Global "From" Name') }} </th>
                     <td>
                       <div class="col-md-12">
                             <input type="text" class="form-control" name="mailFROM_NAME" value="{{ @$array['mailFROM_NAME'] }}" />
                        </div>   
                     </td> 
               </tr>
               <tr>
                     <th> {{ _l("E-Mail Encryption Protocol") }} </th>
                     <td>
                       <div class="col-md-12">
                             <input type="text" class="form-control" name="mailENCRYPTION" value="{{ @$array['mailENCRYPTION'] }}" />
                        </div>   
                     </td> 
               </tr>
               <tr>
                     <th> {{ _l("SMTP Server Username") }} </th>
                     <td>
                       <div class="col-md-12">
                             <input type="text" class="form-control" name="mailUSERNAME" value="{{ @$array['mailUSERNAME'] }}" autocomplete="off"/>
                        </div>   
                     </td> 
               </tr>
               <tr>
                     <th> {{ _l("SMTP Server Password") }} </th>
                     <td>
                       <div class="col-md-12">
                             <input type="password" class="form-control" placeholder="*********" name="MAIL_PASSWORD" value="{{ @$array['MAIL_PASSWORD'] }}" autocomplete="off" />
                        </div>   
                     </td> 
               </tr>
               
                  
                 
            </table>
     <div class="col-md-12">
       <input type="submit" class="btn btn_small" value="{{ _l('Update') }}"/>
   </div>  
 </form>
</div>

<div class="col-md-6">
<form action="{{URL::to('/')}}/admin/mail/send-test" method="post" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<h3>Send test mail</h3> <br /> 
 @if($errors->any())
   <h4>{{$errors->second()}}</h4>
 @endif
  
     <div class="col-md-12">
     {{ _l("To") }}<br />
         <input type="text" class="form-control" placeholder="your-email@domain.com" name="to" value="" required="" /><br />
    </div>   
      <div class="col-md-12">{{ _l("Text") }}<br />
        <textarea class="form-control" placeholder="Test emil from" name="body" required="">Test emil from </textarea>
      </div>   

     <div class="col-md-12"><br /><br />
        <input type="submit" class="btn btn_small"  value="{{ _l('Send') }}"/>
    </div>   
      
 </form>
</div>
               
             
         <div class="height20px"></div>
      </div>
  </div>
@stop 