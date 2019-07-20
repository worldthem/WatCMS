@foreach($foreach_list as $k_list=>$cat_list) 
        <div class="card">
           <h3 class="padding_10px margin_top_0px">{{ $cat_list }}</h3>
           
               <div class="small_box_with_scroll loadResult_{{ $k_list }}" id="categories_right">
                 {!! \Wh::get_cat_yerahical_checkbox(\Wh::getAllCategories_all($k_list), 0, 0, $cat) !!}
              </div>
              <div class="height10px"></div>
               <p class="text_align_right padding_p">
                 <a href="#" class="showAddCat" data-show="{{ $k_list }}">{{_l("Add New")." ".$cat_list}}</a>
              </p>
              
           <div class="addNewCategory" id="catType_{{ $k_list }}">
                
                <input type="text" class="form-control catName" placeholder="{{_l('Title')}}"  value=""/>
                
                <div class="height5px"></div>
                
                <select class="form-control catParent">
                     <option value="">{{_l('Select Parent')}}</option>
                     {!! \Wh::get_cat_yerahical_option(\Wh::getAllCategories_all(@$k_list), 0, 0, '', '')  !!}
               </select>
               <div class="height5px"></div>
               
               <p class="text_align_right">
                 <span class="smallLoad_{{ $k_list }}"></span>
                 <button class="btn btn_small" onclick="return addNewCategory('{{ $k_list }}','{{url('/admin/update-categories')}}','{{ @json_encode(@$cat) }}'); "> {{_l("Add New")}}</button>
              </p>
              
           </div>   
        </div>
    @endforeach