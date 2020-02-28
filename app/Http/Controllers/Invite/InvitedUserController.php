<?php

namespace App\Http\Controllers\Invite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Party;
use App\User;
use App\InvitedUser;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;
use App\Mail\inviteMail;

class InvitedUserController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // People invited by this user
        $user = auth()->user();
        $usersInvited =  $user->InvitedUser;
        $finalUsers = array();
        foreach($usersInvited as $member) {
            $user = User::where('user_id' , $member->invite_user)->first();
            $data = [
                'user_id' => $member->invite_user,
                'email' => $user->email,
                'party_date' => $member->party_date,
                'is_come' => $member->is_come
            ];
            array_push($finalUsers , $data);
        }
        return $this->successResponse($finalUsers , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = auth()->id();
        $party = Party::orderBy('created_at' , 'desc')->where('user_id' , $userId)->first();
        if($party == null) {
            return $this->errorResponse(['message' => 'شما مهمانی ست نکردین'] , 404);
        }
       
        $invited = User::where('email' , $request->email)->first(); 
       if($invited !== null) {
           $userParty = InvitedUser::where('invite_user' , $invited->user_id)
           ->where('party_id' , $party->party_id)->first();
        
           if($userParty == null) {
                $InvitedUser = InvitedUser::create([
                    'user_id' => $userId,
                    'party_id' => $party->party_id,
                    'party_date' => $party->start_date,
                    'invite_user' => $invited->user_id
                ]);
                Mail::to($request->email)->send(new inviteMail(auth()->user() , $party) );
                return $this->successResponse($InvitedUser , 201);
           } else {
            return $this->errorResponse(['message' => 'این کاربر قبلا در این مهمانی دعوت شده'] , 400);
           }
       } else {
          return $this->errorResponse(['message' => 'این کاربر یافت نشد'] , 404);
       }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->id();
        $party = InvitedUser::where('party_id', $id)->where('user_id' , $user)->first();
        if($party !== null) {
            $party->update([
                'is_come' => ! $party->is_come
            ]);
            return $this->successResponse(['message' => 'حضور کاربر در مهمانی آپدیت شد' , 'coming' => $party->is_come] , 200);
        } else {
            return $this->errorResponse(['message' => 'شما در این مهمانی دعوت نیستید'] , 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function partiesInvited(request $request) {

        //  which party this user is invited
        $user = auth()->id();
        $inviteds = InvitedUser::where('invite_user' , $user)->get();
        if($inviteds->isEmpty()) {
            return $this->errorResponse(['message' => 'شما در هیچ مهمانی دعوت نیستید'] , 404);
        } else {
            $final = array();
            foreach($inviteds as $invited) {
                $user = User::where('user_id' , $invited->user_id)->first();
                $party = Party::where('party_id' , $invited->party_id)->first();
                
                $data = [
                    'party_description' => $party->description,
                    'party_theme' => $party->theme_party,
                    'party_date' => $invited->party_date,
                    'caller' => [
                        'user_id' => $invited->invite_user,
                        'avatar' => $user->avatar,
                        'email' => $user->email,
                    ]
                ];
                array_push($final , $data);
            }
            
            return $this->successResponse($final , 200);
        }

    }
}
