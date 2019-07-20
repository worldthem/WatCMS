@extends('admin.layouts.default')

@section('title', 'Statistic')
@section('content')
 
<div class="col-md-12">
 <div class="card">
     <div class="header">
         <h4 class="title">{{ _l('Statistic') }}</h4>
     </div>
     <div class="content table-responsive table-full-width">
     
            <div class="bargraph" >
                <ul class="bars">
                <?php 
                   $dates=array();
                   $i=-30; 
                       foreach ($general as $key=>$one) {
                       $i=$i+25; 
                       $dates[]=date("d", strtotime($key))."<br/>".date("m", strtotime($key)) ; ?>
                    <li class="bluebar" style="height: {{@(count($one)/2)}}px; left:{{$i}}px;"><span> <a href="/admin/statistic/{{ @$key }}"> {{@count($one)}} </a> </span> </li>
                 <?php  } ?>   
                   
                </ul>
                <ul class="label_firs">
                 <li><span>day</span> <br/><span>month</span><br/><span>durat.</span></li>
                 </ul>
                <ul class="label">
                  <?php foreach ($dates as $one_dat): ?>
                    <li> <?php echo $one_dat;?></li>
                  <?php endforeach; ?>  
                </ul>
                
             <ul class="y-axis">
             <li>1300</li>
             <li>1200</li>
             <li>1100</li>
             <li>1000</li>
             <li>900</li>
             <li>800</li>
             <li>700</li>
             <li>600</li>
             <li>500</li>
             <li>400</li>
             <li>300</li>
             <li>200</li>
             <li>100</li>
             <li>0</li>
             </ul>
            <p class="centered">{{ _l('Statistic for the last month') }}</p> 
            </div>     
     <div class="clear"></div>
     <div class="col-md-6">
     <h3> Country</h3>
          <table class="table">
              @foreach($country as $k=>$c)
               <tr>
                <td>{{$k}}  
                </td>
                <td>{{count($c)}}</td>
               </tr>
               @endforeach
          </table>
      </div>
      
      <div class="col-md-6">
      <h3>Source</h3>
          <table class="table">
          
              @foreach($source as $ks=>$s)
                   <tr>
                        <td>{{$ks}}</td>
                        <td>{{count($s)}}</td>
                   </tr>
               @endforeach
          </table>
          
          <h3>{{ _l('Page Visit') }}</h3>
          <table class="table">
          @if(!empty($page_visit))
              @foreach($page_visit as  $s)
                   <tr>
                        <td>{{$s[0]}}</td>
                        <td> <?php $explode = @json_decode($s[1], true);?>
                            @if(!empty($explode)) 
                                @foreach($explode as  $visit)
                                  @if(!empty($visit))
                                    {{$visit}}<br />
                                  @endif 
                                @endforeach
                            @endif
                        </td>
                   </tr>
               @endforeach
            @endif    
          </table>
          
      </div>
     </div>
     <div class="clear"></div>
 </div>
</div>
@stop