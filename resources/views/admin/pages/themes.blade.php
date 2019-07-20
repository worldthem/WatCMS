@extends('admin.layouts.default')

@section('title', _l('Themes'))
@section('content')
 
<div class="col-md-12">
 <div class="card">
        
         <div class="header">
           <h4 class="title">{{ _l('Themes')}}</h4>
        </div>
     <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/themes/store" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
           
            <div class="col-md-4">
             <label>{{ _l('Add new one') }}</label><br />
              <input type="file" class="form-control" name="theme" accept='application/zip'/>
              <small><em>{{ _l('Select theme file (zip file)') }}</em></small>
           </div>
          
         <div class="col-md-2"><label><br /></label><br />
           <button type="submit" class="btn btn_small">{{ _l('Add new one') }}</button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div> 
     @foreach ($rows as $k=>$val)
          <?php $config= \Wh::get_config(@$val, 'all');
           $path= 'platform/Themes/'.$val.'/screenshot.jpg';
           $theme_thumb= File::exists(base_path($path)) ? url($path): 
            url("resources/admin_assets/img/screenshot.png") ;
           
          ?>  
          <div class="col-sm-4 single_theme">
            <div class="theme_list{{ $active==$val ? ' active':'' }}">
                <img src="{{$theme_thumb}}"/>
              <h3>{{ @ucfirst($val) }}</h3>
              <p>
              {!! @$config['description'] !!}
              </p>
               <footer>
                <a href="{{URL::to('/')}}/admin/themes/destroy/{{@$val}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"> </a>
                
                <a href="{{URL::to('/')}}/admin/themes/activate/{{@$val}}" class="btn_text btn btn_small btn_active" >
                    <span class="{{ $val == $active  ? 'fa_publish':'fa_unpublish'}}"></span>
                    {{ $val == $active ? _l('Deactivate'): _l('Activate')  }} 
                </a>
               </footer>
            </div>  
          </div>
     @endforeach
      <div class="height20px"></div>
    @if(!empty($data))  
      <h2 class="col-md-12">{{_l('New themes')}}</h2>
      @foreach ($data as  $new)
         <div class="col-sm-4 single_theme">
            <div class="theme_list">
                <img src="{{$new['img']}}"/>
              <h3>{{ @$new['title'] }}</h3>
               <footer>
                  <a href="{{@$new['url']}}" class="btn_text btn btn_small btn_active" target="_blank" >
                   {{  _l('Preview')  }} 
                  </a>
                <a href="{{@$new['download']}}" class="btn_text btn btn_small btn_active" target="_blank" >
                   {{  _l('Download')  }} 
                </a>
               </footer>
            </div>  
          </div>
       @endforeach
     @endif     
        <div class="height20px"></div>
      
  </div>
</div>
@stop