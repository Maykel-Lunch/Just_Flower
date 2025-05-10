<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function uploadConfirmationPhoto(Request $request)
    {
        $request->validate([
            'orderId' => 'required|exists:orders,order_id',
            'confirmation_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $photo = $request->file('confirmation_photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->getRealPath();

            $supabaseUrl = env('SUPABASE_URL');
            $supabaseKey = env('SUPABASE_KEY');
            $bucketName = env('SUPABASE_BUCKET');

            // 1. Upload the file to Supabase Storage
            $uploadResponse = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
            ])->attach(
                'file', file_get_contents($photoPath), $photoName
            )->post("$supabaseUrl/storage/v1/object/$bucketName/$photoName");

            if (!$uploadResponse->successful()) {
                throw new \Exception('Supabase upload failed: ' . $uploadResponse->body());
            }

            // 2. Get the file metadata to retrieve UUID
            $metadataResponse = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
            ])->get("$supabaseUrl/storage/v1/object/info/$bucketName/$photoName");

            if (!$metadataResponse->successful()) {
                throw new \Exception('Failed to get file metadata: ' . $metadataResponse->body());
            }

            $fileData = $metadataResponse->json();
            $fileUuid = $fileData['id'];

            // 3. Update the order with the UUID reference
            $order = Order::where('order_id', $request->orderId)->first();
            $order->update([
                'confirmation_photo' => $fileUuid,
                // 'status' => 'delivered' // Optional: update status if needed
            ]);

            // 4. Return both UUID and public URL for convenience
            $publicUrl = "$supabaseUrl/storage/v1/object/public/$bucketName/$photoName";

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded and order updated successfully!',
                'file_uuid' => $fileUuid,
                'public_url' => $publicUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Upload error', [
                'error' => $e->getMessage(),
                'orderId' => $request->orderId ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to get file URL from UUID
     */
    public static function getFileUrl($uuid)
    {
        if (!$uuid) return null;

        try {
            $supabaseUrl = env('SUPABASE_URL');
            $supabaseKey = env('SUPABASE_KEY');
            $bucketName = env('SUPABASE_BUCKET');

            $response = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
            ])->get("$supabaseUrl/storage/v1/object/info/$bucketName", [
                'id' => $uuid
            ]);

            if ($response->successful()) {
                $fileData = $response->json();
                return "$supabaseUrl/storage/v1/object/public/$bucketName/{$fileData['name']}";
            }
        } catch (\Exception $e) {
            Log::error('Failed to get file URL', ['uuid' => $uuid, 'error' => $e->getMessage()]);
        }

        return null;
    }
}