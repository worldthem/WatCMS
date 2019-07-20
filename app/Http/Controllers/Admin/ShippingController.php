<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Shippcountry;
use App\Modules\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($country="",$shipping="")
    {
        $country_list = Shippcountry::get();
        $shipping =  !empty($country)? Shipping::where('country',$country)->paginate(50) : 
                                       Shipping::orderby('id','desc')->paginate(50);
        
        
       return view('admin.pages.shipping', ['countries'=>$country_list,'selected_country'=>$country,'shipping'=>$shipping]);
    }

  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
        $type_shipping = @$request->input('type_shipping');
        $shipping_name = @$request->input('shipping_name');
        $country = @$request->input('country');
        $weight = @$request->input('weight');
        $price = @$request->input('price');
        $free_delivery = @$request->input('free_delivery');
        
        $field = @$request->input('field');
        $id = @$request->input('id');
        $data = @$request->input('data');
        
        $data = !empty($field)?
          [ $field  =>$data ]: 
          [  'type_shipping'  =>$type_shipping, 
             'shipping_name' =>$shipping_name,
             'country' =>empty($country)? 0:$country,
             'weight' =>empty($weight)? 0: $weight,
             'free_delivery' => empty($free_delivery) ? 0 : $free_delivery,
             'price' => empty($price) ? 0 : $price, 
            ];
          
            //print_r($data);
          Shipping::updateOrCreate(
                          ['id' => $id ], $data
                         );
         
       return  !empty($field)? "<span class='fa_publish'></span>": redirect()->back();
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_bulk(Request $request)
    {
          $productid = $request->input('productid');
           $action = $request->input('action');
          if(!empty($action) && empty($s)){
              
              foreach ($productid as $val){
                 if($action=='del'){
                         Shipping::where('id', $val)->delete();
                     }elseif($action=='2' || $action=='3'){
                         Shipping::where('id', $val)->update(["hide_show"=>$action]);
                     } 
                     
                 }
           }
      return redirect()->back() ;
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    { 
        Shipping::where('id', $id)->delete();
       return redirect()->back() ;            
    }   
}
