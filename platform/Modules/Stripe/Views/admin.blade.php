 
<table class="table_admin_settings">
 <tbody>

 <tr>
    <th>{{ _l('Title') }}</th>
    <td>
      <input class="form-control" name="title" value="{{ $data['title'] or 'Pay by card' }}" type="text">  
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
   </td> 
 </tr>
  <tr>
    <th>{{ _l('Description') }}</th>
    <td>
       <textarea name="description" class="form-control">{{ @$data['description'] }}</textarea> 
   </td> 
 </tr>                                               
 
     <tr>
        <th>{{ _l('Publishable key') }}</th>
        <td>
          <input class="form-control" name="pk_publish" value="{{ @$data['pk_publish'] }}" type="text">  
       </td> 
     </tr>
     <tr>
        <th>{{ _l('Secret key') }}</th>
        <td>
          <input class="form-control" name="sk_secret" value="{{ @$data['sk_secret'] }}" type="text">  
       </td> 
     </tr>
     
           
  </tbody>
 </table>