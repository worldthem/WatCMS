  <input  type="hidden" name="value1[fields][name][]" value="{{@!empty($row['fields']['label'][$i])? @$row['fields']['label'][$i] : 'random'}}"/>

 <ul>
     <li>
         <label> {{_l("Caption")}}: <br />
           <input class="form-control"  type="text" name="value1[fields][label][]" value="{{@$row['fields']['label'][$i]}}"/>
         </label>    
    </li>
    <li>
         <label> {{_l("Placeholder")}}: <br />
           <input class="form-control"  placeholder="Placeholder" type="text" name="value1[fields][placeholder][]" value="{{@$row['fields']['placeholder'][$i]}}"/>
         </label>    
    </li>
    <li>
            <label> {{_l("Type")}}: <br />
             <select class="form-control" name="value1[fields][type][]" >
               <option value="text" {{ @$row['fields']['type'][$i]=="text" ? 'selected="yes"':""}} >{{ _l("Text box")}}</option>
               <option value="email" {{ @$row['fields']['type'][$i]=="email" ? 'selected="yes"':""}} >{{ _l("E-mail text box")}}</option>
               <option value="textarea" {{ @$row['fields']['type'][$i]=="textarea" ? 'selected="yes"':""}} >{{ _l("Message text box")}}</option>
             </select>
            </label> 
   </li>
    <li class="checkboxLi"> 
          <label> <br />{{ _l("Required")}} 
           <input type="checkbox" name="value1[fields][required][]" value="yes" {{@$row['fields']['required'][$i]=="yes" ? 'checked="yes"':""}}/>  
         </label>
   </li>
   
   <li> 
      <br /> 
     <a href="#" class="fa_delete delete_field"> </a>
  </li>
 </ul>