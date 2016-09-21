<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Department;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Response;
use Exception;
use Log;
class DepartmentController extends Controller
{
    /**
    *EntyityManager
    */
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * Department hierarchy.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
                $departments =$this->getDepartmentStructure();
                $response = [
                    'error'=> false,
                    'message' => 'Department Hierarchy',
                    'departments' => $departments,
                ];
                Log::info(Route::getFacadeRoot()->current()->uri(),$response);
                return Response::json($response,200);
        }catch (Exception $exception) {
            $response = [
                    'error'=>true,
                    'message' => 'Error in department listing',
                    'code' => 5
                    ];
            Log::info(Route::getFacadeRoot()->current()->uri(),$response);
            return Response::json($response,204);
        }
    }
    /**
     * Store new department.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
        if($this->validateStoreDepartment($request) !== true){
            $response = [
                        'error' => true,
                        'message' => 'Invalid Inputs',
                        'code' => 1
                    ];
            Log::info($request->fullUrl(),array('parameters'=>$request->all(),'response'=>$response));          
            return Response::json($response,422);
            
		}

		if($this ->create($request) !== true){
            $response = [
                        'error' => true,
                        'message' => 'Failed to create department',
                        'code' => 2
                    ];
            Log::info($request->fullUrl(),array('parameters'=>$request->all(),'response'=>$response));        
            return Response::json($response,200);
        }

            $response= [
                        'error' => false,
                        'message' => 'department created successfully'
                    ];
            Log::info($request->fullUrl(),array('parameters'=>$request->all(),'response'=>$response));      
            return Response::json($response,200);
    }
     /**
     * Validate inputs for store Department
     *
     * @param  Request object
     * @return boolean
     */
    private function validateStoreDepartment($request){
        $v = Validator::make($request->all(), [
            'name' => 'required'
        ]);             
        if ($v->fails()){
            return false;
        }
        return true;
    }    
    /**
     * create new department
     *
     * @param Request
     * @return boolean
     */
    private function create($request)
    {
        
        try{
            $department =  new Department($request->get('name'));
            if ($request->has('parent_id')) {
                $parentDepartment = $this->em->getRepository(Department::class)->find($request->get('parent_id'));
                $department ->setParent($parentDepartment);
            }       
            $this->em ->persist($department);
            $this->em ->flush();
            return true;
        }catch(Exception $e){
            return false;           
        }
            
    }
    /**
     * query get departments hierarchy
     *
     * @param
     * @return result array
     */
    public function getDepartmentStructure()
    {
        
        $query = $this->em->createQueryBuilder()
            ->select('l1, l2, l3, l4, l5, l6')
            ->from(Department::class, 'l1')
            ->leftJoin('l1.children', 'l2')
            ->leftJoin('l2.children', 'l3')
            ->leftJoin('l3.children', 'l4')
            ->leftJoin('l4.children', 'l5')
            ->leftJoin('l5.children', 'l6')
            ->getQuery();
        $results = $query->getArrayResult();
        return $results[0];
    }    
    /**
     * query employees of the department
     *
     * @param $departmentId
     * @return \Illuminate\Http\Response
     */
    public function show($departmentId)
    {
        
        $department = $this->em->getRepository(Department::class)->find($departmentId);
        if(is_null($department)){
            $response = array(
            "error" => true,    
            "message"=>'Department not exists',
            "code"=>6);
            Log::info('Employees of the department',$response);      
            return Response::json($response,422);
        }
        $employees = $department->getEmployees();
        
        $employeeArray = array();
        $count = 0;
        foreach ($employees as $key => $employee) {
            $email = $employee->getEmail();
            $name = $employee->getName();
            $id = $employee->getId();
            $count++;
            array_push($employeeArray,array('id'=>$id,'name'=>$name,'email'=>$email));            
        }
        $response = array(
            "error"=>false,
            "Department"=>$department->getName(),
            "No of employees"=> $count,
            "Employees"=>$employeeArray);
        Log::info('Employees of the department',$response);
        return Response::json($response, 200);
        
    }
    
}

