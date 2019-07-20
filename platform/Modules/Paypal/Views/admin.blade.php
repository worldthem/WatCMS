
<table class="table_admin_settings">
 <tbody>
  <tr>
     <th> {{ _l('Mode') }}</th>
     <td>
        <select name="mode" class="form-control">
            <option value="live">{{ _l('Live') }}</option>
            <option value="sandbox"  {{ $data['mode'] == "sandbox" ? 'selected=""':'' }}>{{ _l('Test mode') }}</option>
       </select>
     </td> 
  </tr>   
 
 <tr>
    <th>{{ _l('Title') }}</th>
    <td>
      <input class="form-control" name="title" value="{{ $data['title'] or 'Paypal' }}" type="text">  
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
        <th>{{ _l('Id') }}</th>
        <td>
          <input class="form-control" name="id" value="{{ @$data['id'] }}" type="text">  
           <p> 
            <a href="https://developer.paypal.com/developer/applications/" target="_blank">
                Get your API test credentials
            </a>
          </p>
       </td> 
     </tr> 
     
      <tr>
        <th>{{ _l('Secret') }}</th>
        <td>
          <input class="form-control" name="secret" value="{{ @$data['secret'] }}" type="text"> 
          <p> 
            <a href="https://developer.paypal.com/developer/applications/" target="_blank">
                Get your API test credentials
            </a>
          </p> 
       </td> 
     </tr>
         
  </tbody>
 </table>