<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Employ_Projects;
use App\Models\Department;
use App\Models\Employe;
use App\Models\Projects;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;


class Employcontroller extends Controller
{
    public function insert(Request $request){
        try {
          
         $employ = new Employe();
         $department = new Department();
         $project = new Projects();
         $company = new Company();
         $employproject = new Employ_Projects();
  
     
         $company->com_nsme =$request->company;
         $company->save();
         $comid = DB::getPdo()->lastInsertId();
         $department->com_id=$comid;
         $department->dep_name= $request->department;
         $department->save();
         $depid = DB::getPdo()->lastInsertId();
         $project->dep_id=$depid;
         $project->pro_name = $request->project;
         $project->save();
         $proid = DB::getPdo()->lastInsertId();
         $employ -> emp_name = $request->name;
         $employ -> emp_address = $request ->address;
         $employ->save();
         $empid = DB::getPdo()->lastInsertId();
         $employproject->employe_id=$empid;
         $employproject->projects_id=$proid;
         $employproject->save();
         
        $response['message'] = "Save sucsesfull";
        $response['success'] = true;
        } catch (\Exception $ex) {
          $response['message'] = $ex->getMessage();
          $response['success'] = false;
        }
        return $response;

     }
  
  
     public function index(Request $request)
     {
        
         $search_val = $request->get('projects');
         $search_val2 = $request->get('departments');
         $search_val3 = $request->get('companys');
    
         $searach = DB::table('projects')->where('projects.pro_name','like','%'.$search_val.'%')
             ->leftJoin('employe_projects','projects.id','=','employe_projects.projects_id')
             ->leftJoin('employes','employe_projects.employe_id','=','employes.id')
             ->rightJoin('departments','projects.dep_id','=','departments.id')
             ->Where('departments.dep_name','like','%'.$search_val2.'%')
             ->rightJoin('companies','departments.com_id','=','companies.id')
             ->where('companies.com_nsme','like','%'.$search_val3.'%')
             ->select('projects.pro_name','employes.emp_name','employes.id','companies.com_nsme','departments.dep_name','employes.emp_address')
             ->get();
           
              return response()->json($searach);
          
     }

     public function newController(Request $request){
        // dd($request);
     }
}
