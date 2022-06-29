<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Atm;
use App\Models\Bottle;
use App\Http\Controllers\Controller;
use App\Models\Dompet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Log;

class ATMController extends Controller
{
    //     public function index(){
    //         if(!Session::get('login')){
    //             return redirect('ATM.IDSalah');
    //         }
    //         else{
    //             return view('ATM.signIn');
    //         }

    // }
    public function idcard()
    {
        return view('ATM.IDCard');
    }
    public function idcardPost(Request $request)
    {
        return redirect('atm-menu');
        // $users = User::find($AppID);
        // // $AppID = $request->AppID;
        // // $dt = User::where('AppID',$AppID)->first();
        // if($users){
        //     return redirect('atm-qrcode');
        // }
        // else{
        //     return redirect('atm-idsalah');
        // }
        //     $AppID = $request->AppID;
        //     // $password = $request->password;
        //     $data = User::where('AppID',$AppID)->first();
        //     if($data){
        //         return redirect('atm-qrcode');
        //         //cek data ada/tidak
        //         if(Hash::check($password, $data->password)){
        //             Session::put('AppID', $data->AppID);
        //             Session::put('email',$data->email);
        //             Session::put('atm-idcard', TRUE);//ragu di idcard nya, bs diganti ATM-idcard atau ATM.IDCard 
        //             return redirect('login');//ragu, bisa diganti yg atas
        //         }
        //         else{
        //             return redirect('atm-qrcode');
        //         }
        //     }
        //     else{
        //         // $AppID = $request->AppID;
        //         // $data = User::where('AppID',$AppID)->first();
        //         // echo $data;
        //         return redirect('atm-idsalah');
        // }

    }

    public function getData(Request $request)
    {
        $input = $request->all();

        // Log::info($input);
        $atm = Atm::create($input);
        $lastId = $atm->id;

        // return view('ATM.succes-input', $data);
        return response()->json(['success' => 'Ajax request submitted successfully']);
    }

    public function sendDataSucces(Request $request)
    {
        $bottle = Bottle::find($request->botol_id);

        $penghasilan = $bottle->harga * $request->jmlhBotol;
        $data = Atm::create([
            "jmlhBotol" => $request->jmlhBotol,
            "id_botol" => $request->botol_id,
            "user_id" => auth()->user()->id,
            "penghasilan" => $penghasilan
        ]);
        $updateSaldo = Dompet::where('user_id', auth()->user()->id)->get()->first();
        $updateSaldo->update([
            'saldo' => $updateSaldo->saldo + $penghasilan,
        ]);
        // $data = Atm::where('id', $id)->first();
        return view('ATM.succes-input', compact('data', 'penghasilan'));
    }

    public function getBalance()
    {
        $saldoUser = Dompet::where('user_id', auth()->user()->id)->get()->first();
        $saldoAtm = $saldoUser->saldo;
        return view('ATM.balance', compact('saldoAtm'));
    }

    public function getBalanceUser()
    {
        $data = ATM::where('user_id', auth()->user()->id)->get();
        $jmlhBotol = DB::table('atms')->where('user_id', auth()->user()->id)->sum('jmlhBotol');
        $saldoUser = Dompet::where('user_id', auth()->user()->id)->get()->first();
        $saldoAtm = $saldoUser->saldo;
        return view('wallet', compact('data', 'saldoAtm', 'jmlhBotol'));
    }

    public function inputBotol()
    {
        $itemBotol = Bottle::orderBy('ukuran', 'asc')->get();
        $data = array('itemBotol' => $itemBotol);
        return view('ATM.jmlh-bottle', $data);
    }

    public function getPenghasilan($saldo)
    {
        return view('ATM.penghasilan', compact('saldo'));
    }


    public function updateUserProfileNoPass(Request $request)
    {
        $updateProfil = User::where('id', auth()->user()->id)->get()->first();
        if ($request->file('photo_path') != "") {
            Storage::disk('local')->delete('public/image/photo-profile/' . auth()->user()->profile_photo_path);
            $photo = $request->file('photo_path');
            $fileName = $photo->getClientOriginalName();
            $photo->move(public_path('image/photo-profile'), $fileName);
            $updateProfil->update([
                'first_name' => $request->first,
                'last_name' => $request->last,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'country' => $request->country,
                'account_number' => $request->accnum,
                'address' => $request->address,
                'province' => $request->province,
                'profile_photo_path' => $fileName,
            ]);
        } else {
            $updateProfil->update([
                'first_name' => $request->first,
                'last_name' => $request->last,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'country' => $request->country,
                'account_number' => $request->accnum,
                'address' => $request->address,
                'province' => $request->province
            ]);
        }
        return redirect()->back()->with("success", "Profile successfully changed!");
    }

    public function updatePassword(Request $request)
    {
        if (!(Hash::check($request->old_pass, auth()->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password.");
        }

        if (strcmp($request->old_pass, $request->new_pass) == 0) {
            // Current password and new password same
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'old_pass' => 'required',
            'new_pass' => 'required|string|min:8',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_pass);
        $user->save();
        $request->session()->regenerate();
        Auth::login($user);
        return redirect()->back()->with("success", "Password successfully changed!");
    }
    public function loginID(Request $request)
    {
        if ($request->rekening == auth()->user()->account_number) {
            return view('ATM.menu');
        } else {
            return view('ATM.IDSalah');
        }
        return view('ATM.IDSalah');
    }

    // public function showJumlah($id){
    //     $data =[
    //         'atm' => $this->Atm->detailData($id),
    //     ];
    //     return view('ATM.jmlh-bottle', $data);
    // }



}
