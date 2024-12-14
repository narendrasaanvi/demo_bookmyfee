<?PHP
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SendOTPController extends Controller
{
    // Generate a unique 4-digit OTP
    private function generateUniqueOtp()
    {
        do {
            // Generate a random 4-digit OTP
            $otp = random_int(1000, 9999);

            // Check if the OTP already exists
            $exists = User::where('otp', $otp)->exists();
        } while ($exists);

        return $otp;
    }

    // Send OTP to the user's phone number
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        // Retrieve phone number and generate OTP
        $phone = $request->input('phone');
        $otp = $this->generateUniqueOtp();
        $otpExpiresAt = Carbon::now()->addMinutes(10); // OTP expires in 10 minutes

        // Update OTP and expiration time for the user
        $updated = User::where('phone', $phone)->update([
            'otp' => $otp,
        ]);

        if (!$updated) {
            return response()->json(['message' => 'Phone number not found'], 404);
        }

        // Send OTP via SMS using Fast2SMS API
        $fields = [
            "variables_values" => $otp,
            "route" => 'otp',
            "numbers" => $phone,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => [
                "authorization: " . env('FAST2SMS_API_KEY'), // API key from .env
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['error' => "cURL Error #: " . $err], 500);
        }

        return response()->json([
            'message' => 'OTP sent successfully',
            'response' => json_decode($response),
        ], 200);
    }

    // Verify the OTP provided by the user
    public function verifyOtp(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10', // Ensure phone number is exactly 10 digits
            'otp' => 'required|digits:4',    // Ensure OTP is exactly 4 digits
        ]);

        // If validation fails, return the first validation error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Retrieve user by phone number
        $user = User::where('phone', $request->phone)->first();

        // If no user is found, return an error
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Log the values of OTPs to debug the comparison
        \Log::info('Requested OTP: ' . $request->otp);
        \Log::info('Stored OTP: ' . $user->otp);

        // Check if OTP matches (ensure both are compared as strings)
        if (strval($user->otp) !== strval($request->otp)) {
            return response()->json([
                'error' => 'OTP does not match.',
                'request_otp' => $request->otp,
                'stored_otp' => $user->otp
            ], 400);
        }

        // OTP matches, so clear it and proceed to login
        $user->otp = null; // Clear the OTP after successful verification
        $user->save();     // Save the updated user

        // Log the user in
        auth()->login($user);

        // Return success message
        return response()->json(['message' => 'Login successful.']);
    }

}
