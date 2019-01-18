<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Addresses;

class UserController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['settings', 'editUser']]);
    }
	
	public function settings(Request $request)
	{
		$user = Auth::user();
		$address = Addresses::where('id', $user['addressID'])->first();
		
    	$combined = array();
    	array_push($combined, $user);
    	array_push($combined, $address);
		
		return view('user.settings', compact('combined'));
	}

    public function getAllUsers()
    {
        $allUsers = $this->getNonDisabledUsers(1);
        return view('admin.users', compact('allUsers'));
	}

    public function editUser(Request $request )
    {
        if(!Auth::user()->admin == 1){
            $request['userID'] = Auth::user()->id;
        }
        $user = User::where('id', $request['userID'])->first();

        User::where('id', $request['userID'])->update([
            'firstName' => $request['firstName'],
            'middleName' => $request['middleName'],
            'lastName' => $request['lastName'],
            'email' => $request['email']
        ]);

        Addresses::where('id', $user['addressID'])->update([
            'streetName' => $request['streetName'],
            'houseNumber' => $request['houseNumber'],
            'postalCode' => $request['postalCode'],
            'city' => $request['city']
        ]);

        return redirect()->back()->with('message-success', 'User editted');
	}

    public function disableUser($userID)
    {
        $allUsers = $this->getNonDisabledUsers(1);
        User::where('id', $userID)->update([
           'disabled' => 1
        ]);
        return redirect()->route('getAllUsers',  compact('allUsers'))->with('message-success', 'Gebruiker met ID: ' . $userID . ' is succesvol verwijderd.');
	}

    public function activateUser($userID)
    {
        $allUsers = $this->getNonDisabledUsers(0);
        User::where('id', $userID)->update([
            'disabled' => 0
        ]);
        return redirect()->route('getRemovedUsers',  compact('allUsers'))->with('message-success', 'Gebruiker met ID: ' . $userID . ' is succesvol geactiveerd.');
	}

    public function getRemovedUsers()
    {
        $allUsers = $this->getNonDisabledUsers(0);
        return view('admin.users', compact('allUsers'));
	}

	public function getNonDisabledUsers($notDisabled)
    {
	    return User::where('disabled', '!=', $notDisabled)->get();
    }

    public function adminGetUser(Request $request, $id)
    {
        if($id == "removedUsers") {
            return $this->getRemovedUsers();
        }
        $user = User::where('id', $id)->first();
        $address = Addresses::where('id', $user->addressID)->first();

        $combined = array();
        array_push($combined, $user);
        array_push($combined, $address);

        return view('user.settings', compact('combined'));
    }


}

	