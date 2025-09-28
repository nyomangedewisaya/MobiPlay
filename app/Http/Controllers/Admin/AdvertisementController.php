<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $query = Advertisement::query();

        $query->when($request->search, function ($q, $search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });

        $advertisements = $query->latest()->get();

        [$activeAdvertisements, $inactiveAdvertisements] = $advertisements->partition(function ($advertisement) {
            return $advertisement->status === 'active';
        });

        return view('admin.advertisements.index', compact('activeAdvertisements', 'inactiveAdvertisements'));
    }

    public function create()
    {
        return view('admin.advertisements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|max:100|unique:advertisements,title',
                'target_url' => 'required|string|max:255|unique:advertisements,target_url',
                'banner_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=2/1',
            ],
            [
                'title.required' => 'Judul iklan tidak boleh kosong.',
                'title.unique' => 'Judul iklan ini sudah ada.',
                'target_url.required' => 'URL target tidak boleh kosong.',
                'target_url.unique' => 'URL target sudah ada.',
                'banner_url.dimensions' => 'Rasio gambar banner harus 2:1 (lebar 2x, tinggi 1x).',
            ],
        );

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']);
        $data['status'] = 'inactive';

        if ($request->hasFile('banner_url')) {
            $file = $request->file('banner_url');
            $filename = time() . '_' . $data['slug'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/advertisements'), $filename);
            $data['banner_url'] = '/images/advertisements/' . $filename;
        }

        Advertisement::create($data);
        return redirect()->route('advertisements.index')->with('success', 'Iklan baru berhasil disimpan sebagai draf.');
    }

    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate(
            [
                'title' => ['required', 'string', 'max:100', Rule::unique('advertisements')->ignore($advertisement->id)],
                'target_url' => ['required', 'string', 'max:255', Rule::unique('advertisements')->ignore($advertisement->id)],
                'banner_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=2/1',
            ],
            [
                'title.required' => 'Judul iklan tidak boleh kosong.',
                'title.unique' => 'Judul iklan ini sudah ada.',
                'target_url.required' => 'URL target tidak boleh kosong.',
                'target_url.unique' => 'URL target sudah ada.',
                'banner_url.dimensions' => 'Rasio gambar banner harus 2:1 (lebar 2x, tinggi 1x).',
            ],
        );

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('banner_url')) {
            if ($advertisement->banner_url && File::exists(public_path($advertisement->banner_url))) {
                File::delete(public_path($advertisement->banner_url));
            }
            $file = $request->file('banner_url');
            $filename = time() . '_' . $data['slug'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/advertisements'), $filename);
            $data['banner_url'] = '/images/advertisements/' . $filename;
        }

        $advertisement->update($data);
        return redirect()->route('advertisements.index')->with('success', 'Iklan berhasil diperbarui.');
    }

    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->banner_url && File::exists(public_path($advertisement->banner_url))) {
            File::delete(public_path($advertisement->banner_url));
        }
        $advertisement->delete();
        return redirect()->route('advertisements.index')->with('success', 'Iklan berhasil dihapus.');
    }

    public function updateStatus(Advertisement $advertisement)
    {
        $newStatus = $advertisement->status === 'active' ? 'inactive' : 'active';
        $advertisement->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'Iklan berhasil di-publish.' : 'Iklan berhasil di-private.';

        return redirect()->route('advertisements.index')->with('success', $message);
    }
}
