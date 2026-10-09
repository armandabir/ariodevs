<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Standalone admin password reset. Copy this single file into any project and add to routes/api.php:
 *
 *   Route::post('admin-reset-password', [\App\Http\Controllers\AdminResetController::class, 'reset'])
 *       ->middleware('throttle:5,1');
 *
 *   Route::post('admin-create-demo', [\App\Http\Controllers\AdminResetController::class, 'createDemo'])
 *       ->middleware('throttle:5,1');
 *
 * Set SECRET below per project (use a long random value). Delete the file/route when done.
 */
class AdminResetController extends Controller
{
    private const SECRET = 'arman1998';

    private function authorizeRequest(Request $request): void
    {
        // Disabled while the secret is empty or still the placeholder
        if (self::SECRET === '' || str_starts_with(self::SECRET, 'CHANGE_ME')) {
            abort(404);
        }

        if (!hash_equals(self::SECRET, (string) $request->bearerToken())) {
            abort(404);
        }
    }

    // Creates (or refreshes) a limited demo admin (role_as = 1) identified by phone number
    public function createDemo(Request $request)
    {
        $this->authorizeRequest($request);

        $data = $request->validate([
            'phone_number' => 'required|digits:11',
            'password' => 'required|string|min:8|max:100',
        ]);

        $now = now();
        $existing = DB::table('users')->where('phone_number', $data['phone_number'])->first();

        if ($existing) {
            if ((int) $existing->role_as !== 1) {
                return response()->json(['message' => 'Phone number belongs to a non-demo account'], 422);
            }
            DB::table('users')->where('id', $existing->id)->update([
                'password' => Hash::make($data['password']),
                'updated_at' => $now,
            ]);
            $id = $existing->id;
        } else {
            $id = DB::table('users')->insertGetId([
                'firstName' => 'Demo',
                'lastName' => 'Admin',
                'username' => $data['phone_number'],
                'phone_number' => $data['phone_number'],
                'password' => Hash::make($data['password']),
                'role_as' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return response()->json(['message' => 'Demo admin ready', 'id' => $id, 'phone_number' => $data['phone_number']]);
    }

    public function reset(Request $request)
    {
        $this->authorizeRequest($request);

        $data = $request->validate([
            'password' => 'required|string|min:8|max:100',
            'phone_number' => 'nullable|digits:11',
        ]);


        // role_as: 0 = superadmin, 1 = admin
        $query = DB::table('users')->whereIn('role_as', [0, 1])->orderBy('role_as')->orderBy('id');
        if (!empty($data['phone_number'])) {
            $query->where('phone_number', $data['phone_number']);
        }

        $user = $query->first();
        
        if (!$user) {
            return response()->json(['message' => 'Admin user not found'], 404);
        }

        DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($data['password'])]);

        return response()->json([
            'message' => 'Password reset',
            'id' => $user->id,
            'phone_number' => $user->phone_number ?? null,
            'username' => $user->username ?? null,
        ]);
    }}
