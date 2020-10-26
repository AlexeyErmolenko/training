<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\WebController;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\JWTAuth;

/**
 * Email Verification Controller
 *
 * This controller is responsible for handling email verification for any
 * user that recently registered with the application. Emails may also
 */
class VerificationController extends WebController
{
    use VerifiesEmails {
        verify as verifyEmail;
    }

    public function __construct()
    {
        URL::forceRootUrl(config('app.api'));
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function show(): View
    {
        return view('auth.verify');
    }

    /**
     * Verify user email (follow verification link in email).
     * After successful verification user will be redirected to <FRONTEND_URL>/email-confirmed?token=<JWT_TOKEN>
     *
     * @param Request $request HTTP Request
     * @param JWTAuth $jwtAuth Issue JWT Token for frontend
     *
     * @return Response|View
     *
     * @throws AuthorizationException
     */
    public function verify(Request $request, JWTAuth $jwtAuth)
    {
        if (!$request->hasValidSignature()) {
            return view('auth.resend', ['email' => $request->get('email')]);
        }

        /**
         * User following verification link in email
         *
         * @var User $user
         */
        $user = User::query()->findOrFail((int)$request->route('id'));
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        if ($user->hasVerifiedEmail()) {
            return redirect(config('app.url'));
        }

        $this->redirectTo = config('app.url').'/email-confirmed?token='.$jwtAuth->fromUser($user);
        return $this->verifyEmail($request);
    }

    /**
     * Handle click on button "resend email confirmation link":
     *
     * Send confirmation email to user, who already started registration, but didn't receive
     * confirmation link or that link has expired.
     *
     * @param Request $request HTTP Request
     *
     * @return RedirectResponse
     */
    public function resend(Request $request): RedirectResponse
    {
        $data = $request->validate([User::EMAIL => 'required|email']);
        /**
         * User who wants to resend email verification link
         *
         * @var User $user
         */
        $user = User::query()->where(User::EMAIL, $data[User::EMAIL])->first();
        if (!$user) {
            throw new NotFoundHttpException(trans('errors.account.register_first'));
        }
        if ($user->hasVerifiedEmail()) {
            throw new AccessDeniedHttpException(trans('errors.account.email_already_confirmed'));
        }
        $user->sendEmailVerificationNotification();
        return redirect(route('verification.notice'));
    }
}
