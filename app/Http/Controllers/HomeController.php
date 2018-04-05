<?php

namespace App\Http\Controllers;

use App\Houses;
use App\MsStatement;
use App\Notif;
use App\StripeStatements;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houses = Houses::where('status', 1)->where('enabled',1)->orderBy('updated_at', 'DESC')->paginate(4);
        $statements = MsStatement::where('initiator', auth()->user()->phoneNumber)->get();
        return view('home',[
            'houses' => $houses,
            'statements' => $statements
        ]);
    }

    /**
     * preview houses
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showHouse($id)
    {

        $preview = Houses::find($id);
        return view('pages.preview', [
            'preview' => $preview
        ]);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBook($id){
        $house = Houses::find($id);
        return view("dashboard.checkout",[
            'house'=>$house
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getInbox(){
        $messages = Notif::where('to',auth()->user()->phoneNumber)->orderBy('created_at','DESC')->paginate(5);

        //reset the counter from admin
        $counter = User::where('phoneNumber',auth()->user()->phoneNumber)->first();
        $counter->messages = 0;
        $counter->save();

        return view('dashboard.inbox',[
            'messages'=>$messages
        ]);
    }


    /**
     * gets the statements from stripe statements table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStatement(){
        $statements = StripeStatements::where('user',auth()->user()->phoneNumber)->orderBy('created_at','DESC')->paginate(5);
        return view('dashboard.statement',[
            'statements'=>$statements
        ]);
    }

    /**
     * gets the booked rooms by the authenticated users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBooked(){
        $booked = MsStatement::where('initiator',auth()->user()->phoneNumber)->where('action','book')->orderBy('created_at','DESC')->paginate(10);
        $rooms = DB::select("SELECT `houseName`,`houseID` FROM houses");

        return view('dashboard.booked',[
            'houses'=>$booked,
            'rooms'=>$rooms
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public  function logout(){
        auth()->logout();
        Session::flush();
        return redirect('/');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function getChangePassword(){
        return view('dashboard.changePassword');
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
        $currentUser = User::findOrFail($id);

        $currentUser->password = Hash::make($request->input('newPassword'));

        $currentUser->save();

        alert()->success('Password successfully changed.', 'Success')->persistent('Ok');

        return redirect()->route('home');
    }
}

