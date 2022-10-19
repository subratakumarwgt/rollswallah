<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use App\Models\Contact;
use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Product;
use App\Models\Slots;
use App\Models\StaticAsset;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminDashboardController extends Controller
{
    //
    public function __construct(Request $request)
  {
    $this->table = @$request->table_name;
    $this->model = @$request->table_model;
    $this->errorMessage = "Sorry! Something went wrong";
    $this->api_key = 'rzp_test_zyjdsYczp0XCJh';
    $this->secret_key = 'tWkIxUcqup9ohJc7GnweJxHo';
  }
    public function verifyBroadcast(Request $request){
        
        return response(['status'=>true,'data'=>$request->all()],200);
    }
    public function slotDelete($id){
        $p = Slots::find($id);
        if ($p->delete()) {
           return redirect()->back()->with('message','Slot deleted successfully');
        }
       
    }
    public function slotUpdate(Request $request,$id){
      // dd($request->all());
        $validator_member = Validator::make($request->all(), [
            'free_slots'  => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);
        if ($validator_member->fails()) {
            
            return redirect()->back()->with('message','Invalid input. Slot update failed');
           
        }     
        else{
        $s = Slots::find($id);
        $data = $request->all();
        unset($data['_token']);
        if ($s->update($request->all())) {
            return redirect()->back()->with('message','Slot updated successfully');
        }
        }  
    }
    public function slotList(Request $request){
        $slots = Slots::groupBy('doctor_id')->select('*')->selectRaw('sum(free_slots) as slots'); 
        $centres = Centre::whereIn('type',['chamber','clinic'])->get();
        if (isset($request->from_date) && !empty($request->from_date)) {
            $slots = $slots->whereDate('date','>=',$request->from_date);
        }
        if (isset($request->to_date) && !empty($request->to_date)) {
            $slots = $slots->whereDate('date','>=',$request->to_date);
        }
        if (isset($request->doctor_id) && !empty($request->doctor_id)) {
            $slots = $slots->where('doctor_id',$request->doctor_id);
        }
        if (isset($request->centre_id) && !empty($request->centre_id)) {
            $slots = $slots->where('centre_id',$request->centre_id);
        }
        $slots = $slots->paginate(5);        
        return view('adminpanel.slots.slotlist',['slots'=>$slots,'centres'=>$centres]);
    }
    public function dashboard(){
        return view('adminpanel.dashboard');
    }
    public function contactList(){
      
      $regions = StaticAsset::getAssetsByTitle("customer_regions");
        
        return view('adminpanel.contacts.contactlist',["regions" => $regions]);
    }
    public function onlineUsers(){
      return view('adminpanel.users.onlineusers');
  }
   public function chats()
   {
    return view('adminpanel.chats.chat');
   }

    public function contactDelete($id){
        Contact::find($id)->delete();
        return redirect()->back()->with('message',"Contact deleted successfully");
    }
    public function contactImport(){
        return view('adminpanel.contacts.contactimport');
    }
    public function contactImportData(Request $request){
        
        $data = json_decode($request->data);
        $newdata = [];
        foreach ($data as $key => $value) {
            foreach ($value as $k => $val) {
                $dd = trim($k);
                $newdata[$key][$dd] = trim($val);
            }
        }
        $newdata = json_decode(json_encode($newdata));      
        $success = 0;
        $failed = 0;
        foreach ($newdata as $key => $value) {       
            $member_array = array(
                'name' => @$value->name,
                'number' => @$value->number,
                'address' => @$value->address,
                'region' => @$value->region,
                
            );
            $validator_member = Validator::make($member_array, [
                'number'  => 'required|unique:contacts|min:10|max:12',
                'name' => 'max:255',
                'region' => 'required|string|min:1|max:255',
                'address' => "max:255",
            ]);
            if ($validator_member->fails()) {
                $failed++;
                $result['failed'][] = array_merge($member_array, array('error' => $validator_member->errors(), 'id' => 'tr_' . $key));
                continue;
            }            
            try {
                $row = \App\Models\Contact::create($member_array);
                $success++;
                $result['success'][] = array_merge($member_array, array('id' => 'tr_' . $key, 'new_id' => $row->id,'contact'=>$row->number,'name'=>$row->number,'address'=>$row->address,'region'=>$row->region));
            } catch (\Throwable $th) {
                $failed++;
                $result['failed'][] = array_merge($member_array, array('error' => $th->getMessage(), 'id' => 'tr_' . $key));
            }
        }
        $create_log = array(
            'success' => $success,
            'failed' => $failed,
            'total' => count($data),
            'content_json' => json_encode($result)
        );
        $this->logger("import_result_".date('d_M_Y'),$create_log);
        return response(array('status' => true, 'data' => array('success' => $success, 'failed' => $failed, 'result' => $result)), 200);
    }
    
    public function contactBind(Request $request)
    {
      $draw = $request->draw;
        
      $start = $request->start;
      $rowperpage = $request->length; 
  
      $columnIndex_arr = $request->order;
    
      $columnName_arr = $request->columns;
      $order_arr = $request->order;
      $search_arr = $request->search;  
      $columnIndex = $columnIndex_arr[0]['column']; 
      $columnName = $columnName_arr[$columnIndex]['data']; 
      $columnSortOrder = @$order_arr[0]['dir']; 
      $searchValue = @$search_arr['value']; 
      $recordsQuery = new Contact;
      $sort=0;
      if($searchValue!=""){
        $sort=1;
        $_SESSION['key'] = $searchValue;
        $recordsQuery=$recordsQuery->where('name', 'LIKE', '%' .$_SESSION['key']. '%')
        ->orWhere('number', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('region', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('address', 'LIKE', '%' . $_SESSION['key']. '%');
    }
    if (isset($request->status) && !empty($request->status)) {
        $recordsQuery = $recordsQuery->where('status',$request->status);
    }
    if (isset($request->region) && !empty($request->region)) {
        $recordsQuery = $recordsQuery->where('region',$request->region);
    }
    if (isset($request->fromDate) && !empty($request->fromDate)) {
        $recordsQuery = $recordsQuery->whereDate('created_at','>=',$request->fromDate);
    }
    if (isset($request->toDate) && !empty($request->toDate)) {
        $recordsQuery = $recordsQuery->whereDate('created_at','<=',$request->toDate);
    }
      $totalRecords = $recordsQuery->count();
      $totalRecordswithFilter = $recordsQuery->count();
  
      $records =  $recordsQuery->skip($start)
                    ->take($rowperpage)
                    ->get();
  
    $data_arr = array();
      $i=1;
      foreach($records as $record){
          $sl_no=$i;
          $id  = $record->id;
          $Company_name=$record->name;
          $address=$record->address;
          $region=$record->region;
          $contact=$record->number;
          if ($record->status == "unchecked") {
            $notes="<span class='badge badge-danger'>".$record->status."</span>";
          }
          else{
            $notes="<span class='badge badge-success'>".$record->status."</span>";
          }
         
          $entry="<span class='small'>".date("d M, Y",strtotime($record->created_at))."</span>";
          $action = '<a href='.'/admin/edit-contact/'.$id.' class="btn btn-sm btn-primary m-1"><i class="fa fa-edit"></i></a><a href='.'/management/contact/delete/'.$id.' class="btn btn-sm btn-danger m-1"><i class="fa fa-minus-circle"></i></a>';
          $data_arr[] = array(
            "Name"     =>$Company_name,
            "Contact"     =>$contact,
            "Address"     =>$address,
            "Region"        =>$region,           
            "Action"      =>$action,
            "Entry Date"      =>$entry,
            'Notes'  =>$notes
          );
          $i++;
  
      }
  
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordswithFilter,
          "aaData" => $data_arr
      );
    
    echo json_encode($response);
    }

    public function centreList(){
        return view('adminpanel.centres.centrelist');
    }
    public function centreEdit($id){
        $centre = Centre::find($id);
        if (!empty($centre->doctors_list_json)) {
            $doctor = json_decode($centre->doctors_list_json,true);
            $doctors = Doctor::whereIn('id',$doctor)->get();
            $x_doctors = Doctor::whereNotIn('id',$doctor)->get();
     
        }
        else{
            $doctors = Doctor::all();
            $x_doctors=[];
        }
        if (!empty($centre->tests_list_json)) {
       $test = json_decode($centre->tests_list_json,true);
       $tests = Diagnosis::whereIn('id',$test)->get();
       $x_tests = Diagnosis::whereNotIn('id',$test)->get();
        }
        else{
            $tests = Diagnosis::all(); 
            $x_tests=[];
        }
        return view('adminpanel.centres.centreedit',['centre'=>$centre,'doctors'=>@$doctors,'x_doctors'=>@$x_doctors,'tests'=>@$tests,'x_tests'=>@$x_tests]);
    }
    public function centreDelete($id){
      
        Centre::find($id)->delete();
        return redirect()->back()->with('message',"Centre deleted successfully");
    }
    public function centreImport(){
        return view('adminpanel.centres.centreimport');
    }    
    public function centreBind(Request $request)
    {
      $draw = $request->draw;
        
      $start = $request->start;
      $rowperpage = $request->length; 
  
      $columnIndex_arr = $request->order;
    
      $columnName_arr = $request->columns;
      $order_arr = $request->order;
      $search_arr = $request->search;  
      $columnIndex = $columnIndex_arr[0]['column']; 
      $columnName = $columnName_arr[$columnIndex]['data']; 
      $columnSortOrder = @$order_arr[0]['dir']; 
      $searchValue = @$search_arr['value']; 
      $recordsQuery = new Centre;
      $sort=0;
      if($searchValue!=""){
        $sort=1;
        $_SESSION['key'] = $searchValue;
        $recordsQuery=$recordsQuery->where('name', 'LIKE', '%' .$_SESSION['key']. '%')
        ->orWhere('type', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('details', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('address', 'LIKE', '%' . $_SESSION['key']. '%');
    }
    if (isset($request->type) && !empty($request->type)) {
        $recordsQuery = $recordsQuery->where('type',$request->type);
    }
    if (isset($request->address) && !empty($request->address)) {
        $recordsQuery = $recordsQuery->where('address',$request->address);
    }
  
      $totalRecords = $recordsQuery->count();
      $totalRecordswithFilter = $recordsQuery->count();
  
      $records =  $recordsQuery->skip($start)
                    ->take($rowperpage)
                    ->get();
  
    $data_arr = array();
      $i=1;
      foreach($records as $record){
          $sl_no=$i;
          $id  = $record->id;
          $Company_name="<span class='badge badge-outline-success text-dark'>".$record->name."</span>";
          $address="<span class='small text-dark'>".$record->address."</span>";
          $details=$record->details;
          $type=$record->type;
          $image = "<img src='/".$record->image."' class='img-fluid' width='80px'>";
          if ($record->type == "clinic") {
            $notes="<span class='badge badge-success'><i class='fas fa-stethoscope'></i> ".strtoupper($record->type)."</span>";
          }
          else{
            $notes="<span class='badge badge-primary'><i class='fas fa-diagnoses'></i></i> ".strtoupper($record->type)."</span>";
          }
         
       
          $action = '<a href='.'/management/centre/edit/'.$id.' class="btn btn-sm btn-primary m-1"><i class="fa fa-edit"></i></a><a href='.'/management/centre/delete/'.$id.' class="btn btn-sm btn-danger m-1"><i class="fa fa-minus-circle"></i></a>';
          $data_arr[] = array(
            "Image"      =>$image,
            "Name"     =>$Company_name,
            "Address"     =>$address,
            "Type"     =>$notes,
            "Contact"        =>$details,               
            "Action"      =>$action,
            
          );
          $i++;
  
      }
  
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordswithFilter,
          "aaData" => $data_arr
      );
    
    echo json_encode($response);
    }
    
    public function doctorImport(){
        $centres = Centre::all();
        return view("adminpanel.doctors.doctorimport",['centres'=>$centres]);
    }
    public function doctorList(){
        $centres = Centre::all();
        return view("adminpanel.doctors.doctorlist",['centres'=>$centres]);
    }
    public function doctorBind(Request $request)
    {
      $draw = $request->draw;
        
      $start = $request->start;
      $rowperpage = $request->length; 
  
      $columnIndex_arr = $request->order;
    
      $columnName_arr = $request->columns;
      $order_arr = $request->order;
      $search_arr = $request->search;  
      $columnIndex = $columnIndex_arr[0]['column']; 
      $columnName = $columnName_arr[$columnIndex]['data']; 
      $columnSortOrder = @$order_arr[0]['dir']; 
      $searchValue = @$search_arr['value']; 
      $recordsQuery = new Doctor;
      $sort=0;
      if($searchValue!=""){
        $sort=1;
        $_SESSION['key'] = $searchValue;
        $recordsQuery=$recordsQuery->where('name', 'LIKE', '%' .$_SESSION['key']. '%')
        ->orWhere('degree_json', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('specialist', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('medical_history', 'LIKE', '%' . $_SESSION['key']. '%');
    }
    if (isset($request->gender) && !empty($request->gender)) {
        $recordsQuery = $recordsQuery->where('gender',$request->gender);
    }
    if (isset($request->chamber) && !empty($request->chamber)) {
        $recordsQuery = $recordsQuery->where('centre_id_json', 'LIKE', '%' . $request->chamber. '%');
    }
  
      $totalRecords = $recordsQuery->count();
      $totalRecordswithFilter = $recordsQuery->count();
  
      $records =  $recordsQuery->skip($start)
                    ->take($rowperpage)
                    ->get();
  
    $data_arr = array();
      $i=1;
      foreach($records as $record){
          $sl_no=$i;
          $id  = $record->id;
          $Company_name="<span class='badge badge-outline-success text-dark'>Dr. ".$record->name."</span>";
          $specialist="<span class='small text-dark'>".$record->specialist."</span>";
         
            $degrees = json_decode($record->degree_json,true);
            $degree_mat = "";
            if (!empty($degrees)) {
            foreach ($degrees as $key => $value) {
               $degree_mat= $degree_mat. "<span class='badge badge-info m-1'> ".$value."</span>";
            }
            }   
           $degree =  $degree_mat;
          // echo $degree;die;
        
         
            $chambers = json_decode($record->centre_id_json);
        
            $chambers = Centre::whereIn('id',$chambers)->get();
            $degree_format = "";
            if (!empty($chambers)) {               
                foreach ($chambers as $key => $value) {
                   $degree_format = $degree_format. "<span class='badge badge-primary m-1'> ".@$value->name."</span><br>";
                }
            }
            
           
           $chamber =  $degree_format;
        
          $experience=$record->experience." <small>years</small>";
          $image = "<img src='/".$record->image."' class='img-fluid' width='80px'>";
          $fees = "<ul>"
          ."<li class='badge badge-primary'>Fees: <i class='fa fa-inr'></i> ".$record->full_charge."</li>"
          ."<li class='badge badge-secondary'>Adv: <i class='fa fa-inr'></i> ".$record->booking_charge."</li>"
          ."</ul>";
        
            $frequency="<span class='badge badge-success'><i class='fas fa-calender'></i> ".strtoupper($record->visit_frequency)."</span>";
          
         
       
          $action = '<a href='.'/management/doctor/edit/'.$id.' class="btn btn-sm btn-primary m-1"><i class="fa fa-edit"></i></a><a href='.'/management/doctor/delete/'.$id.' class="btn btn-sm btn-danger m-1"><i class="fa fa-minus-circle"></i></a>';
          $data_arr[] = array(
            "Image"      =>$image,
            "Name"     =>$Company_name,
            "Specialist"     =>$specialist,
            "Degrees"     =>$degree,
            "Visit Frequency" => $frequency,
            "Chambers"        =>$chamber,
            "Experience"=>$experience ,
            "Fees Structure"=>$fees,               
            "Action"      =>$action,
            
          );
          $i++;
  
      }
  
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordswithFilter,
          "aaData" => $data_arr
      );
    
    echo json_encode($response);
    }
    public function doctorEdit($id){
        $doctor = Doctor::find($id);
        $centres =Centre::all();
        $weekdays = array(
            ['no'=>1,'day'=>"Sunday"],
            ['no'=>2,'day'=>"Monday"],
            ['no'=>3,'day'=>"Tuesday"],
            ['no'=>4,'day'=>"Wednesday"],
            ['no'=>5,'day'=>"Thursday"],
            ['no'=>6,'day'=>"Friday"],
            ['no'=>7,'day'=>"Saturday"],
        );
       
        return view('adminpanel.doctors.doctoredit',['centres'=>$centres,'doctor'=>$doctor,'weekdays'=>$weekdays]);
    }
    public function assetList(){
        return view("adminpanel.assets.assetlist");
    }
    public function assetEdit($id){
        $asset = StaticAsset::find($id);
        return view("adminpanel.assets.assetedit",['asset'=>$asset]);
    }
    public function assetBind(Request $request)
    {
      $draw = $request->draw;
        
      $start = $request->start;
      $rowperpage = $request->length; 
  
      $columnIndex_arr = $request->order;
    
      $columnName_arr = $request->columns;
      $order_arr = $request->order;
      $search_arr = $request->search;  
      $columnIndex = $columnIndex_arr[0]['column']; 
      $columnName = $columnName_arr[$columnIndex]['data']; 
      $columnSortOrder = @$order_arr[0]['dir']; 
      $searchValue = @$search_arr['value']; 
      $recordsQuery = new StaticAsset;
      $sort=0;
      if($searchValue!=""){
        $sort=1;
        $_SESSION['key'] = $searchValue;
        $recordsQuery=$recordsQuery->where('title', 'LIKE', '%' .$_SESSION['key']. '%')
        ->orWhere('list_json', 'LIKE', '%' . $_SESSION['key']. '%');
    }
   
      $totalRecords = $recordsQuery->count();
      $totalRecordswithFilter = $recordsQuery->count();
  
      $records =  $recordsQuery->skip($start)
                    ->take($rowperpage)
                    ->get();
  
    $data_arr = array();
      $i=1;
      foreach($records as $record){
          $sl_no=$i;
          $id  = $record->id;
          $title="<span class='h5'>".$record->title."</span>";
         $asset_type = $record->asset_key;
         
            $degrees = json_decode($record->list_json);
            $degree_format = "";
            if (!empty($degrees)) {
            foreach ($degrees as $key => $value) {
               $degree_format.= "<span class='badge badge-info m-1'> ".@strtoupper($value)."</span> ";
            }
        }   
           $degree =  $degree_format;  
         
           
        
       
          $action = '<a href='.'/management/asset/edit/'.$id.' class="btn btn-sm btn-primary m-1"><i class="fa fa-edit"></i></a><a href='.'/management/asset/delete/'.$id.' class="btn btn-sm btn-danger m-1"><i class="fa fa-minus-circle"></i></a>';
          $data_arr[] = array(
            "Asset Title"      =>$title,
            "Asset List"     =>$degree,
            "Action"=>$action
          
          );
          $i++;
  
      }
  
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordswithFilter,
          "aaData" => $data_arr
      );
    
    echo json_encode($response);
    }
    public function assetDelete($id){
        StaticAsset::find($id)->delete();
        return redirect()->back()->with("message","Asset Deleted successfully");
    }
    public function doctorDelete($id){
        $doctor = Doctor::find($id);
        $doctor->visits->delete();
        $doctor->delete();
        return redirect()->back()->with("message","Doctor Deleted successfully");
    }
    public function productList(){
      $sub_categories = json_decode(StaticAsset::where('title','product_sub_categories')->first()->list_json);
      $categories = json_decode(StaticAsset::where('title','product_categories')->first()->list_json);
      return view("adminpanel.products.productlist",['sub_categories'=>$sub_categories,'categories'=>$categories]);

    }
    public function productExcelImport(){
        $sub_categories = json_decode(StaticAsset::where('title','product_sub_categories')->first()->list_json);
        $categories = json_decode(StaticAsset::where('title','product_categories')->first()->list_json);
        return view("adminpanel.products.productexcelimport",['sub_categories'=>$sub_categories,'categories'=>$categories]);
  
      }
      public function productDelete($id){
       Product::find($id)->delete();
       return redirect()->back()->with('message',"Deleted successfully");
  
      }
    public function productBind(Request $request)
    {
     try {
         $draw = $request->draw;
        
      $start = $request->start;
      $rowperpage = $request->length; 
  
      $columnIndex_arr = $request->order;
    
      $columnName_arr = $request->columns;
      $order_arr = $request->order;
      $search_arr = $request->search;  
      $columnIndex = $columnIndex_arr[0]['column']; 
      $columnName = $columnName_arr[$columnIndex]['data']; 
      $columnSortOrder = @$order_arr[0]['dir']; 
      $searchValue = @$search_arr['value']; 
      $recordsQuery = new Product;
      $sort=0;
      if($searchValue!=""){
        $sort=1;
        $_SESSION['key'] = $searchValue;
        $recordsQuery=$recordsQuery->where('title', 'LIKE', '%' .$_SESSION['key']. '%')
        ->orWhere('category', 'LIKE', '%' . $_SESSION['key']. '%')
        ->orWhere('sub_category', 'LIKE', '%' . $_SESSION['key']. '%')
        ->orWhere('description', 'LIKE', '%' . $_SESSION['key']. '%')
        ->orWhere('tags_json', 'LIKE', '%' . $_SESSION['key']. '%')
        ->orWhere('brand', 'LIKE', '%' . $_SESSION['key']. '%')
         ->orWhere('short_name', 'LIKE', '%' . $_SESSION['key']. '%');
    }
    if (isset($request->status) && !empty($request->status)) {
        $recordsQuery = $recordsQuery->where('status',  $request->status);
    }
    if (isset($request->category) && !empty($request->category)) {
        $recordsQuery = $recordsQuery->where('category', 'LIKE', '%' . $request->category. '%');
    }
    if (isset($request->sub_category) && !empty($request->sub_category)) {
        $recordsQuery = $recordsQuery->where('sub_category', 'LIKE', '%' . $request->sub_category. '%');
    }
   
   
      $totalRecords = $recordsQuery->count();
      $totalRecordswithFilter = $recordsQuery->count();
  
      $records =  $recordsQuery->skip($start)
                    ->take($rowperpage)
                    ->get();
  
    $data_arr = array();
      $i=1;
      foreach($records as $record){
          $sl_no=$i;
          $id  = $record->id;
          $stock  = $record->stock;
          $title=$record->short_name;
          $price =$record->pre_price;
         if (!empty($record->image)) {
           $image = "<img src='/".$record->image."' class='img-fluid' width='100px'>";
         }
         else{
           $image = "<span class='badge badge-warning text-dark'>No Image</span>";
         }
        
         $centre = $record->brand;
            $degrees = json_decode($record->tags_json);
           // dd(json_decode($record->tags_json));
            $degree_format = "";
            if (!empty($degrees)) {
            foreach ($degrees as $key => $value) {
               $degree_format= $degree_format."<span class='badge badge-info m-1'> ".strtoupper($value)."</span> ";
            }
         }   
         
           $degree =  $degree_format;  
           $category = "<span class='badge badge-info m-1'> ".@strtoupper($record->category)."</span> ";
           $sub_category = "<span class='badge badge-warning m-1'> ".@strtoupper($record->sub_category)."</span> ";
         
           
        
       
          $action = '<a href='.'/management/product/edit/'.$id.' class="btn btn-sm btn-primary m-1"><i class="fa fa-edit"></i></a><a href='.'/management/product/delete/'.$id.' class="btn btn-sm btn-danger m-1"><i class="fa fa-minus-circle"></i></a>';
          $data_arr[] = array(
            "Image"      =>$image,
            "Title"     =>$title,
            "MRP"     =>$price,
            "Brand"     =>$centre,
            "Stocks" => $stock,
            "Categories"        =>$category,
            "Sub Categories"=>$sub_category ,
            "Search Tags"=>$degree,               
            "Action"      =>$action,
            
          );
          $i++;
  
      }
  
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordswithFilter,
          "aaData" => $data_arr
      );
    
    echo json_encode($response);
     } catch (\Throwable $e) {
      $this->log_slug = "datatable_error_product_bind";
      $this->logger($this->log_slug . "product", array("data" => $request->all(), "error" => $e->getMessage()));
      die();
     }

    
    }
     public function productImport(){
         $data= [
             'categories'=> StaticAsset::getAssetsByTitle("product_categories"),
             'sub_categories' => StaticAsset::getAssetsByTitle("product_sub_categories"),
             'sources' => Centre::where('type','source')->get(),
             
         ];
        return view("adminpanel.products.productimport",$data);
    }

    public function productEdit($id){
        $product = Product::find($id);
        // dd($product);
        $data= [
            'categories'=> StaticAsset::getAssetsByTitle("product_categories"),
            'sub_categories' => StaticAsset::getAssetsByTitle("product_sub_categories"),
            'sources' => Centre::where('type','source')->get(),
            'product'=>$product,
            'sizes' =>StaticAsset::getAssetsByTitle("product_sizes"),
            'varient_types'=>StaticAsset::getAssetsByTitle("varient_types"),
            
        ];
        return view("adminpanel.products.productedit",$data);

    }
    public function userList(){
        $roles = Role::all();
        return view("adminpanel.users.userlist",["roles"=>$roles]);
    } 

    public function userImport(){
        
        return view("adminpanel.users.userimport");
    }
    public function userBind(Request $request){
        $draw = $request->draw;
        
      $start = $request->start;
      $rowperpage = $request->length; 
  
      $columnIndex_arr = $request->order;
    
      $columnName_arr = $request->columns;
      $order_arr = $request->order;
      $search_arr = $request->search;  
      $columnIndex = $columnIndex_arr[0]['column']; 
      $columnName = $columnName_arr[$columnIndex]['data']; 
      $columnSortOrder = @$order_arr[0]['dir']; 
      $searchValue = @$search_arr['value']; 
      $recordsQuery =User::join('profiles', 'users.id', '=', 'profiles.user_id')->join('addresses', 'users.id', '=', 'addresses.user_id')
      ->select('*');
     
    
;
      $sort=0;
      if($searchValue!=""){
        $sort=1;
        $_SESSION['key'] = $searchValue;
        $recordsQuery=$recordsQuery->where('users.name', 'LIKE', '%' .$_SESSION['key']. '%')
        ->orWhere('users.contact', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('addresses.district', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('addresses.state', 'LIKE', '%' . $_SESSION['key']. '%')->orWhere('addresses.zip_code', 'LIKE', '%' . $_SESSION['key']. '%');
    }
    if (isset($request->status) && !empty($request->status)) {
        $recordsQuery = $recordsQuery->where('status',$request->status);
    }
    if (isset($request->region) && !empty($request->region)) {
        $recordsQuery = $recordsQuery->where('region',$request->region);
    }
    if (isset($request->fromDate) && !empty($request->fromDate)) {
        $recordsQuery = $recordsQuery->whereDate('users.created_at','>=',$request->fromDate);
    }
    if (isset($request->toDate) && !empty($request->toDate)) {
        $recordsQuery = $recordsQuery->whereDate('users.created_at','<=',$request->toDate);
    }
      $totalRecords = $recordsQuery->count();
      $totalRecordswithFilter = $recordsQuery->count();
  
      $records =  $recordsQuery->skip($start)
                    ->take($rowperpage)
                    ->get();
  
    $data_arr = array();
      $i=1;
      foreach($records as $record){
          $sl_no=$i;
          $id  = $record->user_id;
          $user = User::find($id);
          // dd($user->roles->pluck("name"));
          $Company_name=$record->name;
          $address=$record->address_line_1.",".@$record->district.",".@$record->zip_code;
          $profile="<strong class='small'>AGE</strong>: ".$record->age." <small>years</small>, <br> <span class='badge badge-danger'>".@($user->getRoleNames())."</span>";
          $contact=$record->contact;
          if (!empty($record->image)) {
            $image = "<img src='/storage/".$record->image."' class='img-fluid' width='100px'>";
          }
          else{
            $image = "<img src='/storage/profileimage/default.png' class='img-fluid' width='100px'>";
          }
          if ($record->status == "unchecked") {
            $notes="<span class='badge badge-danger'>".$record->status."</span>";
          }
          else{
            $notes="<span class='badge badge-success'>".$record->status."</span>";
          }
          $switch = '<div class="text-center text-end icon-state switch-sm switch-outline p-1 ">
          <label class="switch ">
<input type="checkbox" data-bs-original-title="" title="" data-user_id = "'.$record->user_id.'" class="user_row"><span class="switch-state  bg-success shadow-sm"></span>
      </label>    </div>';
         
          $entry="<span class='small'>".date("d M, Y",strtotime($record->created_at))."</span>";
          $action = '<a href='.'/management/user/edit/'.$id.' class="btn btn-sm btn-primary m-1"><i class="fa fa-edit"></i></a><a href='.'/management/user/delete/'.$id.' class="btn btn-sm btn-danger m-1"><i class="fa fa-minus-circle"></i></a>';
          $data_arr[] = array(
            "Select" =>$switch,
              "Image"=>$image,
            "Name"     =>$Company_name,
            "Contact"     =>$contact,
            "Profile"        =>$profile,     
            "Address"     =>$address,      
            "Joined"      =>$entry,
            "Action"      =>$action,
           
        
          );
          $i++;
  
      }
  
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordswithFilter,
          "aaData" => $data_arr
      );
    
    echo json_encode($response);
    }
    public function userEdit($id){
        $user = User::find($id);
        $profile_checked = "";
        $address_checked = "";
        if (!empty($user->profile())) {
            $profile_checked = "checked";
        }
        if (!empty($user->address())) {
            $address_checked = "checked";
        }
        return view("adminpanel.users.useredit",['user'=>$user,'profile_checked'=>$profile_checked,'address_checked'=>$address_checked]);
    }
    public function productImportData(Request $request)
    {
      $data  = json_decode($request->data,true);
      $success = 0;
      $failed = 0;
      foreach ($data as $key => $value) {
        if ($this->checkProductByName($value['product_name'])) {
          try {
             $insert_array = [
          'short_name'=>$value['product_name'],
          'pre_price'=>$value['mrp'],
          'brand'=>$value['brand'],
          'status'=>0,
         ];
         $success++;
         $product[] = Product::create($insert_array);
            
          } catch (Exception $e) {
         $failed++;   
            continue;
          }
        
        }
        
      }

      return response(array('data'=>[
        'success'=>$success,
        'failed' =>$failed
      ]));
    }
    private function checkProductByName($short_name)
    {
      if (!empty(Product::where('short_name',"LIKE","%".$short_name."%")->count())) {
        return false;
      }
      else
        return true;
    }




    public function contentImport()
    {
        $data= [
            'resources'=> StaticAsset::getAssetsByTitle("resource_types"),
            'content_types'=>StaticAsset::getAssetsByTitle("content_types"),
           
            
        ];
        return view("adminpanel.offers.offerimport",$data);
    }

    public function moduleList(){
       $modules = Module::where("has_child","1")->get();
        return view('adminpanel.modules.modules_list',['modules'=>$modules]);
    }

    public function checkRoute(Request $request)
    {
     
      try{
         $route = route($request->route_name);
         if (!empty($route)) {
          $route = str_replace(url("/"), "", $route);
        return response(array("success"=>true,"data"=>$route),200);
      }
      else{
         return response(array("success"=>false,"message"=>"Wrong route name given/ Route doesn't exist"),200);
      }
      }
      catch(\Throwable $th){
        return response(array("success"=>false,"message"=>"Wrong route name given/ Route doesn't exist"),200);
    
      }
     

      
    }
    
}
