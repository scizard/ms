<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Houses;
use App\Landlord;
use App\MsStatement;
use App\Notif;
use App\StripeStatements;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LandlordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:landlord')->except('getLandlordLogout');
    }


    /**
     * gets the homepage of the landlord
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLandlordDashboard()
    {
        $statements = MsStatement::where('benefactor',auth()->user()->phoneNumber)->where('action','book')->orderBy('created_at','DESC')->get();
        $houses = Houses::where('landPhoneNumber',auth()->user()->phoneNumber)->orderBy('created_at','DESC')->get();
        $transactions = StripeStatements::where('landlord',auth()->user()->phoneNumber)->orderBy('created_at','DESC')->get();
        $balance = $this->calculateBalance();
        return view('landlord.home',[
            'statements'=>$statements,
            'houses'=>$houses,
            'transactions'=>$transactions,
            'balance'=>$balance
        ]);
    }

    /*
     * Adds house to admin to accept lease request
     *
     */
    public function addHouse(){
        return view('landlord.addHouse');
    }


    /*
     * Post a house to db
     * owner id and phoneNumber from session
     */
    public  function postHouse(Request $request){

        //return $request;

        $this->validate($request, [
            'houseName' => 'required',
            'capacity' => 'required|numeric',
            'booked' => 'required|numeric',
            'price' => 'required|numeric',
            'defaultImg' => 'image|required|max:5000',
            'town' => 'required',
            'street' => 'required'
        ]);

//        handle the image
        if ($request->hasFile('defaultImg')) {
            $defaultImgWithExt = $request->file('defaultImg')->getClientOriginalName();//gets the whole filename and extension
            $filename = pathinfo($defaultImgWithExt, PATHINFO_FILENAME);
            $extension = $request->file('defaultImg')->getClientOriginalExtension();
            $imgToStore = $filename . '_' . time() . '.' . $extension;

            $defaultImg = 'storage/houseImages/' . $imgToStore;

            //upload image
            $path = $request->file('defaultImg')->storeAs('/public/houseImages', $imgToStore);
        } else {
            $defaultImg = 'home/images/uploads/logo.png';
        }

        $houseCount = count(Houses::all()) + 1;
        $houseID = 'MS/' . $houseCount . '/' . date("Y");
        $location = $request->street . ', ' . $request->town;
        $landPhoneNumber = Auth()->user()->phoneNumber;

        $house = new Houses([
            'landPhoneNumber' => $landPhoneNumber,
            'houseID' => $houseID,
            'houseName' => $request->houseName,
            'img' => $defaultImg,
            'location' => $location,
            'capacity' => $request->capacity,
            'booked' => $request->booked,
            'price' => $request->price,
            'category' => $request->houseCategory,
            'status' => '0',
            'enabled' => '1',

        ]);

        $house->save();

        //notify admin
        $admin = Admin::find(1);
        $previousCount = $admin->requests;
        $currentCount = $previousCount + 1;


        $admin->requests = $currentCount;
        $admin->save();

        alert()->success('House ' . $request->houseName . ' successfully added', 'Successfully added')->persistent('OK');

        return redirect()->back();

    }

    public function removeHouse(){
        $myHouses = Houses::where('landPhoneNumber',auth()->user()->phoneNumber)->where('enabled','1')->paginate(2);
        return view('landlord.remove',[
            'myHouses'=>$myHouses
        ]);
    }
    public function removedHouses(){
        $removedHouses = Houses::where('landPhoneNumber',auth()->user()->phoneNumber)->where('enabled','0')->paginate(2);
        return view('landlord.removedHouses',[
            'myHouses'=>$removedHouses
        ]);
    }

    /*
     * Removes house by id
     * */
    public function postRemoveHouse($id){
        $removeHouse = Houses::find($id);
        $removeHouse->enabled = "0";
        $removeHouse->save();
        $house = $removeHouse->houseName;

        alert()->success('House ' . $house . ' successfully disabled', 'Successfully Disabled')->persistent('OK');

        //send a notification to the admin
        $name = auth()->user()->name;
        $from = auth()->user()->phoneNumber;
        $to = env("ADMIN");
        $subject = "Revoke lease";
        $message = "$name has revoked their lease request on the house $house. Contact them on $from";
        PageController::sendNotifs($from, $to, $subject, $message);

        //update admin count
        $adminMessageCounter = Admin::first();
       $adminMessageCounter->messages = $adminMessageCounter->messages +1;
        $adminMessageCounter->save();

        return redirect()->back();
    }

//    cancles the previously removed houses and admin can re lease them  back
    public function cancelRemove($id){
        $cancel = Houses::find($id);
        $cancel->enabled = '1';
        $cancel -> save();
        $house = $cancel->houseName;

        //send message to admin
        //send a notification to the admin
        $name = auth()->user()->name;
        $from = auth()->user()->phoneNumber;
        $to = env("ADMIN");
        $subject = "Enabled lease";
        $message = "$name has enabled their lease request on the house $house. The house is available to tenants in the website. Contact them through $from.";
        PageController::sendNotifs($from, $to, $subject, $message);

        //update admin count
        $adminMessageCounter = Admin::first();
        $adminMessageCounter->messages = $adminMessageCounter->messages +1;
        $adminMessageCounter->save();

        alert()->success('House ' . $house . ' successfully Enabled', 'Successfully Enabled')->persistent('OK');

        return redirect()->back();
    }



    /**
     * Gets the inbox for admin from the notifications table
     *
     *
     * */
    public function getInbox(){
        $messages = Notif::where('to',auth()->user()->phoneNumber)->orderBy('created_at','DESC')->paginate(5);

        //reset the counter from landlord
        $counter = Landlord::where('phoneNumber',auth()->user()->phoneNumber)->first();
        $counter->notifs = 0;
        $counter->save();

        return view('landlord.inbox',[
            'messages'=>$messages
        ]);
    }

    /*
     *Replies to the specific sender of the message
     *
     */
    public function replyInbox(Request $request){
       $to = $request->to;
       $message = $request->message;
       $from = auth()->user()->phoneNumber;
       $subject = $request->subject;

        PageController::sendNotifs($from, $to, $subject, $message);

        alert()->success('Message sent successfully', 'Replied')->persistent('OK');

        //update counters
        if($to == env('ADMIN')){
            //update admin count
            $adminMessageCounter = Admin::find(1);
            $adminMessageCounter->messages += 1;
            $adminMessageCounter->save();
            return redirect()->back();
        }

        $landlord = Landlord::where('phoneNumber',$to)->first();

        if(count($landlord) > 0){
            $landlord->notifs += 1;
            $landlord->save();
            return redirect()->back();
        }

        return redirect()->back();

    }


    /*
     * sends message
     * */
    public function getCompose(){
        return view('landlord.compose');
    }

    /*
     * sends message
     * */
    public function postCompose(Request $request){
        $to = $request->to;
        $message = $request->message;
        $from = auth()->user()->phoneNumber;
        $subject = $request->subject;

        PageController::sendNotifs($from, $to, $subject, $message);

        alert()->success('Message Composed successfully', 'Composed')->persistent('OK');


        //update counters
        if($to == env('ADMIN')){
            //update admin count
            $adminMessageCounter = Admin::find(1);
            $adminMessageCounter->messages += 1;
            $adminMessageCounter->save();
            return redirect()->back();
        }

        $landlord = Landlord::where('phoneNumber',$to)->first();

        if(count($landlord) > 0){
            $landlord->notifs += 1;
            $landlord->save();
            return redirect()->back();
        }
    }

    public  function getLandlordLogout(){
        auth()->logout();
        Session::flush();
        return redirect('/');
    }

    /**
     * gets the statements from stripe statements table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStatement(){
        $statements = StripeStatements::where('landlord',auth()->user()->phoneNumber)->orderBy('created_at','DESC')->paginate(5);
        $users = User::all();
        return view('landlord.statement',[
            'statements'=>$statements,
            'users'=>$users
        ]);
    }

    /**
     * gets the withdrawal page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function getWithdraw(){
        $balance = $this->calculateBalance();
        return view('landlord.withdraw',[
            'balance'=>$balance
        ]);
    }

    /**
     * withdraws balance and updates ms statement
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postWithdraw(Request $request){
        $amount = $request->amount;
        $password = $request->password;
        $balance = $this->calculateBalance();

        $this->validate($request,[
            'amount'=>'required|numeric|min:3',
            'password'=>'required|min:6'
        ]);

        //validations
        if (!Hash::check($password, auth()->user()->password)) {

            alert()->error('Sorry the entered password is wrong.', 'Wrong Password!!')->persistent();

            return redirect()->back();
        }if($amount < 100){
            alert()->error('Sorry the minimum amount you can withdraw is KES 100.', 'Minimum amount!!')->persistent();

            return redirect()->back();
        }if($amount > $balance){
            alert()->error("You do not have sufficient balance to withdraw KES ".number_format($amount)." Amount available is KES ".number_format($balance)."", 'Insufficient Balance!!')->persistent();

            return redirect()->back();
        }

        //update statements
        $statement = new MsStatement([
                'initiator' => auth()->user()->phoneNumber,
                'benefactor' => auth()->user()->phoneNumber,
                'houseID' => 'all',
                'action' => 'withdraw',
                'amount' => $amount,
                'description' => "You withdrawn KES $amount"
        ]);
        $statement->save();

        alert()->success("You successfully withdrawn KES $amount to your stripe account.", 'Withdrawn')->persistent('OK');

       //update notifications
        $adminMessageCounter = Admin::find(1);
        $adminMessageCounter->messages += 1;
        $adminMessageCounter->save();

        $landlord = Landlord::where('phoneNumber',auth()->user()->phoneNumber)->first();
        $landlord->notifs += 1;
        $landlord->save();

        //admin
        PageController::sendNotifs(auth()->user()->phoneNumber, env('ADMIN'), 'Withdrawals', auth()->user()->name.", phone number ".auth()->user()->phoneNumber." has withdrawn KES $amount.");
        PageController::sendNotifs(env('ADMIN'), auth()->user()->phoneNumber, 'Withdraw', "You have successfully withdrawn KES $amount to your stripe wallet. Thank you for taking Mushroom Shelter as the better option.");
        return redirect()->back();
    }

    /**
     * calculates the balance in ms statements table
     *
     * @return int
     */

    public function calculateBalance(){
        $statements = MsStatement::where('benefactor',auth()->user()->phoneNumber)->get();

        $earnings = $withdraws = 0;
        foreach ($statements as $statement){
            if($statement->action == 'book'){
                $earnings += $statement->amount;
            }
            if($statement->action == 'withdraw'){
                $withdraws += $statement->amount;
            }
        }

        $balance = $earnings - $withdraws;

        return $balance;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function getChangePassword(){
        return view('landlord.changePassword');
    }

    /**
     * Process the password change request
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'currentPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6',
        ]);

        //Get the current authenticated user password
        $currentPassword = auth()->user()->password;

        //Check if passwords match
        if (!Hash::check($request['currentPassword'], $currentPassword)) {

            alert()->error('Sorry the entered password is wrong.', 'Wrong Password!!');

            return redirect()->back();
        } elseif ($request->input('newPassword') !== $request->input('confirmPassword')) {

            alert()->error('Sorry the entered passwords do not match.', 'Warning!!');

            return redirect()->back();
        }

        //Update password
        $id = Auth::id();
        $currentUser = Landlord::findOrFail($id);

        $currentUser->password = Hash::make($request->input('newPassword'));

        $currentUser->save();

        alert()->success('Password successfully changed.', 'Success')->persistent('Ok');

        return redirect()->route('landlord.dashboard');
    }

}
