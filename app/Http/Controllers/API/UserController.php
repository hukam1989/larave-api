<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\m_job; 
use App\M_job_draft; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use Hash;
class UserController extends Controller 
{
	public $successStatus = 200;
	
	/** 
	 * Get User List api 
	 * 
	 * @return \Illuminate\Http\Response 
	 */ 
	public function index()
	{ 
		$data = User::all();
		return $data;
	}
		

	
	/** 
	 * Register api 
	 * 
	 * @return \Illuminate\Http\Response 	 http://127.0.0.1:8000/api/register?username=hukam-&email=nh701%40gmail.com&password=01230123&first_name=test&last_name=test&gender=male&user_type=user&device_id=12359888&device_type=ios&session_token&updated_at&created_at&phone=01230123&name=hukam
	 */ 
	public function register(Request $request) 
	{ 	
		
		//dd($request->All());
	
	
		$validator = Validator::make($request->all(), [ 
			'username' => 'required', 
			'email' => 'required|email', 
			'password' => 'required', 
		   
		]);	
		
		if ($validator->fails()) { 
		return response()->json(['error'=>$validator->errors()], 401);            
		}  
	

		
		$data = $request->image;			
		$_photo = $request->file('image')->getClientOriginalName();
		$photo = preg_replace('/\s+/', '', $_photo);
		
		$destination = base_path() . '/public/uploads';
		$request->file('image')->move($destination, $photo); 
		
			
		$user = new User;
		
		$user->session_token = md5(date("YmdHis") . rand()); 
		$user->username = $request->username;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password); 
			
		
		$user->image = $photo;		
		$user->user_type = $request->user_type;
		$user->phone = $request->phone;
		
		
		$user->device_id = $request->device_id;
		$user->device_type = $request->device_type;
		
	
			
		$user->save();
		$insertedId = $user->id;		
				
		if(empty($insertedId)) {
			$json['response'][] = array("success" => 0, 'id' => "", "message" => "Please Try Again");
		}else{
			$json['response'][] = array("success" => 1, 'id' => $insertedId, "message" => "User Successfully Register.");
		}
		
		echo json_encode($json);
		exit; 
			
	}
	
	/** 
	 * details api 
	 * 
	 * @return \Illuminate\Http\Response 
	 */ 
    public function details() 
    { 
        $user = Auth::User(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }


	/** 
	 * details api 
	 * 
	 * Login API
	 */ 
	public function login(Request $request) {		
	$validator = Validator::make($request->all(), [ 
		'username' => 'required', 
		'password' => 'required', 
	   
	]);	
	
		$username= $request->username;
		$password =  $request->password;
	
		if(\Auth::attempt(['username' => $request->username,'password' => $request->password])){
			$session_token = Auth::id(). "_" . md5(date("YmdHis") . rand());;
			$deviceId = $request->deviceId;
			$deviceType = $request->device_type;
			
			$UpdateDetails = User::where('id', Auth::id())->update([
			   'session_token' => $session_token, 'device_id' => $deviceId, 'device_type' => $deviceType,
			]);

			$userData = Auth::user()->where('id', Auth::id())->first();
	
			if(is_null($UpdateDetails)) {
			return false;
			}else{
				 $json['response'][] = array("status" => "1",
						"id" => $session_token,
						"email" => $userData['email'],				
						"name" => $userData['first_name']. " " . $userData['last_name'],
						"message" => "Successfully login");
			}
			
		}else{
			 $json['response'][] = array("status" => "2",
					"id" => "0",
					"email" => "",
					"name" => "",
					"message" => "Fail to login invalid credentials");
		}
		echo json_encode($json);  
	
    }//End Login Function.
	
	
	
	/** 
	 * details api 
	 * 
	 * Check Session for user login or not(checkSessionToken)
	 */ 	
	public function checkSessionToken($id){	
		return DB::select('select * from tbl_users where session_token = :session_token', ['session_token' => $id]);		
	}


	public function getWalletAmount($sessionId){		
		return DB::select('select id,wallet_amount from tbl_users where session_token = :session_token', ['session_token' => $sessionId]);			
	}			
	
	public function temporaryPaymentTable($dataArray){
				
		$userid = $dataArray['jobDispatcherByUserId'];
		$jobId = $dataArray['jobId'];
		$jobAmount = $dataArray['jobAmount'];
		$getWinnerUserId= (int)'';		
		
		return DB::insert('insert into tbl_temporary_jobs_payment (jobDispatcherByUserId, getWinnerUserId, jobId, jobAmount) values (?, ?, ?, ?)', [$userid, $getWinnerUserId, $jobId, $jobAmount]);	
	}
	
	public function deductTempWalletAmount($dataArray) {

		
		$userid = $dataArray['jobDispatcherByUserId'];
		$jobId = $dataArray['jobId'];
		$jobAmount = $dataArray['jobAmount'];
		$getWinnerUserId= (int)'';
			
		//return DB::update('update tbl_users set wallet_amount = (wallet_amount - '.$jobAmount.') where id = ?', $userid);	
	}
	
	/** 
	* details api 
	* 
	* POST JOB (insertJob)	 http://127.0.0.1:8000/api/insertJob?posted_by=19_95bece0ac4439d08f2fddae563b5bd05&saveId&draftJob=N&job_title=hello%20test%20job&fair=120&description=test%20sdfsadf&wallet_amount%20=50&groups=N&collection_type=account&surcharge=5%25&job_type=asap&group_job=N&destination=eretert&destination_suburb=35353&vehicle_type=SUV&wallet_amount=200&points=5&pick_location&options&return&mobile&pax_name&job_time=2019-08-06%2004%3A50%3A39&jobrepostcount&id&commision=10
	*
	*/ 
	public function insertJob(Request $request){

		$input = $request->all();		
	
		$res = $this->checkSessionToken($input['posted_by']);
	
		if(empty($res)){
			$json['response'][] = array("success" => 10, "id" => "",
			"message" => "");
			echo json_encode($json);
			die;
			
		}
		
		
		if($input['saveId'] !=""){			
			$deleteDraftJobs = DB::table('tbl_jobs_darft')->where('id',$input['saveId'])->delete();				
		}
	
		if($input['draftJob'] == 'Y'){ 			
			$job = new M_job_draft;
						
			$job->job_title = $input['job_title'];
			$job->fair = $input['fair'];
			$job->posted_by = $res[0]->id;			
			$job->description = $input['description'];
			
			if($input['pick_location'] ==""){
				$job->pick_location = "null";
			}else{
				$job->pick_location = $input['pick_location'];
			}
			if($input['options'] ==""){
				$job->options = "null";
			}else{
				$job->options = $input['options'];
			}
			$job->groups = $input['groups'];
			$job->collection_type = $input['collection_type'];
			$job->surcharge = $input['surcharge'];
			$job->job_type = $input['job_type'];
			$job->group_job = $input['group_job'];
			$job->destination = $input['destination'];
			$job->destination_suburb = $input['destination_suburb'];
			
			if($input['return'] ==""){
				$job->return = "null";
			}else{
				$job->return = $input['return'];
			}
			
			if($input['mobile'] !=""){
				$job->mobile = $input['mobile'];
			}else{
				$job->mobile ="null";
			}
			
			if($input['pax_name'] !=""){
				$job->pax_name = $input['pax_name'];
			}else{
				$job->pax_name ="";
			}
			
			
			$job->date_time =date("Y-m-d H:i:s");
			$job->pick_city ="null";						
			
			$job->commision ="0";
			$job->picked_date =date("Y-m-d H:i:s");
			$job->cancelled_by ="0";
			$job->completed_by ="0";
			$job->completed_msg ="null";
			$job->reminder_sent ="0";
			$job->reminderTime =date("Y-m-d H:i:s");
			$job->reminderResponce ="0";
			$job->temp_awarded_to ="0";
			$job->temp_awarded_at =date("Y-m-d H:i:s");
			$job->perJobAdminCommission ="0";
			$job->perJobPostUserComm ="0";
			$job->perJobPickedUserComm ="0";
			$job->deductedCommission ="0";
			
			$job->amountDeductFromJobTotalAmount ="0";
			$job->amountDeductFromJobCompleterID ="0";
			$job->amountAddToJobPostID ="0";
			$job->amountCreditToJobPostID ="0";
			$job->amountDeditFromJobCompleterID ="0";
			
			$job->jobPostPickTimeAmount ="0";
			$job->jobPickTimePoint ="0";
			$job->afterPickJobPostJobUserPoint ="0";	
				
			$job->vehicle_type = $input['vehicle_type'];
			$job->job_time = date("Y-m-d H:i:s", strtotime($input['job_time']));
			$job->status = "active";
			$job->picked_by = "0";
			$job->job_repost_count = "0"; 
			$job->jobPostTimeAmount = $input['wallet_amount'];
			$job->jobPostTimePoint = $input['points'];
			$job->jobPickTimeAmount = "";
			$job->applied = ""; 
			
			$job->save();
			$insertedId = $job->id;
			
			 $json['response'][] = array("status" => "1",
						"id" => $insertedId,
						"message" => "Job Successfully Inserted");
		
		}else{ //POST JOB....
			
		
		if($input['jobrepostcount'] == 4)
		{
			$json['response'][] = array("success" => 3, "id" => "",
                "message" => "Alleady Posted 3 Time");
          			
		}else{
			
			$id = 0;       			
			if (($input['id'] != ''))
			{
				$id = $input['id'];           				
			} 	
			if($input['collection_type'] == "account" || $input['collection_type'] == "Account")
			{
				$walletAmount = $this->getWalletAmount($input['posted_by']);	
				if($walletAmount[0]->wallet_amount > $input['fair']  || $walletAmount[0]->wallet_amount == $input['fair'])
				{			
					$postedbyuser = ucfirst($res[0]->first_name) . ' ' . ucfirst($res[0]->last_name);
					
					$jobPost = new m_job;
					$jobPost->job_title = $input['job_title'];
					$jobPost->fair = $input['fair'];
					$jobPost->description = $input['description'];
					
					
					if($input['pick_location'] ==""){
						$jobPost->pick_location = "null";
					}else{
						$jobPost->pick_location = $input['pick_location'];
					}
					
					if($input['options'] ==""){
						$jobPost->options = "null";
					}else{
						$jobPost->options = $input['options'];  	
					}

					
					if($input['commision'] ==""){
						$jobPost->commision = "0";
					}else{
						$jobPost->commision = $input['commision'];  	
					}		
					
					$jobPost->groups = $input['groups'];
					$jobPost->collection_type = $input['collection_type'];
					
					$jobPost->surcharge = $input['surcharge'];
					$jobPost->job_type = $input['job_type'];
					$jobPost->group_job = $input['group_job'];
					$jobPost->destination = $input['destination'];
					
					$jobPost->destination_suburb = $input['destination_suburb'];
					//$jobPost->options = $input['options'];
					
					if($input['return'] ==""){
						$jobPost->return = "null";
					}else{
						$jobPost->return = $input['return'];
					}
					
					if($input['mobile'] !=""){
						$jobPost->mobile = $input['mobile'];
					}else{
						$jobPost->mobile ="null";
					}
					
					if($input['pax_name'] !=""){
						$jobPost->pax_name = $input['pax_name'];
					}else{
						$jobPost->pax_name ="";
					}
					
					$jobPost->vehicle_type = $input['vehicle_type'];
					
					$jobPost->job_time = date("Y-m-d H:i:s", strtotime($input['job_time']));
					
					$jobPost->posted_by = $res[0]->id;	
					
					$jobPost->pick_city ="null";	 
					
					$jobPost->date_time = date('Y-m-d H:i:s');
					
					$jobPost->picked_date =date("Y-m-d H:i:s"); 
					
					$jobPost->cancelled_by ="0";
					$jobPost->completed_by ="0";
					$jobPost->completed_msg ="null";
					$jobPost->reminder_sent ="0";
					$jobPost->reminderTime =date("Y-m-d H:i:s");
					$jobPost->reminderResponce ="0";
					$jobPost->temp_awarded_to ="0";
					$jobPost->temp_awarded_at =date("Y-m-d H:i:s");
					$jobPost->perJobAdminCommission ="0";
					$jobPost->perJobPostUserComm ="0";
					$jobPost->perJobPickedUserComm ="0";
					$jobPost->deductedCommission ="0";
					
					$jobPost->amountDeductFromJobTotalAmount ="0";
					$jobPost->amountDeductFromJobCompleterID ="0";
					$jobPost->amountAddToJobPostID ="0";
					$jobPost->amountCreditToJobPostID ="0";
					$jobPost->amountDeditFromJobCompleterID ="0";
					
					$jobPost->jobPostPickTimeAmount ="0";
					$jobPost->jobPickTimePoint ="0";
					$jobPost->afterPickJobPostJobUserPoint ="0";	
					$jobPost->afterJobPostedUserBalance ="0";
					$jobPost->afterJobPickedUserBalance ="0";
					$jobPost->jobPoint ="0";					
					
					$jobPost->status = "active";
					$jobPost->picked_by = "0";
					$jobPost->job_repost_count = "0";
					$jobPost->jobPostTimeAmount = "0";
					$jobPost->jobPostTimePoint = "0";
					$jobPost->jobPickTimeAmount = "0";
					$jobPost->applied = "0";			
										
					$jobPost->save();
					$insertedJobId = $jobPost->id; 
										
					 $json['response'][] = array("status" => "1",
						"id" => $insertedJobId,
						"message" => "Job Successfully Inserted");
			
				}
								
			}

		}	
			
	}////POST JOB END ....
		
	echo json_encode($json);  	
		
	}//END Function.
	
	
}//End Class.