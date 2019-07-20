 
<form action="#" method="POST" id="sendForm{{$random}}" class="formDefault" onsubmit="wajax('.results{{$random}}', 'reset', '#sendForm{{$random}}' ); return false;">
 <input type="hidden" name="action" value="contactForm">
 <input type="hidden" name="id" value="{{@$id}}">
 @if(!empty($row['fields'])) 
   @for($i=0; $i<count($row['fields']['label']); $i++)
      <?php $requiere = !empty($row['fields']['required'][$i])? 'required=""':'' ?>
         <label class="type{{$row['fields']['type'][$i] =="text" || $row['fields']['type'][$i] =="email" ? "Input":"Textarea"}}"> 
          {!! @!empty($row['fields']['label'][$i]) ? @$row['fields']['label'][$i].'<br />' :'' !!}
          
           @if($row['fields']['type'][$i] =="text" )
             <input class="form-control" {{$requiere}} type="text" name="{{@$row['fields']['name'][$i]}}" value="" placeholder="{{@$row['fields']['placeholder'][$i]}}"/>
           @elseif($row['fields']['type'][$i] =="email")
             <input class="form-control" {{$requiere}} type="email" name="{{@$row['fields']['name'][$i]}}"  value="" placeholder="{{@$row['fields']['placeholder'][$i]}}"/>
           @else
             <textarea name="{{@$row['fields']['name'][$i]}}" {{$requiere}} class="form-control" placeholder="{{@$row['fields']['placeholder'][$i]}}"></textarea>
           @endif
         </label>
    @endfor
  @endif
 <div class="col-md-12 right-text">
   <button type="submit" class="btn">{{_l(@$row['submit'])}}</button>
 </div>
 <div class="results{{$random}} col-md-12"></div>
</form>