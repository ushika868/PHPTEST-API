<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Employee;
use App\Entities\Department;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Validator;
use Response;
use Exception;
use Log;
class EmployeeController extends Controller
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
     * Store employee.
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
                        'code' => 3
                    ];
            Log::info($request->fullUrl(),array('parameters'=>$request->all(),'response'=>$response));        
            return Response::json($response,422);
            
		}

		if($this ->create($request) !== true){
            $response = [
                        'error' => true,
                        'message' => 'Failed to create employee',
                        'code' => 4
                    ];
            Log::info($request->fullUrl(),array('parameters'=>$request->all(),'response'=>$response));        
            return Response::json($response,200);
        }

            $response= [
                        'error' => false,
                        'message' => 'Employee created successfully'
                    ];
            Log::info($request->fullUrl(),array('parameters'=>$request->all(),'response'=>$response));        
            return Response::json($response,200);
    }
     /**
     * Validate inputs for store Employee
     *
     * @param  Request object
     * @return boolean
     */
    private function validateStoreDepartment($request){
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'department' => 'required'
        ]);             
        if ($v->fails()){
            return false;
        }
        return true;
    }
    /**
     * create new Employee
     *
     * @param Request
     * @return boolean
     */
    private function create($request)
    {
        
        try{
            $employee =  new Employee($request->get('name'),$request->get('email'));
            $department = $this->em->getRepository(Department::class)->find($request->get('department'));          
            $employee->setDepartment($department);
            $this->em ->persist($employee);
            $this->em ->flush();

            return true;
        }catch(Exception $e){
            return false;           
        }
            
    }
}

