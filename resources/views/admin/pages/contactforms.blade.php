@extends('admin.layouts.default')

@section('title', !empty($id)? @$title : 'Contact Form')
@section('content')
 
<div class="col-md-12">
 <div class="card">
       
         <div class="header">
           <h4 class="title">{{ _l('Contact Forms') }}</h4>
        </div>
   
 @if(!empty($rows))  
   <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/contact-form/store" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
         
           <div class="col-md-2">
              <label> {{ _l('Form name') }} <br />
                <input type="text" name="value" required="" class="form-control"/>
             </label>
          </div>
          
         <div class="col-md-1"><br />
           <button type="submit" class="btn btn_small">{{ _l('Add New') }} </button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div> 
      
        
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th>ID</th>
                 <th>{{ _l('Form Title') }}</th>
                 <th>{{ _l('Use Form in page') }}</th>
                 <th style="width: 40px"> </th>
                 <th style="width: 40px"> </th>
             </thead>
             <tbody>
                @foreach ($rows as $val)

                 <tr id="edit_this_nr{{$val->id}}"> 
                       <td>{{$val->value2}}</td>
                       <td>
                            <a href="{{URL::to('/')}}/admin/contact-form/single/{{$val->id}}">
                              {{$val->value}} 
                            </a>
                       </td>  
                       
                     <td>[form id={{$val->value2}}]</td>
                      <td> 
                         <a href="{{URL::to('/')}}/admin/contact-form/single/{{$val->id}}" class="fa_edit small" > </a>
                     </td>
                      <td> 
                        <a href="{{URL::to('/')}}/admin/contact-form/destroy/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"> </a>
                     </td>
                     <td class="result{{$val->id}}"></td>
                 </tr>
                @endforeach
             </tbody>
         </table>
 
     </div>
  @endif
  
   @if(!empty($id))
      <script src="{{URL::to('/')}}/resources/admin_assets/js/contact-form.js"></script>
      <div class="content table-responsive table-full-width">
        <form action="{{URL::to('/')}}/admin/contact-form/store" method="post">
        
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{$id}}">
          <input type="hidden" name="value" value="{{$title}}">
          <input type="hidden" name="value2" value="{{$value2}}">
          <div class="col-md-4">
           <label>{{_l("Add this code in to your page")}}</label><br />
           <input class="form-control" type="text" value="[form id={{@$value2}}]"/>
         </div> 
         <div class="height20px"></div>
          <div class="col-md-4">
           <label>{{_l("Email To")}}</label><br />
           <input class="form-control" type="text" value="{{@$row['to']}}" name="value1[to]"/>
         </div> 
          <div class="height20px"></div>
             <div class="col-md-12">
               <a href="#" class="newField btn btn_small">{{_l("Add new Field")}}</a>
            </div>
            <div class="height20px"></div>
              <div class="fields_list"> 
                @if(!empty($row['fields'])) 
                     @for($i=0; $i<count($row['fields']['name']); $i++)
                        @include("admin.layouts.contactFormField")
                      @endfor
                @endif 
             </div> 
             <div class="height20px"></div>
         <div class="col-md-4">
           <label>{{_l("Submit Button")}}</label><br />
           <input class="form-control" type="text" value="{{@$row['submit']}}" name="value1[submit]"/>
         </div>  
         
         <div class="col-md-8">
           <label>{{_l("Successfull mesage")}} {{_l("Example: Your message has been sent successfully!")}}</label><br />
           <input class="form-control" type="text" value="{{@$row['message']}}" name="value1[message]"/>
         </div>
           <div class="height20px"></div>
           <div class="col-md-12">
              <input  type="submit" value="{{_l('Save')}}" class="btn btn_small"/>
              
           </div>
        </form> 
         
     </div>
     <div class="fields_html" style="display: none;">
        @include("admin.layouts.contactFormField")
     </div>
     
   @endif
    
 </div>
</div>

@stop