<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WilayahController extends Controller
{
    /**
     * Get all provinces
     */
    public function provinces()
    {
        try {
            $url = 'https://wilayah.id/api/provinces.json';
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'ignore_errors' => true
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ]);
            
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                return response()->json(['error' => 'Failed to fetch provinces'], 500);
            }
            
            $data = json_decode($response, true);
            return response()->json($data);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get regencies by province code
     */
    public function regencies($provinceCode)
    {
        try {
            $url = "https://wilayah.id/api/regencies/{$provinceCode}.json";
            
            $context = stream_context_create([
                'http' => ['timeout' => 10, 'ignore_errors' => true],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ]);
            
            $response = file_get_contents($url, false, $context);
            if ($response === false) {
                return response()->json(['error' => 'Failed to fetch regencies'], 500);
            }
            
            return response()->json(json_decode($response, true));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get districts by regency code
     */
    public function districts($regencyCode)
    {
        try {
            $url = "https://wilayah.id/api/districts/{$regencyCode}.json";
            
            $context = stream_context_create([
                'http' => ['timeout' => 10, 'ignore_errors' => true],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ]);
            
            $response = file_get_contents($url, false, $context);
            if ($response === false) {
                return response()->json(['error' => 'Failed to fetch districts'], 500);
            }
            
            return response()->json(json_decode($response, true));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get villages by district code
     */
    public function villages($districtCode)
    {
        try {
            $url = "https://wilayah.id/api/villages/{$districtCode}.json";
            
            $context = stream_context_create([
                'http' => ['timeout' => 10, 'ignore_errors' => true],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ]);
            
            $response = file_get_contents($url, false, $context);
            if ($response === false) {
                return response()->json(['error' => 'Failed to fetch villages'], 500);
            }
            
            return response()->json(json_decode($response, true));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
