@extends('admin.layouts.default')

@section('title',  _l('Payments') )
@section('content')
 
<div class="col-md-12">
 <div class="card">
        <div class="header">
           <h4 class="title">{{ !empty($module)? $module : _l('Payments')}}</h4>
        </div>
     <div class="content table-responsive table-full-width">
      @if(isset($rows))
      
         <table class="table table-hover table-striped">
             <thead>
                 <th>{{ _l('Name') }}</th>
                 <th>{{ _l('Description') }}</th>
                 <th style="width: 100px"> </th>
                 <th style="width: 100px"> </th>
             </thead>
             <tbody>
                @foreach ($rows as $k=>$val)
                    <tr> 
                       <td>
                            {{$k}} 
                       </td>  
                       <td> {!! \Wh::get_config(@$k) !!} </td>
                        <td>
                           <a href="{{URL::to('/')}}/admin/payment/activate/{{@$k}}/{{ empty($val)? 'yes':'not'}}"  title="Unpublish" class="{{ !empty($val)? 'fa_publish':'fa_unpublish'}}"></a>
                       </td>
                      
                       <td> 
                          <a href="{{URL::to('/')}}/admin/payment/settings/{{@$k}}" > <i class="fa fa-sliders"></i> {{ _l('Settings') }} </a>
                       </td>
                    </tr>
                @endforeach
             </tbody>
         </table>
       @endif
       
      @if(!empty($view)) 
      
      <form action="{{URL::to('/')}}/admin/payment/store" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="action_field" value="{{ @$module }}">
          <input type="hidden" name="img" value="{{ @$data['logo'] }}"> 
            
            <table class="table_admin_settings">
             <tbody>
              <tr>
                <th>{{ _l('Enable') }}</th>
                <td>
                 <label class="switch"> 
                    <input name="enable" value="yes" class="checkbox" type="checkbox"  {{isset($data['enable'])? 'checked=""':'' }}  >  
                    <span class="slider round"></span>
                  </label>
                
                  
               </td> 
             </tr>
             </tbody>
             </table>
                      
           {!! @$view !!}
         
         
         <div class="col-md-1"><br />
           <button type="submit" class="btn btn_small"> {{ _l("Update")}} </button>  
        </div>
         
     <div class="clear"></div>
    </form> 
      
      @endif
       
       
     </div>
    
 </div>
</div>
@stop