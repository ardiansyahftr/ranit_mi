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
  class AdminProjectController extends Controller {

      //By the way, you can still create your own method in here... :)

    public function getProjectManagement() {
      //First, Add an auth
       
       //Create your own query 
       $data = [];
       $data['page_title'] = 'Project Management';
       if (session('id_role') == 3) {
          $data['result'] = DB::table('ms_project')
                            ->join('ms_project_status', 'ms_project.status', '=', 'ms_project_status.id')
                            ->select('ms_project.*', 'ms_project_status.name as status_name')
                            ->where('id_pm',session('id'))
                            ->orderby('id','desc')
                            ->get();
       } else {
          $data['result'] = DB::table('ms_project')
                            ->join('ms_project_status', 'ms_project.status', '=', 'ms_project_status.id')
                            ->select('ms_project.*', 'ms_project_status.name as status_name')
                            ->orderby('id','desc')
                            ->get();
       }
       $data['project_status'] = DB::table('ms_project_status')->get();
       // $data['all'] = DB::table('ms_project')->orderby('id','desc')->get();
        
       //Create a view. Please use `cbView` method instead of view method from laravel.
       return view('Page.index_project_management',$data);
    }
    public function saveAddProject(Request $request)
    {
        $top = DB::table('ms_project')
                    ->orderBy('code_project','desc')
                    ->first();
        $top_id = substr($top->code_project,2,4) + 1;
        $date_now_ymd = date("Y-m-d");
        if ($top_id >= 1000) {
          $new_id = "PR" . $top_id;
        } else if ($top_id >= 100) {
          $new_id = "PR0" . $top_id;
        } else if ($top_id >= 10) {
          $new_id = "PR00" . $top_id;
        } else if ($top_id < 10) {
          $new_id = "PR000" . $top_id;
        } else{
          $new_id = "PR" . $top_id;
        }
        
        // dd($new_id);

        $sql = DB::insert("INSERT INTO ms_project (
                    code_project,
                    name,
                    id_pm,
                    start_date,
                    deadline,
                    status,
                    created_at,
                    updated_at)
                    values (
                        '$new_id',
                        '".$request->input('name')."',
                        '".session('id')."',
                        '".$request->input('start_date')."',
                        '".$request->input('deadline')."',
                        '".$request->input('status')."',
                        '".$date_now_ymd."',
                        '".$date_now_ymd."')");
        if($sql){
            $response["value"] = 1;
            $response["message"] = "Sukses tambah data";
            echo json_encode($response); //merubah respone menjadi JsonObject
            return redirect()->route('getProjectManagement');
        }else{
            $response["value"] = 0;
            $response["message"] = "Gagal tambah data";
            echo json_encode($response); //merubah respone menjadi JsonObject
        }
    }
    public function editProject(Request $request)
    {
        // dd($request->all());
        $id = $request->input('id');
        $sql = DB::update("UPDATE ms_project set 
                        name = '".$request->input('name')."',
                        status = '".$request->input('status')."',
                        start_date = '".$request->input('start_date')."',
                        deadline = '".$request->input('deadline')."'
                        where id=".$id);
        return redirect()->route('getProjectManagement');
    }
    public function deleteProject($id) {
      //First, Add an auth
      $row = DB::table('ms_project')->where('id', $id)->get();
      
      $deleteProject = DB::table('ms_project')->where('id', $id)->delete();
       //Create a view. Please use `cbView` method instead of view method from laravel.
          
      return redirect()->route('getProjectManagement');
    }

  }