<tr>
    <td>
        <input type="checkbox" name="catid[]" class="checkboxeach"  value="{{$maincat->id}}">
    </td>
    <td>{{$maincat->id}}</td>
    <td>
    <a href="{{url('/cat/'.\Wh::generate_cat_url($maincat->id))}}" target="_blank">
       {!! @$split !!}{{$maincat->title}}
    </a>
     </td>
    <td> {{ $maincat->cpu}} | {{ $maincat->url}} </td>
    <td> 
        <a href="{{URL::to('/')}}/admin/categories/add-edit/{{@$type}}/{{$maincat->id}}" class="fa_edit"></a> |
         <a href="{{URL::to('/')}}/admin/cat-hide-show/{{$maincat->id}}/{{$maincat->tip==2? 1:2 }}" title="Unpublish" class="{{$maincat->tip==2? 'fa_unpublish':'fa_publish'}}" ></a>
     </td>
    <td> 
        <a href="{{URL::to('/')}}/admin/del-cat/{{$maincat->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"></a>
    </td>
 </tr>