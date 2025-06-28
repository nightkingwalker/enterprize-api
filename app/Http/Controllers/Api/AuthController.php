<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,project_manager,translator,reviewer,client',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Generate tokens with standard expiration
        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::claims([
            'exp' => Carbon::now()->addDays(30)->timestamp,
            'is_refresh_token' => true
        ])->fromUser($user);

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]
        ], 201);
    }

    /**
     * Authenticate user and return JWT tokens
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberMe = $request->boolean('remember_me', false);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = auth()->user();

            // Handle 2FA if enabled
            if ($user->two_factor_enabled) {
                $tempToken = JWTAuth::claims([
                    'is_2fa' => true,
                    'exp' => Carbon::now()->addMinutes(10)->timestamp
                ])->fromUser($user);

                return response()->json([
                    'status' => '2fa_required',
                    'temporary_token' => $tempToken,
                    'user_id' => $user->id
                ]);
            }

            // Token expiration logic
            $accessTokenExpiry = $rememberMe
                ? Carbon::now()->addDays(30)->timestamp
                : Carbon::now()->addHours(2)->timestamp;

            $refreshTokenExpiry = Carbon::now()->addDays(30)->timestamp;

            // Generate tokens
            $accessToken = JWTAuth::claims([
                'exp' => $accessTokenExpiry,
                'remember_me' => $rememberMe
            ])->attempt($credentials);

            $refreshToken = JWTAuth::claims([
                'exp' => $refreshTokenExpiry,
                'is_refresh_token' => true
            ])->attempt($credentials);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                    'token_type' => 'bearer',
                    'expires_in' => $accessTokenExpiry,
                    'user' => $user
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh access token using refresh token
     */
    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->input('refresh_token') ?? JWTAuth::getToken();

            // Verify it's a refresh token
            $payload = JWTAuth::setToken($refreshToken)->getPayload();

            if (!$payload->get('is_refresh_token')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid token type'
                ], 401);
            }

            // Generate new access token
            $newAccessToken = JWTAuth::claims([
                'exp' => Carbon::now()->addHours(2)->timestamp,
                'remember_me' => $payload->get('remember_me', false)
            ])->refresh($refreshToken);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'access_token' => $newAccessToken,
                    'expires_in' => Carbon::now()->addHours(2)->timestamp
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token refresh failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user (invalidate tokens)
     */
    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $refreshToken = $request->input('refresh_token');

            // Invalidate both tokens
            JWTAuth::invalidate($token);

            if ($refreshToken) {
                JWTAuth::invalidate($refreshToken);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Verify 2FA code and return final tokens
     */
    public function verify2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $tempToken = $request->input('temporary_token');
            $payload = JWTAuth::setToken($tempToken)->getPayload();

            // Verify it's a 2FA token
            if (!$payload->get('is_2fa')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid token type'
                ], 401);
            }

            $user = User::findOrFail($payload->get('sub'));

            // Verify 2FA code (implement your 2FA verification logic here)
            if (!$this->verifyTwoFactorCode($user, $request->code)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid 2FA code'
                ], 401);
            }

            // Generate final tokens
            $accessToken = JWTAuth::claims([
                'exp' => Carbon::now()->addHours(2)->timestamp
            ])->fromUser($user);

            $refreshToken = JWTAuth::claims([
                'exp' => Carbon::now()->addDays(30)->timestamp,
                'is_refresh_token' => true
            ])->fromUser($user);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                    'expires_in' => Carbon::now()->addHours(2)->timestamp,
                    'user' => $user
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => '2FA verification failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to verify 2FA code
     */
    protected function verifyTwoFactorCode(User $user, string $code): bool
    {
        // Implement your 2FA verification logic here
        // This is just a placeholder implementation
        return true; // Replace with actual 2FA verification
    }
}
