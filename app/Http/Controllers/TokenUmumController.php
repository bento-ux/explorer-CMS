<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TokenUmumController extends Controller
{

  
    protected $modelName;


    public function setModel($subdomain)
    {
        $modelClass = "App\\Models\\" . ucfirst($subdomain); // Menetapkan model berdasarkan subdomain
        if (class_exists($modelClass)) {
            $this->modelName = $modelClass; // Tetapkan model jika kelas ada
        } else {
            abort(404, "Model for subdomain '{$subdomain}' not found."); // Tampilkan pesan error 404 jika model tidak ada
        }
    }

    public function detailCampaign($subdomain, $txhash)
    {
        $imageFolder = public_path('image'); 

        $files = glob($imageFolder . "/{$subdomain}.*");
    
        $logoPath = trim($files ? asset('image/' . basename($files[0])) : asset('image/default.webp'));
        $this->setModel($subdomain);

        $allData = $this->modelName::where('txhash', $txhash)->get();

        foreach ($allData as $data) {
            $invoiceNumber = $data->invoice_number;
            $apiResponse = Http::get("https://uat-pay.bmh.or.id/api/v1/invoice/{$invoiceNumber}");

            // Pastikan API mengembalikan data yang valid
            if ($apiResponse->successful()) {
                $apiData = $apiResponse->json();
                // Gabungkan data API, misalnya menambahkan kolom 'campaign' ke setiap row
                $data->campaign = $apiData['campaign'] ?? null;
                $data->donate_at = $apiData['donate_at'] ?? null;
            } else {
                $data->campaign = 'API Error'; // Menandakan jika ada error pada response API
            }
        }
        // dd($allData);

        return view('detail-campaign', [
            'txHash' => $txhash,
            'allData' => $allData,
            'subdomain' => $subdomain,
            'logoPath' => $logoPath
        ]);
    }

    public function listTokenUmum($subdomain)
    {
        $imageFolder = public_path('image'); 

        $files = glob($imageFolder . "/{$subdomain}.*");
    
        $logoPath = trim($files ? asset('image/' . basename($files[0])) : asset('image/default.webp'));
        // Set model yang digunakan berdasarkan subdomain
        $this->setModel($subdomain);

        // Query untuk mengambil ringkasan token
        $results = $this->modelName::select('tokenName','tokenUmumSymbol')
               ->selectRaw('SUM(amount) as totalAmount')
            ->groupBy('tokenName', 'tokenUmumSymbol')
            ->get(); // Mengambil satu hasil pertam

        // Mengirimkan data ke view
        return view('token-umum', [
            'results' => $results,
            'subdomain' => $subdomain,
            'logoPath' => $logoPath
        ]);
    }
    public function detailTokenUmum($subdomain, $tokenName)
    {
        $imageFolder = public_path('image'); 

        $files = glob($imageFolder . "/{$subdomain}.*");
    
        $logoPath = trim($files ? asset('image/' . basename($files[0])) : asset('image/default.webp'));
        // Buat instance model berdasarkan nama subdomain
        // $modelName = "App\\Models\\" . ucfirst($subdomain);

        $this->setModel($subdomain);
        
        // Query untuk mengambil ringkasan token
        $tokenSummary = $this->modelName::selectRaw('
                tokenName,
                tokenUmumSymbol,
                SUM(amount) as totalAmount,
                SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) as currentToken,
                SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) as totalDistributed
            ')
            ->where('tokenName', $tokenName)
            ->groupBy('tokenName', 'tokenUmumSymbol')
            ->first();

        // Query untuk mengambil jumlah program spesifik ketika status = 1
        $programs = $this->modelName::select('program')
            ->selectRaw('SUM(amount) as programTotalAmount')
            ->where('tokenName', $tokenName)
            ->where('status', 1)
            ->groupBy('program')
            ->get();

        // Query untuk mengambil semua data untuk tokenName tertentu
        $allData = $this->modelName::where('tokenName', $tokenName)->get();

        // Loop untuk menggabungkan setiap row dari $allData dengan data API
        foreach ($allData as $data) {
            $invoiceNumber = $data->invoice_number;
            $apiResponse = Http::get("https://uat-pay.bmh.or.id/api/v1/invoice/{$invoiceNumber}");

            // Pastikan API mengembalikan data yang valid
            if ($apiResponse->successful()) {
                $apiData = $apiResponse->json();
                // Gabungkan data API, misalnya menambahkan kolom 'campaign' ke setiap row
                $data->campaign = $apiData['campaign'] ?? null;
            } else {
                $data->campaign = 'API Error'; // Menandakan jika ada error pada response API
            }
        }

        // Parsing data ke view
        return view('token-umum-detail', [
            'tokenSummary' => $tokenSummary,
            'programs' => $programs,
            'allData' => $allData,
            'tokenName' => $tokenName,
            'subdomain' => $subdomain,
            'logoPath' => $logoPath
        ]);
    }
}



