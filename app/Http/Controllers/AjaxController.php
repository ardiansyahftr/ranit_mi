<?php namespace App\Http\Controllers;

use App;
use App\Order;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Response;
class AjaxController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function ajaxEditProject()
    {
        $id = Input::get('id');
        $ajax_project = DB::table("ms_project")
                        ->join('ms_user', 'ms_project.id_pm', '=', 'ms_user.id')
                        ->select('ms_project.*', 'ms_user.name as pm_name')
                        ->where('ms_project.id', '=', $id)
                        ->first();
        // dump($ajax_project);
        $pm = DB::table("ms_user")->where('id', '=', $ajax_project->id_pm)->first();
        return Response::json([
            'ajax_project' => $ajax_project,
            'pm' => $pm,
        ]);
    }
    public function ajaxEditTicket()
    {
        $id = Input::get('id');
        $ajax_ticket = DB::table('t_ticket')
                        ->join('ms_project', 't_ticket.id_project', '=', 'ms_project.id')
                        ->join('ms_ticket_status', 't_ticket.status', '=', 'ms_ticket_status.id')
                        ->join('ms_priority', 't_ticket.priority', '=', 'ms_priority.id')
                        ->select('t_ticket.*', 'ms_ticket_status.name as status_name', 'ms_project.name as project_name', 'ms_project.code_project as code_project', 'ms_priority.name as priority_name', 'ms_priority.type as priority_type')
                        ->where('t_ticket.id', '=', $id)
                        ->first();
        // dump($ajax_ticket);
        $detail = DB::table("t_detail_ticket")->where('code_ticket', '=', $ajax_ticket->code_ticket)->get();
        return Response::json([
            'ajax_ticket' => $ajax_ticket,
            'detail' => $detail,
        ]);
    }
    public function ajaxGetNewBug(){
        $next = (!empty($_GET['next'])?$_GET['next']:0);
        $priority = DB::table('ms_priority')->get();
        $lokasi = '';
        // dd(asset('assets/img/add_image.png'));
        $lokasi .= '
            <tr id="cell'.$next.'">
                <td class="text-center"><img onclick="$(`#product-image-file'.$next.'`).click()" id="product-image'.$next.'" onmouseover="" src="'.asset('assets/img/add_image.png').'" onerror="this.src = '.asset('assets/img/add_image.png').'" style="cursor:pointer;opacity:0.5; top: 2em; height: 100px;">
                <input type="file" id="product-image-file'.$next.'" onchange="readURL(this, `product-image'.$next.'`);" name="photo[]" style="display:none"></td>
                <td>
                    <textarea class="form-control" id="bug_desc'.$next.'" rows="3" name="bug_desc[]" ></textarea>
                </td>
                <td>
                    <select name="priority_d[]" id="priority_d'.$next.'" class="selectpicker col-md-12" data-style="select-with-transition">
                        <option value="">-- Priority --</option>';
                        foreach ($priority as $item){
                            $lokasi .= '<option value="'.$item->id.'"><span class="badge badge-'.$item->type.'">'.$item->name.'</span></option>';
                        }
                $lokasi .= '
                    </select>
                </td>
                <td>
                    <button id="close'.$next.'" type="button" class="btn btn-link btn-just-icon btn-danger btn-delete" onclick="removeCell('.$next.')"><i class="fa fa-close"></i></button>
                </td>
            </tr>';

        return Response::json($lokasi);
    }
    public function ajaxGetEditNewBug(){
        $next = (!empty($_GET['next'])?$_GET['next']:0);
        $priority = DB::table('ms_priority')->get();
        $lokasi = '';
        $lokasi .= '
            <tr id="celledit'.$next.'">
                <td class="text-center"><img onclick="$(`#edit_product-image-file'.$next.'`).click()" id="edit_product-image'.$next.'" onmouseover="" src="'.asset('assets/img/add_image.png').'" onerror="this.src = '.asset('assets/img/add_image.png').'" style="cursor:pointer;opacity:0.5; top: 2em; height: 100px;">
                <input type="file" id="edit_product-image-file'.$next.'" onchange="readURL(this, `edit_product-image'.$next.'`);" name="photo[]" style="display:none"></td>
                <td>
                    <textarea class="form-control" id="edit_bug_desc'.$next.'" rows="3" name="bug_desc[]" ></textarea>
                </td>
                <td>
                    <select name="priority_d[]" id="edit_priority_d'.$next.'" class="selectpicker col-md-12" data-style="select-with-transition">
                        <option value="">-- Priority --</option>';
                        foreach ($priority as $item){
                            $lokasi .= '<option value="'.$item->id.'"><span class="badge badge-'.$item->type.'">'.$item->name.'</span></option>';
                        }
                $lokasi .= '
                    </select>
                </td>
                <td>
                    <button id="edit_close'.$next.'" type="button" class="btn btn-link btn-just-icon btn-danger btn-delete" onclick="editNewremoveCell('.$next.')"><i class="fa fa-close"></i></button>
                </td>
            </tr>';

        return Response::json($lokasi);
    }
    public function ajaxHapusBug()
    {
        $id = Input::get('id');
        $deleteBug = DB::table('t_detail_ticket')->where('id', $id)->delete();
        if ($deleteBug == 1 || $deleteBug == true) {
            return 'sukses';
        } else {
            return 'error';
        }
        
    }

}
