<script type="text/javascript">
<!--
   @foreach ($settings_attributes as $row_attr)
     @foreach ($row_attr as $key=>$row)
       var {{$key}} = {!! @json_encode(@array_filter(@$row["sugestion"])) !!};   
     @endforeach
   @endforeach
 -->
</script>