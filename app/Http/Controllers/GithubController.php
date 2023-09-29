<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller {

    public function redirect() {
        return Socialite::driver( 'github' )->redirect();
    }

    public function callback() {
        $githubUser = Socialite::driver( 'github' )->user();

        $user = User::createOrFirst( [
            'email' => $githubUser->email
        ], [
            'social_id'    => $githubUser->id,
            'name'         => $githubUser->name,
            'social_token' => $githubUser->token,
            'login_type'   => 'github'
        ] );

        if ( $user->login_type !== 'github' ) {
            return redirect( 'login' )->withErrors( [ "email" => "Your email already used to manage another account !" ] );
        }

        Auth::login( $user );

        return redirect( '/dashboard' );
    }

}
