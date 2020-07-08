<?php namespace App\Http\Controllers;

  use Session;
  use Alert;
  use PDF;
  use Excel;
  use DB;
  use Redirect;
  use Cache;
  use Image;
  use Route;
  use Schema;
  use Storage;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Validator;
  use Illuminate\Support\Facades\Input;
  class AdminTicketController extends Controller {

      //By the way, you can still create your own method in here... :)

    public function getTicketManagement() {
      //First, Add an auth
       
       //Create your own query 
       $data = [];
       $data['page_title'] = 'Ticket Management';
       $data['result'] = DB::table('t_ticket')
                        ->join('ms_project', 't_ticket.id_project', '=', 'ms_project.id')
                        ->join('ms_ticket_status', 't_ticket.status', '=', 'ms_ticket_status.id')
                        ->join('ms_priority', 't_ticket.priority', '=', 'ms_priority.id')
                        ->select('t_ticket.*', 'ms_ticket_status.name as status_name', 'ms_project.name as project_name', 'ms_project.code_project as code_project', 'ms_priority.name as priority_name', 'ms_priority.type as priority_type')
                        ->orderby('id','desc')
                        ->get();
       // dd($data['result']);
       $data['project'] = DB::table('ms_project')->get();
       $data['priority'] = DB::table('ms_priority')->get();
       // $data['all'] = DB::table('t_ticket')->orderby('id','desc')->get();
        
       //Create a view. Please use `cbView` method instead of view method from laravel.
       return view('Page.index_ticket_management',$data);
    }
    public function saveAddTicket(Request $request)
    {
        $bug_desc = $request->input('bug_desc');
        $priority_d = $request->input('priority_d');
        $photo = $request->file('photo');
        $top = DB::table('t_ticket')
                    ->orderBy('code_ticket','desc')
                    ->first();
        if ($top == null) {
          $top_id = 1;
        } else {
          $top_id = substr($top->code_ticket,2,4) + 1;
        }
        $date_now_ymd = date("Y-m-d");
        if ($top_id >= 1000) {
          $new_id = "TC" . $top_id;
        } else if ($top_id >= 100) {
          $new_id = "TC0" . $top_id;
        } else if ($top_id >= 10) {
          $new_id = "TC00" . $top_id;
        } else if ($top_id < 10) {
          $new_id = "TC000" . $top_id;
        } else{
          $new_id = "TC" . $top_id;
        }
        
        // dd($new_id);

        $sql = DB::insert("INSERT INTO t_ticket (
                    code_ticket,
                    id_project,
                    id_tester,
                    deadline,
                    priority,
                    status,
                    created_at,
                    updated_at)
                    values (
                        '$new_id',
                        '".$request->input('project')."',
                        '".session('id')."',
                        '".$request->input('deadline')."',
                        '".$request->input('priority')."',
                        1,
                        '".$date_now_ymd."',
                        '".$date_now_ymd."')");

        for($a = 0; $a < count($bug_desc); $a++)
        {
          $bug_img_link = '';
            if ($photo[$a] != null) {
              # code...
              $uploadedFile = $photo[$a];    
              $name = $uploadedFile->getClientOriginalName();
              // dd($name);
              $path = session('id').'/'.date('Y-m-d-H');
              Storage::disk('coba')->makeDirectory($path);
              Storage::disk('coba')->putFileAs($path.'/', $uploadedFile, $name);
              if ($request->hasFile('photo')) {
                  //
                  $bug_img_link = 'uploads/'.$path.'/'.$name;
              }
            }
          $saveDetailLaundry = DB::insert("INSERT INTO t_detail_ticket (
                    code_ticket,
                    bug_desc,
                    priority,
                    bug_img,
                    status)
                    values (
                        '".$new_id."',
                        '".$bug_desc[$a]."',
                        '".$priority_d[$a]."',
                        '".$bug_img_link."',
                        1)");
        }
        if($sql){
            $response["value"] = 1;
            $response["message"] = "Sukses tambah data";
            echo json_encode($response); //merubah respone menjadi JsonObject
            return redirect()->route('getTicketManagement');
        }else{
            $response["value"] = 0;
            $response["message"] = "Gagal tambah data";
            echo json_encode($response); //merubah respone menjadi JsonObject
        }
    }
    public function editTicket(Request $request)
    {
        $bug_desc = $request->input('bug_desc');
        $priority_d = $request->input('priority_d');
        $edit_bug_desc = $request->input('edit_bug_desc');
        $edit_priority_d = $request->input('edit_priority_d');
        $edit_detail_id = $request->input('edit_detail_id');
        $id = $request->input('id');
        $code_ticket = $request->input('code_ticket');
        $photo = $request->file('photo');
        $edit_photo = $request->file('edit_photo');
        
        // dd(count($edit_photo));

        $sql = DB::update("UPDATE t_ticket set 
                        id_project = '".$request->input('project')."',
                        deadline = '".$request->input('deadline')."',
                        priority = '".$request->input('priority')."'
                        where id=".$id);
            // dd($request->file('edit_photo'.$edit_detail_id));
        if ($edit_detail_id != null) {
          for($b = 0; $b < count($edit_detail_id); $b++)
            {
        // dd($request->file('edit_photo'.$edit_detail_id));
          $bug_img_link = '';
            if ($request->file('edit_photo'.$edit_detail_id[$b]) != null) {
              # code...
              $uploadedFile = $request->file('edit_photo'.$edit_detail_id[$b]);    
              $name = $uploadedFile->getClientOriginalName();
              // dd($name);
              $path = session('id').'/'.date('Y-m-d-H');
              Storage::disk('coba')->makeDirectory($path);
              Storage::disk('coba')->putFileAs($path.'/', $uploadedFile, $name);
              if ($request->hasFile('edit_photo'.$edit_detail_id[$b])) {
                  //
                  $bug_img_link = 'uploads/'.$path.'/'.$name;
              }
            }
            if ($request->file('edit_photo'.$edit_detail_id[$b]) != null) {
              # code...
              $saveEditLokasi = DB::update("UPDATE t_detail_ticket set 
                        bug_desc = '".$edit_bug_desc[$b]."',
                        bug_img = '".$bug_img_link."',
                        priority = '".$edit_priority_d[$b]."'
                        where id=".$edit_detail_id[$b]);
            } else {
              # code...
              $saveEditLokasi = DB::update("UPDATE t_detail_ticket set 
                        bug_desc = '".$edit_bug_desc[$b]."',
                        priority = '".$edit_priority_d[$b]."'
                        where id=".$edit_detail_id[$b]);
            }
            
            }
        }
        // dd(count($bug_desc));
        if ($bug_desc != null) {
          for($a = 0; $a < count($bug_desc); $a++)
          {
          // dd($code_ticket);
            $bug_img_link_add = '';
            if ($photo[$a] != null) {
              # code...
              $uploadedFile = $photo[$a];    
              $name = $uploadedFile->getClientOriginalName();
              // dd($name);
              $path = session('id').'/'.date('Y-m-d-H');
              Storage::disk('coba')->makeDirectory($path);
              Storage::disk('coba')->putFileAs($path.'/', $uploadedFile, $name);
              if ($request->hasFile('photo')) {
                  //
                  $bug_img_link_add = 'uploads/'.$path.'/'.$name;
              }
            }
            $saveDetailLaundry = DB::insert("INSERT INTO t_detail_ticket (
                      code_ticket,
                      bug_desc,
                      priority,
                      bug_img,
                      status)
                      values (
                          '".$code_ticket."',
                          '".$bug_desc[$a]."',
                          '".$priority_d[$a]."',
                          '".$bug_img_link_add."',
                          1)");
          }
        }
            return redirect()->route('getTicketManagement');
        // if($sql){
        //     $response["value"] = 1;
        //     $response["message"] = "Sukses tambah data";
        //     echo json_encode($response); //merubah respone menjadi JsonObject
        // }else{
        //     $response["value"] = 0;
        //     $response["message"] = "Gagal tambah data";
        //     echo json_encode($response); //merubah respone menjadi JsonObject
        // }
    }

      public function editCustomer(Request $request)
      {
          // dd($request->all());
          $lokasi_name = $request->input('lokasi_name');
          $edit_lokasi_id = $request->input('edit_lokasi_id');
          $edit_lokasi_name = $request->input('edit_lokasi_name');
          $id = $request->input('edit_id');
          $province = DB::table('tbl_propinsi')->where('id',$request->input('edit_province'))->first();
          $id_company = DB::table('m_company')->where('id', $id)->first();
          // dd($id);
          $companyData = Company::find($id);
          $companyData->company_name = $request->input('edit_company_name');
          $companyData->company_code = $request->input('edit_company_code');
          $companyData->address = $request->input('edit_address');
          $companyData->province = $province->nama;
          $companyData->city = $request->input('edit_city');
          $companyData->postal_code = $request->input('edit_postal_code');
          if ($request->input('edit_company_contact') != null) {
          $companyData->company_contact = $request->input('edit_company_contact');
          } else {
          $companyData->company_contact = '-';
          }
          if ($request->input('edit_company_contact') != null) {
          $companyData->company_email = $request->input('edit_email');
          } else {
          $companyData->company_email = '-';
          }
          $companyData->npwp = $request->input('edit_npwp');
          $companyData->contact_person = $request->input('edit_contact_person');
          $companyData->cp_email = $request->input('edit_cp_email');
          $companyData->cp_contact = $request->input('edit_cp_contact');
          $companyData->save();
          if ($edit_lokasi_id != null) {
            for($b = 0; $b < count($edit_lokasi_id); $b++)
              {
                $saveEditLokasi = DB::table('m_lokasi_bongkar')
                      ->where('id',$edit_lokasi_id[$b])
                          ->update([
                              'name'  => $edit_lokasi_name[$b] ,
                              'updated_at'   => date('Y-m-d H:i:s')
                          ]);
              }
          }
          
      if ($lokasi_name != null) {
        for($a = 0; $a < count($lokasi_name); $a++)
        {
          $saveNewLokasi = DB::table('m_lokasi_bongkar')
            ->insertGetId([
              'name' => $lokasi_name[$a],
              'id_company' => $id,
              'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
      }
          return redirect()->route('getCustomerManagement');
      }
      public function saveAddCustomer(Request $request)
      {
          // dd($id);
          $province = DB::table('tbl_propinsi')->where('id',$request->input('province'))->first();
          $lokasi_name = $request->input('lokasi_name');
          $companyData = new Company;
          $companyData->id_agen = session('id');
          $companyData->company_name = $request->input('company_name');
          $companyData->company_code = $request->input('company_code');
          $companyData->address = $request->input('address');
          $companyData->province = $province->nama;
          $companyData->city = $request->input('city');
          $companyData->postal_code = $request->input('postal_code');
          if ($request->input('company_contact') != null) {
          $companyData->company_contact = $request->input('company_contact');
          } else {
          $companyData->company_contact = '-';
          }
          if ($request->input('company_contact') != null) {
          $companyData->company_email = $request->input('email');
          } else {
          $companyData->company_email = '-';
          }
          $companyData->npwp = $request->input('npwp');
          $companyData->contact_person = $request->input('contact_person');
          $companyData->cp_email = $request->input('cp_email');
          $companyData->cp_contact = $request->input('cp_contact');
          $companyData->status = 1;
          $companyData->save();
      for($a = 0; $a < count($lokasi_name); $a++)
      {
        $saveDetailLaundry = DB::table('m_lokasi_bongkar')
          ->insertGetId([
            'name' => $lokasi_name[$a],
            'id_company' => $companyData->id,
            'created_at' => date('Y-m-d H:i:s'),
          ]);
      }
          return redirect()->route('getCustomerManagement');
      }
    public function deleteTicket($id) {
      //First, Add an auth
      $row = DB::table('t_ticket')->where('id', $id)->first();
      
      $deleteDetail = DB::table('t_detail_ticket')->where('code_ticket', $row->code_ticket)->delete();
      $deleteTicket = DB::table('t_ticket')->where('id', $id)->delete();
       //Create a view. Please use `cbView` method instead of view method from laravel.
          
      return redirect()->route('getTicketManagement');
    }

  }