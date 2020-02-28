<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserValidateRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\PassportToken;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use GuzzleHttp\Client;
use MediaUploader;
use Plank\Mediable\Media;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    use ApiResponser;
    use PassportToken;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
		];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors() , 422);
        }
            
        $user = User::where('email' , $request->email)->first();
        if($user !== null) {
            if (Hash::check($request->password ,$user->password))
            {
                $tkn = $this->getBearerTokenByUser($user, '2', false);
                $user['access_token'] = $tkn['access_token'];
                return $this->successResponse($user,200);
            } else {
                return $this->errorResponse('the password in not valid' , 400);
            }
        } else {
            return $this->errorResponse('user has not found' , 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserValidateRequest $request)
    {
        $userValidated = $request->validated();
        
        $user = User::create([
            'email' => $userValidated['email'],
            'password' => bcrypt($userValidated['password']),
            'phone_number' => $userValidated['phone_number']
        ]);
        
        if($user) {
            $tkn = $this->getBearerTokenByUser($user, '2', false);
            $user['access_token'] = $tkn['access_token'];
        }
        return $this->successResponse($user,201);
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
        //
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

    public function uploadAvatar(Request $request) {
		$user = User::findOrFail(auth()->id());

		$media = MediaUploader::fromSource($request->avatar)->onDuplicateIncrement()->upload();
			 $mediaUrl = $media->getUrl();
			 $user['avatar'] = $mediaUrl;
			 $user->save();
			 return $this->successResponse($user, 200);
    }
    
    public function logout(Request $request) {
        $accessToken = Auth::user()->token();
			DB::table('oauth_refresh_tokens')
				->where('access_token_id', $accessToken->id)
				->update([
					'revoked' => true,
				]);

            $accessToken->revoke();
            return $this->successResponse(['status' => true], 200);
    }
}
