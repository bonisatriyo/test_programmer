<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class ProdukController extends Controller
{
    public function fetchProduk()
    {
       $username = 'tesprogrammer120125C00';
       $password = 'bisacoding-12-01-25';
       $hashedPassword = md5($password);

        // $this->info("Zona Waktu Server: " . date_default_timezone_get());
        // $this->info("Waktu Server Saat Ini: " . date('Y-m-d H:i:s'));
        // $this->info("Username: $username");
        // $this->info("Password: $password");

   
       
        // $this->info("Request Data: " . json_encode($requestData)); 

        $response = Http::asForm()->post('https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
            'username' => $username,
            'password' => $hashedPassword
        ]);

        // $this->info("Response: " . $response); 

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data['data'] as $item) {
                $kategori = Kategori::firstOrCreate(['nama_kategori' => $item['kategori']]);
                $status = Status::firstOrCreate(['nama_status' => $item['status']]);

                Produk::updateOrCreate(
                    ['id' => $item['id_produk']], 
                    [
                        'nama_produk' => $item['nama_produk'],
                        'harga' => $item['harga'],
                        'kategori_id' => $kategori->id,
                        'status_id' => $status->id,
                    ]
                );
            }

            return "Data berhasil diambil dan disimpan.";
        } else {
            return "Gagal mengambil data dari API. " . $response->body(); 
        }
    }
    public function index()
    {
        $this->fetchProduk(); 

        $produks = Produk::whereHas('status', function ($query) {
            $query->where('nama_status', 'bisa dijual');
        })->with(['kategori', 'status'])->get();

        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $statuses = Status::all();
        return view('produk.create', compact('kategoris', 'statuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Produk::create($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        $statuses = Status::all();
        return view('produk.edit', compact('produk', 'kategoris', 'statuses'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $produk->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diubah.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}