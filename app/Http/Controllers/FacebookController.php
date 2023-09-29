<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller {

    public function redirect() {
        return Socialite::driver( 'facebook' )->redirect();
    }

    public function callback() {
        $facebookUser = Socialite::driver( 'facebook' )->user();

        $user = User::createOrFirst( [
            'email' => $facebookUser->email,
        ], [
            'social_id'    => $facebookUser->id,
            'name'         => $facebookUser->name,
            'social_token' => $facebookUser->token,
            'login_type'   => 'facebook'
        ] );

        if ( $user->login_type !== 'facebook' ) {
            return redirect( 'login' )->withErrors( [ "email" => "Your email already used to manage another account !" ] );
        }

        Auth::login( $user );

        return redirect( '/dashboard' );
    }

}
