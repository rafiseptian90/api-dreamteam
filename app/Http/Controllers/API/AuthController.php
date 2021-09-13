<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libs\Response;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Models\Profile;
use Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        // add middleware
        $this->middleware('auth.jwt', ['only' => ['logout', 'profile', 'updateProfile', 'changePassword']]);
    }

    // register new user
    public function register(AuthRequest $request){
        $registerRequest = $request->only(['email', 'username', 'password']);
        $registerRequest['password'] = bcrypt($request->password);

        $user = User::create($registerRequest);
        $user->profile()->create([
            'name' => $request->name
        ]);

        return Response::success("Registration completed");
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return Response::unauthorized("Unauthorized");
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->with(['profile'])->first()
        ]);
    }

    // Logout
    public function logout()
    {
        auth()->logout();

        return Response::success("Logout successfully");
    }

    // Get user with their profile
    public function profile()
    {
        $user = auth()->user();
        $user['profile'] = auth()->user()->profile;

        return Response::successWithData("User has been loaded", $user);
    }

    // Update user with their profile
    public function updateProfile(AuthRequest $request)
    {
        $user = auth()->user();
        
        $userRequests = $request->only(['username', 'email']);
        $profileRequests = $request->except(['username', 'email']);

        $user->update($userRequests);

        // if user uploaded photo
        if($request->hasFile('photo')){
            if($user->profile->photo !== NULL){
                cloudinary()->destroy('users/' . $user->username);
            }

            // store photo on cloudinary
            $profileRequests['photo'] = $request->file('photo')->storeOnCloudinaryAs('users', $user->username);
        }

        $user->profile()->update($profileRequests);

        return Response::success("User has been updated");
    }

    // Change user password
    public function changePassword(Request $request)
    {
        // validation
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        $user = auth()->user();

        if(!Hash::check($request->old_password, auth()->user()->password))
        {
            return Response::error("Password didn't match !");
        }

        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return Response::success("Password has been changed");
    }
}
