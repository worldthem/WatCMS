 <div class="search_box pull-right">
     <form action="{{  $url ?? '' }}" method="GET" id="SearchForm" data-attr="{{ $attribute ?? ''}}"> 
       <input type="hidden" class="searchCat" name="cat" value="{{ $cat ?? ''}}">
       <input type="text" name="s" value="{{$search ?? ''}}" class="searchText search_field{{$mode??''}}" placeholder="{{ $title ?? '' }}"/>
       <button type="submit"><i class="fa fa-search"></i></button>
     </form>   
 </div>