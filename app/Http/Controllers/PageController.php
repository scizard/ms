<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Houses;
use App\Landlord;
use App\MsStatement;
use App\Notif;
use App\User;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $houses = Houses::where('status', 1)->where('enabled',1)->orderBy('updated_at', 'DESC')->paginate(4);
        $count = count($houses);
        return view('welcome', [
            'houses' => $houses,
            'count' => $count
        ]);
    }

    public function getAdminLogin()
    {
        return view('admin.login');
    }

    public function postAdminLogin(Request $request)
    {
        //return $request;

//        $admin = new Admin([
//            'name'=>'Simon Njenga',
//            'username'=>'0706256130',
//            'password'=>bcrypt('0706256130'),
//            'messages'=>'0',
//            'requests'=>0
//        ]);
//
//        $admin->save();
//
//       // return 'created';
//
//        //landlord register
//        $landlord = new Landlord([
//            'name'=>'Brethren',
//            'phoneNumber'=>'0712611720',
//            'notifs'=>'1',
//            'password'=>bcrypt('0712611720')
//        ]);
//
//        $landlord->save();
//        return 'created';

        //houses register
//        $houses = new Houses([
//            'landPhoneNumber'=>'0706256130',
//            'houseID'=>'0706256132',
//            'houseName'=>'Family Hostels',
//            'img'=>'',
//            'location'=>'Ndagani, chuka',
//            'capacity'=>'200',
//            'booked'=>'50',
//            'status'=>'0'
//        ]);
//
//        $houses->save();
//        return 'created';

        $this->validate($request, [
            'username' => "required|min:6",
            'password' => 'required|min:6'
        ]);

        if (!auth('admin')->attempt([
            'username' => $request['username'],
            'password' => $request['password']
        ])
        ) {
            alert()->error('Failed to login', 'Wrong Credentials')->persistent('Try again');
            return redirect()->back();
        }


        return redirect()->route('admin.home');
    }


    public function landlordRegister()
    {
        return view('landlord.register');
    }

    public function postLandlordRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phoneNumber' => 'required|numeric|min:10',
            'password' => 'required|min:6'
        ]);

        if ($request->password != $request->confirmPassword) {
            alert()->error('Passwords does not', 'Password')->persistent('OK');
            return redirect()->back();
        }

//        Verify whelther lanlod exists
        $verifyLandlord = Landlord::where('phoneNumber', $request->phoneNumber)->get();
        if (count($verifyLandlord) > 0) {
            alert()->error('The phone number already exists', 'User exists')->persistent('OK');
            return redirect()->back();
        }

        //landlords ID
        $landlord = count(Landlord::all()) + 1;
        $password = bcrypt($request->password);

        // add to database
        $addLandlord = new Landlord([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'password' => $password,
            'notifs' => '0'
        ]);
        $addLandlord->save();

        //authenticate landlord and login immediately
        Auth::guard('landlord')->login($addLandlord);
        // return \auth()->user()->id;

        return redirect()->route('landlord.dashboard');
    }

    public function landlordLogin()
    {
        return view('landlord.login');
    }

    public function postLandlordLogin(Request $request)
    {
        $this->validate($request, [
            'phoneNumber' => 'required|numeric|min:10',
            'password' => 'required|min:6'
        ]);

        if (!auth('landlord')->attempt([
            'phoneNumber' => $request->phoneNumber,
            'password' => $request->password
        ])
        ) {
            alert()->error('Failed to login', 'Wrong Credentials')->persistent('Try again');
            return redirect()->back();
        }

        return redirect()->route('landlord.dashboard');


    }

    public function comingSoon()
    {
        alert()->error('This service will be available soon', 'Coming Soon')->persistent('OK');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showHouse($id)
    {
        $landlords = Landlord::all();
        $preview = Houses::find($id);
        return view('pages.show', [
            'preview' => $preview,
            'landlords'=>$landlords
        ]);

    }

    /*
     * sends messages to notifs table
     *
     * everybody can send the message from any where
     * */
    public static function sendNotifs($from, $to, $subject, $message){
        $msg = new Notif([
            'from'=>$from,
            'to'=>$to,
            'subject'=>$subject,
            'message'=>$message
        ]);

        $msg->save();

    }

    public function getResetPassword(){
        return view('pages.reset');
    }
    public function postResetPassword(Request $request){
        $this->validate($request,[
            'phoneNumber'=>'required|min:10'
        ]);

        //user exists?
        $user = User::where('phoneNumber',$request->phoneNumber)->get();

        if(count($user) < 1){
            alert()->error('You do not exist in the system', 'Error')->persistent('OK');
            return redirect()->back();
        }

        // Generate, hash and save the password
        $password = rand(100000, 999999);
        $hash = Hash::make($password);

        //Update password then send SMS
        $user[0]->password = $hash;

        $user[0]->save();

        alert()->success("Password successfully reset. You will receive an SMS with the new password. Remember to change the password after login into your account.", 'Success')->persistent();

        // Send message
        $name = $user[0]->name;
        $message = "Hello $name. $password is your new password.";
        $this->sendMessage($request['phoneNumber'], $message);

        return redirect()->route('login');
    }
    /**
     * Sends all the application SMSes
     * @param $recipient
     * @param $message
     * @return mixed
     */
    public static function sendMessage($recipient, $message){

        $receiver = '254' . ltrim($recipient, 0);
        $sentMessage = str_replace(' ', '+', $message);
        $clientSMSID = round(microtime(true) * 1000);

        $smsEndpoint = "http://sms.trackom-group.com/sendsms.jsp?user=".env('SMS_USERNAME')."&password=".env('SMS_PASSWORD')."&mobiles=".$receiver."&sms=".$sentMessage."&unicode=".env('SMS_UNICODE')."&clientsmsid=".$clientSMSID."&senderid=".env('SMS_SENDER_ID')."&version=".env('SMS_VERSION')."";
        Log::info($smsEndpoint);
        //return null;
        //return $smsEndpoint;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $smsEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            Log::warning($err);
            // echo "cURL Error #:" . $err;

        }
        Log::info($response);

        return null;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRentals(){
        $houses = Houses::where('status', 1)->where('enabled',1)->where('category','like','%Rentals%')->orderBy('updated_at', 'DESC')->paginate(4);
        return view('pages.rentals',[
            'houses'=>$houses
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHostels(){
        $houses = Houses::where('status', 1)->where('enabled',1)->where('category','like','%Hostels%')->orderBy('updated_at', 'DESC')->paginate(4);
        return view('pages.hostels',[
            'houses'=>$houses
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCommercials(){
        $houses = Houses::where('status', 1)->where('enabled',1)->where('category','like','%Commercials%')->orderBy('updated_at', 'DESC')->paginate(4);
        return view('pages.commercials',[
            'houses'=>$houses
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getApartments(){
        $houses = Houses::where('status', 1)->where('enabled',1)->where('category','like','%Apartments%')->orderBy('updated_at', 'DESC')->paginate(4);
        return view('pages.apartments',[
            'houses'=>$houses
        ]);
    }

    public function test(){
        $statements = MsStatement::all();


        echo "Prints only once <br>";
        foreach ($statements as $statement){

            $seen[] =  0;
            $checker = 0;

            foreach ($seen as $item){
                if($item == $statement->amount ){
                   $checker = 1;
                }
            }

            if($checker == 0){
                $seen[] =  $statement->amount;
                echo $statement->amount."<br>";
            }

        }
    }


}
