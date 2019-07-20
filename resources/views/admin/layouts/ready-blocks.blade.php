<?php
 $data = \Wh::get_settings_json("_page_builder_");
?>

    @if(!empty($data))
        @foreach($data as $kB=>$vB)
         <a href="#" class="block_list" data-class="{{$kB}}">
             <img src="{{$vB[0]}}" />
             <span>{{$vB[1]}}</span>
        </a>
         
        <textarea class="{{$kB}}" style="display: none;">{!! @$vB[2] !!}</textarea>
       <textarea class="style{{$kB}}" style="display: none;">{!! !empty($vB[3])? @json_encode($vB[3]) :"" !!}</textarea>
        @endforeach
     
    @endif