<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function lihatBarang()
    {
        $wirausaha = auth()->guard('wirausaha')->user();
        $barang = $wirausaha->barang()->with('jenisbarang')->get();
        $jenis = JenisBarang::all();

        return view('wirausaha.barangView', [
            'wirausaha' => $wirausaha,
            'barang' => $barang,
            'jenis' => $jenis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function tambahBarang(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric|max:999',
            'jenis_barang_id' => 'required|numeric',
            'fotoBarang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'detail' => 'nullable'
        ]);

        $fileNameToStore = null;

        if ($request->hasFile('fotoBarang')) {
            $file = $request->file('fotoBarang');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $originalName . '_' . time() . '_' . uniqid() . '.' . $extension;

            // Simpan menggunakan disk 'custom_public'
            $file->storeAs('ProdukJual', $fileNameToStore, 'custom_public');
        }

        Barang::create([
            'nama' => $validatedData['nama'],
            'harga' => $validatedData['harga'],
            'stock' => $validatedData['stock'],
            'wirausaha_id' => auth()->guard('wirausaha')->user()->id,
            'jenis_barang_id' => $validatedData['jenis_barang_id'],
            'foto' => 'ProdukJual/' . $fileNameToStore,
            'detail' => $validatedData['detail'] ?? null
        ]);

        return redirect()->route('wirausaha.barang')->with('success', 'New item has been added');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editBarang(Request $request)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama' => 'required|max:255',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric|max:999',
            'jenis_barang_id' => 'required|numeric',
            'fotoBarang' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'detail' => 'nullable'
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        $barang->nama = $validatedData['nama'];
        $barang->harga = $validatedData['harga'];
        $barang->stock = $validatedData['stock'];
        $barang->jenis_barang_id = $validatedData['jenis_barang_id'];
        $barang->detail = $validatedData['detail'] ?? null;

        if ($request->hasFile('fotoBarang')) {
            // Hapus file lama via disk 'custom_public'
            if ($barang->foto && Storage::disk('custom_public')->exists($barang->foto)) {
                Storage::disk('custom_public')->delete($barang->foto);
            }

            $file = $request->file('fotoBarang');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $originalName . '_' . time() . '_' . uniqid() . '.' . $extension;

            // Simpan file baru via disk 'custom_public'
            $file->storeAs('ProdukJual', $fileNameToStore, 'custom_public');
            $barang->foto = 'ProdukJual/' . $fileNameToStore;
        }

        $barang->save();

        return redirect()->route('wirausaha.barang')->with('success', 'Item has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapusBarang(Request $request)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id'
        ]);

        $barang = Barang::findOrFail($validatedData['barang_id']);

        // Hapus file via disk 'custom_public'
        if ($barang->foto && Storage::disk('custom_public')->exists($barang->foto)) {
            Storage::disk('custom_public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('wirausaha.barang')->with('success', 'Your item has been deleted');
    }
}
