@extends('admin.layouts.default')
<?php $name_content = !empty($catname)? $catname : "Products";
$catid=!empty($id_cat)? $id_cat: 0;
$setting = @\Wh::get_settings_json("_main_options_");
$cat = \Wh::getAllCategories_all("product"); 
?>
@section('title', $name_content)
@section('content')
 
<div class="col-md-12">
 <div class="card">
    <div class="header">
        <p>
          <a class="btn" href="{{URL::to('/')}}/admin/product/new">{{ _l('Add new one') }}</a>
       </p>
     </div>
     
     <hr/>
   <div class="col-md-7 noPadding">  
     <h4>{{ _l('Transfer products from one category to another') }}</h4>
     <form action="/admin/move-prodduct-from-to-category" method="GET"> 
         
         <div class="col-md-4">
             {{ _l('FROM') }}<br/>
              <select name="from" class="form-control" >
                {!! \Wh::get_cat_yerahical_option($cat, 0, 0)  !!}
              </select>
        </div>
         <div class="col-md-4">
             {{ _l('TO') }}<br/>
               <select class="form-control"  name="to"> 
                {!! \Wh::get_cat_yerahical_option($cat, 0, 0)  !!}
               </select>
        </div>
         <div class="col-md-4">
             <br/> 
             <input type="submit" class="btn btn_small" value="{{ _l('Transfer') }}"> 
        </div>
         <div class="clear"></div>
    </form>
    </div>
    
    <div class="col-md-5 noPadding" >
     <h4>{{ _l('Increase price') }}</h4>
       <form action="/admin/product/increase-price" method="POST"> 
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <div class="col-md-5">
             {{ _l('With') }}<br/>
             <input  type="text" class="form-control" value="{{@$setting['_additional_price']}}" name="_additional_price"/>  
        </div>
         <div class="col-md-4">
             {{ _l('Type') }}<br/>
               <select class="form-control"  name="_additional_type"> 
                 <option value="fix">{{ _l('Fixed price') }}</option>
                 <option value="percentage"  {{@$setting['_additional_type']=='percentage'? 'selected=""':''}}>{{ _l('Percentage from price') }}</option>
               </select>
        </div>
         <div class="col-md-3">
             <br/> 
             <input type="submit" class="btn btn_small" value="{{ _l('Increase') }}"> 
        </div>
         <div class="clear"></div>
    </form>
   </div>
   
    <div class="clear"></div>
      <hr/>
     <div class="clear_15px"></div>
     <form action="{{URL::to('/')}}/admin/products-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="col-md-2">
          <select  name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="move">{{ _l('Move to category') }}</option>
                <option value="hide">{{ _l('Hidde Products') }}</option>
                <option value="visible">{{ _l('Make products Visible') }}</option>
                <option value="del">{{ _l('Delete') }} </option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-control">
                <option value="">{{ _l('Select category') }}</option>
                {!! \Wh::get_cat_yerahical_option($cat, 0, 0)  !!}
            </select>
        </div>
         <div class="col-md-1">
          <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
         </div>
        <div class="gap_20px">
            <br />  
        </div>
  
        <div class="col-md-2">
            <select class="form-control"  onchange="if (this.value) window.location.href=this.value">
                <option value="{{url('/admin/view-products')}}" >{{ _l('Show products from category') }}</option>
                  {!! \Wh::get_cat_yerahical_option($cat, 0, 0, "/admin/view-products-cat", $catid)  !!}
            </select>
        </div>
         
         <div class="col-md-2">
           <input type="text" class="form-control" name="s" value=""  placeholder="{{ _l('Search Product') }}"/>
         </div>
          <div class="col-md-1">
            <button type="submit" class="btn btn_small">{{ _l('Search') }}</button>  
          </div>
        
         <div class="col-md-1">
            <a href="{{URL::to('/')}}/admin/view-products" class="btn btn_small btn_active">{{ _l('Reset') }}</a>
         </div>
     <div class="clear"></div>
     
     <div class="content table-responsive table-full-width">
          <table class="table table-hover table-striped">
             <thead>
                 <th style="width: 40px;"><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th style="width: 47px;">{{ _l('ID') }}</th>
                 <th style="width: 100px;">{{ _l('Price') }}</th>
                 <th style="width: 55px;">{{ _l('Image') }}</th>
                 <th>{{ _l('Title') }}</th>
                 <th>{{ _l('Categories') }}</th>
                 <th>{{ _l('Author') }}</th> 
                 <th colspan="3" style="width:120px;text-align: right;"><strong>{{@$count_products}} {{ _l('Products') }}</strong></th>
             </thead>
              <tbody>
                 <?php $split=" ";?>
                @foreach($products as $product)
                <tr>
                 
                    <td>
                        <input type="checkbox" name="productid[]" class="checkboxeach"  value="{{$product->id}}">
                    </td>
                    <td>
                    <a href="{{@\Wh::product_url(@$product->cpu, @$product->cat)}}" target="_blank">
                        {{$product->id}}
                     </a> 
                   </td>
                    <td>
                       {!! \Wh::get_price_full($product->price,$product->sale_price) !!}            
                     </td>
                     <td>
                        <img style="max-width: 40px;" src="{{ @\Wh::get_thumbnail($product->optionsdata,'json') }}" alt="{{ $product->title }}" /> 
                     </td>
                    <td>
                        <a href="{{URL::to('/')}}/admin/product/{{$product->id}}">
                            {{ $product->title }}
                        </a> 
                    </td>
                    <td>
                        
                        <a href="{{URL::to('/')}}/admin/view-products-cat/{{@json_decode($product->cat,true)[0] }}">
                            {{ @\Wh::get_catbyfield('title', 'id', @\Wh::json_key($product->cat, 0))  }}
                        </a> 
                    </td>
                     <td>
                        <a href="{{URL::to('/')}}/admin/view-products/none/{{$product->user_id}}">
                            {{ @\Wh::get_user_name($product->user_id)  }}
                        </a> 
                    </td>
                    
                        <td class="width_table_btn">
                          <a href="{{URL::to('/')}}/admin/product/{{$product->id}}" title="Edit" class="fa_edit"> 
                          </a>
                        </td>
                        <td class="width_table_btn"> 
                          <a href="{{URL::to('/')}}/admin/product-delete/{{$product->id}}" title="Delete"  class="fa_delete"> 
                          </a>
                        </td>
                          <td class="width_table_btn">
                             <a href="{{URL::to('/')}}/admin/product-hidde/{{$product->id}}/{{$product->hide>0? 0:1}}" title="Unpublish" class="{{$product->hide>0? 'fa_publish':'fa_unpublish'}}" ></a>
                        </td> 
                    
                    </tr>
                @endforeach
             </tbody>
         </table>
       
          <div class="col-md-12">
             {!! $products->appends(Input::all())->render() !!}
          </div>
          <div class="clear"></div>
     </div>
     </form>
      
 </div>
</div>
@stop