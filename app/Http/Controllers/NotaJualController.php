<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Customer;
use App\Models\NotaJual;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotaJualRequest;
use App\Http\Requests\UpdateNotaJualRequest;
use Illuminate\Support\Facades\Storage;

class NotaJualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customer.nota_jual.index');
    }

    public function indexAdmin()
    {
        $notaJual = auth()->guard('wirausaha')->user()->notajual()->get();
        return view('wirausaha.nota_jual.index', [
            'notaJual' => $notaJual
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotaJualRequest $request)
    {
        // Validate the data
        $validatedData = $request->validate([
            'namaBarang' => 'required|string|max:255',
            'alamatAmbil' => 'required|string|max:255',
            'hargaJual' => 'required|numeric',
            'fotoBarang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the image file upload menggunakan disk 'custom_public'
        if ($request->hasFile('fotoBarang')) {
            // Tersimpan di: /public_html/simpledelivery/uploads/foto_barang/
            $imagePath = $request->file('fotoBarang')->store('foto_barang', 'custom_public');
            $validatedData['fotoBarang'] = $imagePath;
        }

        $customerId = auth()->guard('customer')->id();

        // Create object NotaJual
        $notaJual = NotaJual::create([
            'nama' => $validatedData['namaBarang'],
            'harga' => $validatedData['hargaJual'],
            'foto' => $validatedData['fotoBarang'],
            'alamat' => $validatedData['alamatAmbil'],
            'customer_id' => $customerId,
        ]);

        // Ambil nama customer yang sedang login
        $customer = auth()->guard('customer')->user();
        $namaCustomer = $customer ? $customer->name : null;

        // Buat data Tugas menggunakan ID langsung dari objek $notaJual
        Tugas::create([
            'jenis_tugas' => 'Penjemputan',
            'nota_jual_id' => $notaJual->id,
            'nama_penerima' => $namaCustomer,
            'status' => 'belum_diambil'
        ]);

        return to_route('customer.index')->with('success', 'Berhasil menjual barang!');
    }

    public function konfirmasiHarga(UpdateNotaJualRequest $request)
    {
        NotaJual::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        if ($request->status == 1) {
            return to_route('wirausaha.offer')->with('success', 'Berhasil approve barang!');
        } else {
            return to_route('wirausaha.offer')->with('success', 'Berhasil reject barang!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NotaJual $notaJual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotaJual $notaJual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotaJualRequest $request, NotaJual $notaJual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotaJual $notaJual)
    {
        // Hapus file foto dari uploads jika data dihapus
        if ($notaJual->foto && Storage::disk('custom_public')->exists($notaJual->foto)) {
            Storage::disk('custom_public')->delete($notaJual->foto);
        }

        $notaJual->delete();

        return back()->with('success', 'Nota jual berhasil dihapus!');
    }
}
