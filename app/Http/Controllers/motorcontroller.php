<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Motor;
use Illuminate\View\View;

class MotorController extends Controller
{
    public function index(): View
    {
        $motor = Motor::latest()->paginate(5);
        return view('motor.index', compact('motor'));
    }

    public function create(): View 
    {
        return view('motor.create');
    }

public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'gambar'      => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama'        => 'required|min:5',
            'deskripsi'   => 'required|min:10',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric'
        ]);

        $gambar = $request->file('gambar');
        $gambar->storeAs('public/motor', $gambar->hashName());

        Motor::create([
            'gambar'      => $gambar->hashName(),
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok
        ]);

        //redirect to index
        return redirect()->route('motor.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
public function show(string $id): View
    {
        $motor = Motor::findOrFail($id);
        return view('motor.show', compact('motor'));
    }
public function edit(string $id): View
    {
        $motor = Motor::findOrFail($id);
        return view('motor.edit', compact('motor'));
    }
public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'gambar'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'nama'      => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric'
        ]);

        $motor = Motor::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/motor', $gambar->hashName());

            // Hapus gambar lama dari storage
            Storage::delete('public/motor/' . $motor->gambar);

            $motor->update([
                'gambar'    => $gambar->hashName(),
                'nama'      => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga'     => $request->harga,
                'stok'      => $request->stok
            ]);
            //upload new image
            $gambar = $request->file('gambar');
            $gambar->storeAs('motor', $gambar->hashName());

            //update product with new image
            $motor->update([
                'gambar'         => $gambar->hashName(),
                'nama'         => $request->nama,
                'deskripsi'   => $request->deskripsi,
                'harga'         => $request->harga,
                'stok'         => $request->stok
            ]);
        } else {
            $motor->update([
                'nama'      => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga'     => $request->harga,
                'stok'      => $request->stok
            ]);
        }

        return redirect()->route('motor.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
public function destroy(string $id): RedirectResponse
    {
        $motor = Motor::findOrFail($id);

        // Hapus file gambar dari folder storage/app/public/motor
        Storage::delete('public/motor/' . $motor->gambar);

        // Hapus data dari database
        $motor->delete();

        return redirect()->route('motor.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}



    

