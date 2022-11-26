<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */

// The controller name should be JobController if all is related to job.
class BookingController extends Controller
{

    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */

    // The repository name should be JobRepository if all is related to job.
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->repository = $bookingRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */

  
    public function index(Request $request)
    {
        // For readability variables should be defined in start of the function
        // Variable naming convention should be in a way it should make sense what it's going to hold.  
        // I'm assigning it some initial value as not aware which user it could be
        // Variable value should be assigned before accessing it in the comparision. 
        $currentUserId=1 ;
        $selectedUserId=$request->get('user_id');
        $userType=$request->__authenticatedUser->user_type;
        $allowedRoleIds=[env('ADMIN_ROLE_ID'),env('SUPERADMIN_ROLE_ID')]; // Not aware of the logic but not a good practice to set role ids inside of env. 
        $response=[]; // In case no condition match
        if($currentUserId == $selectedUserId){
            // == for comparision. 
            $response = $this->repository->getUsersJobs($user_id);

        }else if(in_array($userType,$allowedRoleIds)){
            $response = $this->repository->getAll($request);

        }
            // it reduces invalid data types if json is returned on front-end where api will be consumed.
        return response()->json($response); 
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // Variable names should be in accordance to controller's name. As it says BookingController but we are geting jobs in it. 

        // The relationship binding should be in repository it self. 
        // Also method should be named as per of purpuse in repository.
        $job=$this->repository->findById($id); 
        
        // it reduces invalid data types if json is returned on front-end where api will be consumed.
        return response()->json($job); 
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // There should be Request validation before sending it to repository.
        // We can create form request validator class i.e BookingRequest 
        $data = $request->all(); // validation needed
        // $request->__authenticatedUser is redundant if we are sending all request. There is a defualt auth()->user helper from laravel to get it from jwt in case of api.
        $response = $this->repository->store($request->__authenticatedUser, $data);

    // it reduces invalid data types if json is returned on front-end where api will be consumed.
        return response()->json($response); 

    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
         // There should be Request validation before sending it to repository.
        // We can create form request validator class i.e BookingRequest 
        $data = $request->all(); // validation needed
        $currentUser = $request->__authenticatedUser; // variable name should be explicit. 
        $response = $this->repository->updateJob($id, array_except($data, ['_token', 'submit']), $cuser);

        // it reduces invalid data types if json is returned on front-end where api will be consumed.
        return response()->json($response); 
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function immediateJobEmail(Request $request)
    {
        // there should be admin settings to change such email from web portal.
        $adminSenderEmail = config('app.adminemail'); // But variable is not accessed following
        $data = $request->all(); // validation needed
        // it seems its to send job email or update some data that function signature not making clear
        $response = $this->repository->storeJobEmail($data);

       // it reduces invalid data types if json is returned on front-end where api will be consumed.
       return response()->json($response); 
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getHistory(Request $request)
    {
        $currentUserId=1 ;
        $selectedUserId=$request->get('user_id');
        if($currentUserId == $selectedUserId) {
                // == for comparision. 
            $response = $this->repository->getUsersJobsHistory($currentUserId, $request);
            return response()->json($response); 
        }

        return null;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function acceptJob(Request $request)
    {
        $data = $request->all(); // validation needed // validation needed
        $user = $request->__authenticatedUser;

        $response = $this->repository->acceptJob($data, $user);

        return response()->json($response); 
    }

    public function acceptJobWithId(Request $request)
    {
        $jobId = $request->get('job_id');
        $user = $request->__authenticatedUser;

        $response = $this->repository->acceptJobWithId($jobId, $user);

        return response()->json($response); 
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelJob(Request $request)
    {
        $data = $request->all(); // validation needed 
        $user = $request->__authenticatedUser;

        $response = $this->repository->cancelJobAjax($data, $user);

        return response()->json($response); 
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function endJob(Request $request)
    {
        $data = $request->all(); // validation needed

        $response = $this->repository->endJob($data);

        return response()->json($response); 

    }

    public function customerNotCall(Request $request)
    {
        $data = $request->all(); // validation needed

        $response = $this->repository->customerNotCall($data);

        return response()->json($response); 

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPotentialJobs(Request $request)
    {
        $data = $request->all(); // validation needed $data is not accessed
        $user = $request->__authenticatedUser;

        $response = $this->repository->getPotentialJobs($user);

        return response()->json($response); 
    }

    public function distanceFeed(Request $request)
    {
        // if we are using repository desing pattern so all the logic should be handled using some repositry functions.
        // Now here we are using eloquent approach directoly
        $data = $request->all(); // validation needed
        // Default variable should be on top level instead of using else.
        $distance=""; 
        $time = "";
        $jobid=0;
        $session = "";
        $flagged = 'no';
        $manually_handled = 'no';
        $by_admin = 'no';
        $admincomment = "";
        if (isset($data['distance']) && $data['distance'] != "") {
            $distance = $data['distance'];
        }
        if (isset($data['time']) && $data['time'] != "") {
            $time = $data['time'];
        }
        if (isset($data['jobid']) && $data['jobid'] != "") {
            $jobid = $data['jobid'];
        }

        if (isset($data['session_time']) && $data['session_time'] != "") {
            $session = $data['session_time'];
        }

        if ($data['flagged'] == 'true') {
            if($data['admincomment'] == '') return "Please, add comment";
            $flagged = 'yes';
        }
        
        if ($data['manually_handled'] == 'true') {
            $manually_handled = 'yes';
        }

        if ($data['by_admin'] == 'true') {
            $by_admin = 'yes';
        }

        if (isset($data['admincomment']) && $data['admincomment'] != "") {
            $admincomment = $data['admincomment'];
        }
        if ($time || $distance) {

            $affectedRows = Distance::where('job_id', '=', $jobid)->update(array('distance' => $distance, 'time' => $time));
        }

        if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {

            $affectedRows1 = Job::where('id', '=', $jobid)->update(array('admin_comments' => $admincomment, 'flagged' => $flagged, 'session_time' => $session, 'manually_handled' => $manually_handled, 'by_admin' => $by_admin));

        }

        return response()->json(
            [
                "success"=>true,
                "messsage"=>"Record updated!"
            ]
        );
    }

    public function reopen(Request $request)
    {
        $data = $request->all(); // validation needed
        $response = $this->repository->reopen($data);

        return response()->json($response); 
    }

    public function resendNotifications(Request $request)
    {
        $data = $request->all(); // validation needed
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);
        $this->repository->sendNotificationTranslator($job, $job_data, '*');

        return response(['success' => 'Push sent']);
    }

    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resendSMSNotifications(Request $request)
    {
        $data = $request->all(); // validation needed
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);

        try {
            $this->repository->sendSMSNotificationToTranslator($job);
            return response(['success' =>true,"message"=> "SMS sent"]);
        } catch (\Exception $e) {
            return response(['success' =>false ,"message"=> $e->getMessage()]);
        }
    }

}
