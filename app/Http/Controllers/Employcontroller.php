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
          // dd($request);
         $employ = new Employe();
         $department = new Department();
         $project = new Projects();
         $company = new Company();
         $employproject = new Employ_Projects();
  
     
         $company->com_name =$request->company;
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
         $employproject->	emp_id=$empid;
         $employproject->	pro_id2=$proid;
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
             ->leftJoin('project_employ','projects.id','=','project_employ.pro_id2')
             ->leftJoin('employes','project_employ.emp_id','=','employes.id')
             ->rightJoin('departments','projects.dep_id','=','departments.id')
             ->Where('departments.dep_name','like','%'.$search_val2.'%')
             ->rightJoin('companies','departments.com_id','=','companies.id')
             ->where('companies.com_name','like','%'.$search_val3.'%')
             ->select('projects.pro_name','employes.emp_name','employes.id','companies.com_name','departments.dep_name','employes.emp_address')
             ->get();
           
              return response()->json($searach);
          
     }

     public function newController(Request $request){
        // dd($request);
     }
}
