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
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * pay through stripe
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function checkOut(Request $request)
    {
        $stripeCode = $request->stripeToken;
        $user = auth()->user()->phoneNumber;
        $email = $request->stripeEmail;
        $houseID = $request->houseID;
        $id = $request->id;
        $amount = $request->price;

        $landlord = Houses::where('houseID',$houseID)->first();
        $landPhoneNumber = $landlord->landPhoneNumber;


       try {
           Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
           $paid = number_format($request->price);
           $name = $request->item;

           $customer = Customer::create([
               'email' => $request->stripeEmail,
               'source' => $request->stripeToken
           ]);

           $charge = Charge::create([
               'customer' => $customer->id,
               'amount' => $request->price * 100,
               'currency' => 'kes'
           ]);

           alert()->success( "You have successfully paid KES $paid to book 1 unit at $name. ", 'Success')->persistent();

           //update stripe
           $stripe = new StripeStatements([
               'user'=>$user,
               'landlord'=>$landPhoneNumber,
               'amount'=>$amount,
               'referenceCode'=>$stripeCode,
               'houseID'=>$houseID,
               'email'=>$email
           ]);
           $stripe->save();


           //make updates
           $this->update($id);

           return redirect()->back();
       } catch (\Exception $ex) {
           alert()->error( $ex->getMessage(), 'Error')->persistent();
           return redirect()->back();
       }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Request $request
     */
    public function update($id){

        $user = auth()->user()->phoneNumber;
        $userName = auth()->user()->name;

        //update house
        $house = Houses::find($id);
        $house->booked += 1;
        $house->save();

        //notifications
        $houseName = $house->houseName;
        $landlordPhoneNumber = $house->landPhoneNumber;
        $rent = number_format($house->price);
        $amount = $house-> price;
        $houseID = $house->houseID;

        //admin
        PageController::sendNotifs(env('ADMIN'), env('ADMIN'), 'Successful booking',"1 unit at $houseName has been successfully Booked by $userName $user");
        $admin = Admin::where('username',env('ADMIN'))->first();
        $admin->messages += 1;
        $admin->save();

        //landlord
        PageController::sendNotifs(env('ADMIN'), $landlordPhoneNumber, 'Successful booking',"1 unit at $houseName has been successfully Booked by $userName $user");
        $landlord = Landlord::where('phoneNumber',$landlordPhoneNumber)->first();
        if(count($landlord) > 0){
            $landlord->notifs += 1;
            $landlord->save();
        }
        //user
        PageController::sendNotifs(env('ADMIN'), $user, 'Successful booking',"You have successfully Booked 1 unit at $houseName. Your recurring monthly rent is KES $rent ");
        $userNotifs  = User::where('phoneNumber',$user)->first();
        $userNotifs->messages += 1;
        $userNotifs->save();

        //update statements
        $statement = new MsStatement([
            'initiator'=>$user,
            'benefactor'=>$landlordPhoneNumber,
            'houseID'=> $houseID,
            'action' => 'book',
            'amount' => $amount,
            'description' => "$houseName Booked for KES $amount"
        ]);
        $statement->save();

    }
}
