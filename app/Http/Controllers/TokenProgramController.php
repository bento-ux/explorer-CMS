<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TokenProgramController extends Controller
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

    public function distribusiToken($subdomain, $txhash)
    {
        $imageFolder = public_path('image'); 

        $files = glob($imageFolder . "/{$subdomain}.*");
    
        $logoPath = trim($files ? asset('image/' . basename($files[0])) : asset('image/default.webp'));
        $this->setModel($subdomain);

        $allData = $this->modelName::where('txhashtokenprogram', $txhash)->get();

        $transactions = $this->modelName::select('tokenName', 'program', 'signers', 'tokenUmumSymbol')
            ->selectRaw('SUM(amount) as total_amount')
            ->selectRaw('MAX(tglDisalurkan) AS lastDistributionDate')
            ->where('txhashtokenprogram', $txhash)
            ->groupBy('tokenName', 'program', 'signers', 'tokenUmumSymbol') // Tambahkan GROUP BY untuk kolom non-agregat
            ->first();


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

        return view('distribution', [
            'txHash' => $txhash,
            'transactions' => $transactions,
            'allData' => $allData,
            'subdomain' => $subdomain,
            'logoPath' => $logoPath
        ]);
    }

    public function listTokenProgram($subdomain)
    {
        $imageFolder = public_path('image'); 

        $files = glob($imageFolder . "/{$subdomain}.*");
    
        $logoPath = trim($files ? asset('image/' . basename($files[0])) : asset('image/default.webp'));
        // Set model yang digunakan berdasarkan subdomain
        $this->setModel($subdomain);

        // Query untuk mengambil ringkasan token
        $results = $this->modelName::select('program')
            ->selectRaw('SUM(amount) as totalAmount')
            ->where('status', 1)
            ->groupBy('program')
            ->get(); // Mengambil satu hasil pertam

        // Mengirimkan data ke view
        return view('token-program', [
            'results' => $results,
            'subdomain' => $subdomain,
            'logoPath' => $logoPath
        ]);
    }
    public function detailTokenProgram($subdomain, $program)
    {
        $imageFolder = public_path('image'); 

        $files = glob($imageFolder . "/{$subdomain}.*");
    
        $logoPath = trim($files ? asset('image/' . basename($files[0])) : asset('image/default.webp'));
        // Buat instance model berdasarkan nama subdomain
        // $modelName = "App\\Models\\" . ucfirst($subdomain);

        $this->setModel($subdomain);

        // Query untuk mengambil total amount program
        $programAmount = $this->modelName::selectRaw('
            SUM(amount) as total_program_amount
            ')
            ->where('program', $program)
            ->where('status', 1)
            ->first();

        // Query untuk mendapatkan daftar token penerima dan total per token umum, serta total keseluruhan amount
        $tokenListQuery = $this->modelName::select('tokenName', 'tokenUmumSymbol')
            ->selectRaw('SUM(amount) as total_amount')
            ->where('program', $program)
            ->where('status', 1)
            ->groupBy('tokenName', 'tokenUmumSymbol') // Pastikan kedua kolom ada di GROUP BY
            ->get();


        // Query untuk mengambil semua data untuk program tertentu
        $allData = $this->modelName::where('program', $program)->where('status', 1)->get();

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
        return view('token-program-detail', [
            'programAmount' => $programAmount,
            'tokenListQuery' => $tokenListQuery,
            'allData' => $allData,
            'program' => $program,
            'subdomain' => $subdomain,
            'logoPath' => $logoPath
        ]);
    }
}



