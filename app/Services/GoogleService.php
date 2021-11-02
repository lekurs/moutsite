<?php

namespace App\Services;

use App\Http\Entity\Oauth;
use App\Repository\GoogleRepository;
use App\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class googleService
 * @package App\Services
 */
class GoogleService
{
    /** @var string $baseUrl */
    private $baseUrl;

    /** @var GoogleRepository $googleRepository */
    private GoogleRepository $googleRepository;

    /**
     * googleService constructor.
     * @param GoogleRepository $googleRepository
     */
    public function __construct(GoogleRepository $googleRepository)
    {
        $this->baseUrl = config('services.google.endpoints.baseUrl');
        $this->googleRepository = $googleRepository;
    }

    /**
     * @return string
     */
    public function authorizeUrl(): string
    {
        return $this->baseUrl . config('services.google.endpoints.authorize') . $this->queries();
    }

    /**
     * @return string
     */
    private function queries(): string
    {
        return http_build_query([

            'scope' => 'email',
            'access_type' => 'online',
            'include_granted_scopes' => 'true',
            'response_type' => 'code',
            'state' => 'state_parameter_passthrough_value',
            'redirect_uri' => config('services.google.redirect'),
            'client_id' => config('services.google.client_id'),
        ]);
    }

    /**
     * @return string[]
     */
    public function getTokens(): array
    {
        $response = Http::asForm()->post(config('services.google.endpoints.token'), [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => request()->code,
            'redirect_uri' => route('auth.google.callback'),
            'scope' => 'https://www.googleapis.com/auth/userinfo.profile'
        ]);
        return [
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
        ];
    }

    /**
     * @param array $tokens
     * @return Oauth|null
     */
    public function getUser(array $tokens): ?Oauth
    {
        $response = Http::withToken($tokens['access_token'])->get(config('services.google.endpoints.me'));
        return $this->googleRepository->createUser([
            'google_id' => $response['id'],
            'email' => $response['email'],
            'access_token' => $tokens['access_token'],
            'expires_at' => $tokens['expires_in']
        ]);
    }
}
