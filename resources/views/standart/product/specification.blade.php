 @if(!empty(@$options->specification))
  <div class="col-md-12 specification_list">
    @foreach(@$options->specification as $k => $spec )
     <?php 
        $result = get_specifications($k, $spec, @$attributes);
     ?>
       @if(!empty($result))
              <div class="specification_theme">
                <div class="specification_left">
                   {!! @$attributes['specifications'][$k]['all']['name'] !!}
                </div>
                <div class="specification_right">{!! $result !!}</div>
              </div>
       @endif
    @endforeach
 </div>
    
@endif