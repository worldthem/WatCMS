<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Comments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = "all", $s="" )
    {
            if($status=="all" && empty($s)){
                 $Comments= Comments::orderby("id",'desc')->paginate(50) ;
            }elseif(!empty($s)){
                 $Comments=  Comments::where("comment_author",'like','%'.$s.'%')
                                     ->orWhere("comment_author",'like','%'.$s.'%')
                                     ->orWhere("comment_author_email",'like','%'.$s.'%')
                                     ->orWhere("comment",'like','%'.$s.'%')
                                     ->orWhere("comment_author_IP",'like','%'.$s.'%')
                                     ->paginate(50);
            }else{
                 $Comments=  Comments::where("status",$status)->orderby("id",'desc')->paginate(50);
            }
         
     
        
        
        return view('admin.pages.comments', ['rows' => $Comments,"getvar" =>  $status]); 
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
           $s = $request->input('s');
          if(!empty($action) && empty($s)){
              
              foreach ($productid as $val){
                 if($action=='del'){
                         Comments::where('id', $val)->delete();
                     }elseif($action=='aprove'){
                         Comments::where('id', $val)->update(["status"=>'2']);
                     }elseif($action=='inaprove'){
                         Comments::where('id', $val)->update(["status"=>'1']);
                     } 
                  }
           }
      return !empty($s)? redirect('/admin/comments/status/all/'.$s) :  redirect()->back() ;
    }

 public function change_status($id, $status=1){
    Comments::where('id', $id)->update(["status"=>$status]);
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
        Comments::where('id', $id)->delete();
       return redirect()->back() ;            
    } 
}
