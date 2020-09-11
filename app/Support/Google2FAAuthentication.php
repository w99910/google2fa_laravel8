<?php
namespace App\Support;
use PragmaRX\Google2FALaravel\Support\Authenticator;
class Google2FAAuthentication extends Authenticator
{
    // If User does not have Google2FA Setup yet
    protected function canPassWithoutCheckingOTP()
    {
        if($this->getUser()->password_security == null)
        {
            return true;
        }
//        return !$this->getUser()->password_security->google2fa_enable || !$this->isEnabled() || $this->noUserIsAuthenticated() || $this->twoFactorAuthStillValid();
        return  $this->twoFactorAuthStillValid();

    }


    protected function getGoogle2FaSecretkey()
    {
        // Get User secret column
        try {
            $secret = $this->getUser()->password_security->{$this->config('otp_secret_column')};
        } catch (\Exception $e) {
            // If User has not set up Google2FA
            $secret = $this->getUser()->password_security;
        }

        // If User is not Authenticated through 2FA
        if(is_null($secret) || empty($secret)) {

            // return Action
            return redirect()->action('PasswordSecurityController@generate');
        }

        // If user has Google2FA setup and is Authenticated
        return $secret;
    }
}
?>
