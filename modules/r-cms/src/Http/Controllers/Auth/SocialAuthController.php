<?php

namespace RSolution\RCms\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RSolution\RCms\Models\User;
use RSolution\RCms\Repositories\PlanRepository;
use RSolution\RCms\Repositories\UserRepository;
use Socialite;

class SocialAuthController extends Controller
{
    protected $scope;

    public function __construct()
    {
        $this->scope = [
            // 'https://www.googleapis.com/auth/user.birthday.read',
        ];
    }

    private function setPreUrl()
    {
        if (URL::previous() == URL::to('login'))
            Session::put('pre_url', RouteServiceProvider::HOME);
        else
            Session::put('pre_url', URL::previous());
    }

    /**
     * Redirect into OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        $this->setPreUrl();
        return Socialite::driver($provider)
            ->scopes($this->scope)
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = $this->getSocialLiteUser($provider);

        if (empty($user))
            return redirect(route('login'));

        //Check user in DB
        $authUser = $this->findUser($user, $provider);
        if ($authUser) {
            Auth::login($authUser, true);
            return redirect(Session::get('pre_url'));
        } else {

            //Create new User
            $authUser = (new UserRepository)->create(
                $this->buildUserInfo($user, $provider)
            );
            
            $authUser = (new UserRepository)->find($authUser->id);

            event(new Verified($authUser));
            Auth::login($authUser, true);

            return redirect(RouteServiceProvider::HOME);
        }
    }

    /**
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->orWhere('email', $user->email)->first();
        if ($authUser) {
            if (!$authUser->email_verified_at) {
                $authUser->email_verified_at = now();
                event(new Verified($authUser));
            }

            $authUser->provider_id = $user->id;
            $authUser->save();
            return $authUser;
        } else
            return null;
    }

    private function getSocialLiteUser($provider)
    {
        try {
            return Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return null;
        }
    }

    private function buildUserInfo($user, $provider)
    {
        return [
            'name'              => !empty($user->user['given_name']) ? $user->user['given_name'] : $user->getName(),
            'last_name'         => !empty($user->user['family_name']) ? $user->user['family_name'] : null,
            'email'             => $user->getEmail(),
            'password'          => bcrypt(Str::random()),
            //'birth'             => $this->getUserBirth($user->token),
            'provider'          => $provider,
            'provider_id'       => $user->getId(),
            'email_verified_at' => now(),
            'ref_id' => Session::get('ref_id'),
            'plan' => PlanRepository::PLAN_FREE
        ];
    }

    private function getUserByToken($token)
    {
        $client = new Client();
        $response = $client->get('https://people.googleapis.com/v1/people/me', [
            'query' => [
                'prettyPrint' => 'false',
                'personFields' => 'birthdays',
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    private function getUserBirth($token)
    {
        try {
            $data = $this->getUserByToken($token);
            if ($data['birthdays']) {
                foreach ($data['birthdays'] as $item) {

                    if (!empty($item['date']) && !empty($item['date']['day']) && !empty($item['date']['month']) && !empty($item['date']['year'])) {
                        $date = $item['date']['year'] . '-' . $item['date']['month'] . '-' . $item['date']['day'];
                        return $date;
                    }
                }
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getOauthToken($user)
    {
        return [
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
            'expires_in' => $user->expiresIn
        ];
    }

    public function updateProfile()
    {
        return view('auth.update_profile', ['user' => Auth::user()]);
    }

    public function updateProfileStore(Request $request)
    {
        User::find(Auth::user()->id)->update($request->all());
        return redirect('/user#/connect-account');
    }
}
