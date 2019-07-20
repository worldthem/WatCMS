 
<form action="/admin/fields/update" id="add_sugestion_new" method="post" onsubmit="access_url('{{url("/admin/attributes/update")}}','.modal_load_content','.add_load_new','#add_sugestion_new'); return false;">
    <input type="hidden" name="attributeID" value="{{$sugestion}}"/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="new"/> 
    <table class="table add_new_top">
         <tr>
              <td> 
              <label>{{_l("Add sugestion")}} ({{_l("One per line")}})</label><br />
                <textarea class="form-control"  name="title" required=""></textarea><br />
                <input type="submit" class="btn btn_small" value="{{_l('Add new one')}}"/> 
                <span class="add_load_new" style="width: 35px;"></span>
            </td>
        </tr> 
    </table>
</form>

@if(!empty($data))
<form action="#" method="post" class="bulkEditting" onsubmit="access_url('{{url("/admin/attributes/remove-bulk")}}','.modal_load_content','.resultBulk', '.bulkEditting'); return false;">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden"   name="attrID" value="{{$sugestion}}"/>
           <div class="col-md-6" style="padding-left: 8px;">
               <select name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del">{{ _l('Remove') }} </option>
               </select>
          </div>
         
        <div class="col-md-6">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
           <span class="resultBulk"></span>
        </div>

    
   
       <table class="table table-hover table-striped">
         <thead>
             <th style="width: 40px;"><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
             <th>{{ _l('Title') }}</th>
             <th> </th>
             <th> </th>
             <th style="width: 30px;"> </th>
          </thead>
         <tbody>
            
             @foreach($data as $k=>$v)
                 <tr class="updateData{{$k}}"> 
                   <td> 
                       <input type="hidden" name="return" value="noresult"/>
                       <input type="hidden" name="attributeID" value="{{$sugestion}}"/>
                       <input type="hidden" name="id" value="{{$k}}" />
                       <input type="checkbox" name="rowid[]" class="checkboxeach"  value="{{$k}}">
                   </td>
                   <td> <input type="text" class="form-control" name="title" value="{{$v}}" /> </td>
                    
                   <td> 
                       <a href="#" class="btn btn_small" onclick="return updateSerialiseFromDiv('{{url("/admin/attributes/update")}}','.add_load{{$k}}','.updateData{{$k}}');" >{{_l('Update')}}</a>
                    </td> 
                   <td>  
                     <a href="" class="fa_delete" onclick="access_url('{{url("/admin/attributes/remove/".$sugestion."/".$k)}}','.modal_load_content','.add_load{{$k}}'); return false;"> </td> 
                   <td class="col-md-1 add_load{{$k}}">  </td>
                </tr>
             @endforeach
         </tbody>
      </table>
 </form> 
 @endif  