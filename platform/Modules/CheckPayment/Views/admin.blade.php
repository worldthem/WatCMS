
<table class="table_admin_settings">
 <tbody>
    
 <tr>
    <th>{{ _l('Title') }}</th>
    <td>
      <input class="form-control" name="title" value="{{ $data['title'] or 'Check payments' }}" type="text">  
   </td> 
 </tr>  
 <tr>
    <th>{{ _l('Image') }}</th>
    <td>
      <input class="form-control" name="logo" type="file"> 
      @if(!empty($data['logo'])) 
      <img src="{{ \Wh::logo_payment(@$data['logo']) }}" style="max-height: 70px;" />
         <input name="nologo"  type="checkbox"  value="nologo" /> No logo
      @endif
      <br />
   </td> 
 </tr>
  <tr>
    <th>{{ _l('Description') }}</th>
    <td>
       <textarea name="description" class="form-control">{{ @$data['description'] }}</textarea>
       <br /> 
   </td> 
  </tr>
   <tr>
    <th>{{ _l('Instruction') }}</th>
    <td>
       <textarea name="instruction" class="form-control">{{ @$data['instruction'] }}</textarea>
       <br /> 
   </td> 
  </tr>                                               
    
         
  </tbody>
 </table>