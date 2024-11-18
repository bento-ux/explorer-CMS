<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
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

    // Fungsi untuk menampilkan ringkasan token dan program
    public function index($subdomain)
    {

        $imageFolder = public_path('image'); 

        $files = glob($imageFolder . "/{$subdomain}.*");
    
        $logoPath = trim($files ? asset('image/' . basename($files[0])) : asset('image/default.webp'));

        $this->setModel($subdomain);

        // Query untuk mengambil ringkasan token
        $tokenUmum = $this->modelName::select('tokenName', 'tokenUmumSymbol')
               ->selectRaw('SUM(amount) as totalAmount')
            ->groupBy('tokenName', 'tokenUmumSymbol')
            ->get(); // Mengambil satu hasil pertama

        // Query untuk mengambil jumlah program spesifik ketika status = 1
        $tokenProgram = $this->modelName::select('program')
        ->selectRaw('SUM(amount) as totalAmount')
        ->where('status',1)
            ->groupBy('program')
            ->get(); // Mengambil banyak hasil

        // Mengirimkan data ke view
        return view('home', [
            'tokenUmum' => $tokenUmum,
            'tokenProgram' => $tokenProgram,
            'subdomain' => $subdomain,
            'logoPath' => $logoPath
        ]);
    }
}
