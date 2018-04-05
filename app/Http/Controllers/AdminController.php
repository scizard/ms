<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Houses;
use App\Landlord;
use App\MsStatement;
use App\Notif;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except('getAdminLogout');
    }

    public function getAdminHome()
    {

        //fetching data here
        $landlord = Landlord::all();
        $houses = Houses::all();
        $statements = MsStatement::orderBy('created_at', 'DESC')->get();
        return view('admin.home', [
            'landlord' => $landlord,
            'houses' => $houses,
            'statements' => $statements
        ]);
    }

    public function getLeaseRequests()
    {
        $lease = Houses::where('status', '0')->orderBy('created_at', 'DESC')->paginate(2);
        return view('admin.request', [
            'leaseRequests' => $lease
        ]);
    }

    /**
     * CONFIRMS LEASE
     *
     * REDUCES ADMINS COUNT
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptLease($id)
    {

        $requestUpdate = Houses::find($id);
        $houseName = $requestUpdate->houseName;
        $houseID = $requestUpdate->houseID;
        $requestUpdate->status = 1;
        $requestUpdate->save();

        //reduce admin count
        $admin = Admin::find(1);
        $previousCount = $admin->requests;
        $currentCount = $previousCount - 1;

        $admin->requests = $currentCount;
        $admin->save();

        alert()->success("House $houseName whose House ID is $houseID has been successfully Leased.", 'Success Lease')->persistent();

        //send notifications
        $from = auth()->user()->username;
        $to = $requestUpdate->landPhoneNumber;
        $subject = "Lease Accepted";
        $message = "Your house $houseName has been successfully Leased by " . env("APP_NAME") . " Real estate agency. Thanks for choosing us.";
        PageController::sendNotifs($from, $to, $subject, $message);


        //notify the land lord
        $notifCounter = Landlord::where('phoneNumber', $to)->first();
        if (count($notifCounter) > 0) {
            $notifCounter->notifs += 1;
            $notifCounter->save();
        }


        return redirect()->back();
    }

    public function revokedRequests($id)
    {

        $requestUpdate = Houses::find($id);
        $houseName = $requestUpdate->houseName;
        $houseID = $requestUpdate->houseID;
        $requestUpdate->status = 0;
        $requestUpdate->save();

        //increase admin count
        $admin = Admin::find(1);
        $previousCount = $admin->requests;
        $currentCount = $previousCount + 1;

        $admin->requests = $currentCount;
        $admin->save();

        alert()->success("House $houseName whose House ID is $houseID request has been successfully Cancelled.", 'Success Cancellation')->persistent();
        return redirect()->back();
    }

    public function rejectLease($id)
    {
        $requestUpdate = Houses::find($id);
        $houseName = $requestUpdate->houseName;
        $houseID = $requestUpdate->houseID;
        $requestUpdate->status = "-1";
        $requestUpdate->save();

        //reduce admin count
        $admin = Admin::find(1);
        $previousCount = $admin->requests;
        $currentCount = $previousCount - 1;

        $admin->requests = $currentCount;
        $admin->save();

        alert()->success("Lease request to house $houseName whose House ID $houseID is has been successfully rejected.", 'Rejected Lease Request')->persistent();

        //send notifications
        $from = auth()->user()->username;
        $to = $requestUpdate->landPhoneNumber;
        $subject = "Lease Rejected";
        $message = "Unfortunately Your house $houseName could not qualify to be Leased by " . env("APP_NAME") . " Real estate agency. You can always try the request again. Thanks for choosing us.";
        PageController::sendNotifs($from, $to, $subject, $message);


        return redirect()->back();
    }

    /*
     * ALREADY REJECTED REQUESTS
     * RETURNS A VIEW
     * */
    public function rejectedRequests()
    {
        $rejected = Houses::where('status', '-1')->orderBy('created_at', 'DESC')->paginate(2);
        return view('admin.rejected', [
            'rejected' => $rejected
        ]);
    }

    public function acceptedRequests()
    {
        $accepted = Houses::where('status', '1')->orderBy('created_at', 'DESC')->paginate(2);
        return view('admin.accepted', [
            'accepted' => $accepted
        ]);
    }


    public function previewHouses($id)
    {
        $preview = Houses::find($id);
        return view('admin.preview', [
            'preview' => $preview
        ]);
    }

    //admin logout
    public function getAdminLogout()
    {
        auth()->logout();
        Session::flush();
        return redirect('/');
    }

    public function statements()
    {
        $statements = MsStatement::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.statement', [
            'statements' => $statements
        ]);
    }

    /*
     * Return the view of the house
     *
     * reqistration form as in
     * */
    public function getHouseRegister()
    {
        return view('admin.addHouse');
    }

    /**
     * ADDS NEW HOUSES
     * UPDATES HOUSES
     *
     * INCREMENTS ADMIN REQUESTS
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addHouse(Request $request)
    {

        $this->validate($request, [
            'houseName' => 'required',
            'capacity' => 'required|numeric',
            'booked' => 'required|numeric',
            'price' => 'required|numeric',
            'landPhoneNumber' => 'required|numeric|min:10',
            'defaultImg' => 'image|required|max:5000',
            'town' => 'required',
            'ownerName' => 'required',
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
        $location = $request->street;
        $city = $request->town;


        $house = new Houses([
            'landPhoneNumber' => $request->landPhoneNumber,
            'houseID' => $houseID,
            'houseName' => $request->houseName,
            'img' => $defaultImg,
            'location' => $location,
            'city' => $city,
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

        //send notifications
        $from = auth()->user()->username;
        $to = $request->landPhoneNumber;
        $subject = "Enabled lease";
        $message = "Your house $house has been successfully added to " . env("APP_NAME") . " Real estate agency. Thanks for choosing us.";
        PageController::sendNotifs($from, $to, $subject, $message);

        //update admin count
        $adminMessageCounter = Admin::first();
        $adminMessageCounter->messages = $adminMessageCounter->messages + 1;
        return redirect()->back();
    }

    /*
     * Gets the inbox for admin from the notifications table
     *
     *
     * */
    public function getInbox()
    {
        $messages = Notif::where('to', auth()->user()->username)->orderBy('created_at', 'DESC')->paginate(5);

        //reset the counter from admin
        $counter = Admin::first();
        $counter->messages = 0;
        $counter->save();

        return view('admin.inbox', [
            'messages' => $messages
        ]);
    }

    /**
     * get the compose view
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function getCompose()
    {
        return View('admin.compose');
    }

    /**
     * post the message to the correct person
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCompose(Request $request)
    {
        $to = $request->to;
        $message = $request->message;
        $from = auth()->user()->username;
        $subject = $request->subject;

        PageController::sendNotifs($from, $to, $subject, $message);

        alert()->success('Message Composed successfully', 'Composed')->persistent('OK');


        //update counters
        if ($to == env('ADMIN')) {
            //update admin count
            $adminMessageCounter = Admin::find(1);
            $adminMessageCounter->messages += 1;
            $adminMessageCounter->save();
            return redirect()->back();
        }

        $landlord = Landlord::where('phoneNumber', $to)->first();

        if (count($landlord) > 0) {
            $landlord->notifs += 1;
            $landlord->save();
            return redirect()->back();
        }

        return redirect()->back();
    }

    /**
     * get the view of broadcast
     * @return \Illuminate\Contracts\View\Factory|View
     *
     */
    public function getBroadcast()
    {
        return view('admin.broadcast');
    }

    /**
     * posts broadcast message to all users
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|Request
     */

    public function postBroadcast(Request $request)
    {
        $message = $request->message;
        $from = auth()->user()->username;
        $subject = $request->subject;

        if ($request->category == "all") {
            //landlords
            $landlords = Landlord::all();
            if (count($landlords) > 0) {
                foreach ($landlords as $landlord) {
                    $to = $landlord->phoneNumber;
                    PageController::sendNotifs($from, $to, $subject, $message);

                    $landlord->notifs += 1;
                    $landlord->save();
                }
            }

            //users
            $users = User::all();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $to = $user->phoneNumber;
                    PageController::sendNotifs($from, $to, $subject, $message);

                    $user->messages += 1;
                    $user->save();
                }
            }
        }

        if ($request->category == "landlords") {
            $landlords = Landlord::all();
            if (count($landlords) < 1) {
                alert()->error('No landlords found', 'Not sent')->persistent('OK');
                return redirect()->back();
            }

            foreach ($landlords as $landlord) {
                $to = $landlord->phoneNumber;
                PageController::sendNotifs($from, $to, $subject, $message);

                $landlord->notifs += 1;
                $landlord->save();
            }
        }
        if ($request->category == "tenants") {
            //users
            $users = User::all();
            if (count($users) < 1) {
                alert()->error('No tenants found', 'Not sent')->persistent('OK');
                return redirect()->back();
            }

            foreach ($users as $user) {
                $to = $user->phoneNumber;
                PageController::sendNotifs($from, $to, $subject, $message);

                $user->messages += 1;
                $user->save();
            }

        }


        alert()->success('Message Composed successfully', 'Composed')->persistent('OK');

        return redirect()->back();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function getChangePassword(){
        return view('admin.changePassword');
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
        $currentUser = Admin::findOrFail($id);

        $currentUser->password = Hash::make($request->input('newPassword'));

        $currentUser->save();

        alert()->success('Password successfully changed.', 'Success')->persistent('Ok');

        return redirect()->route('admin.home');
    }


}
