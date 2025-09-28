<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        $query->when($request->search, function ($q, $search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });

        $articles = $query->latest()->get();

        [$activeArticles, $inactiveArticles] = $articles->partition(function ($article) {
            return $article->status === 'active';
        });

        return view('admin.articles.index', compact('activeArticles', 'inactiveArticles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|max:100|unique:articles,title',
                'content' => 'required|string',
                'banner_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=2/1',
            ],
            [
                'title.required' => 'Judul artikel tidak boleh kosong.',
                'title.unique' => 'Judul artikel ini sudah ada.',
                'content.required' => 'Konten tidak boleh kosong.',
                'banner_url.dimensions' => 'Rasio gambar banner harus 2:1 (lebar 2x, tinggi 1x).',
            ],
        );

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']);
        $data['status'] = 'inactive';

        if ($request->hasFile('banner_url')) {
            $file = $request->file('banner_url');
            $filename = time() . '_' . $data['slug'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/articles'), $filename);
            $data['banner_url'] = '/images/articles/' . $filename;
        }

        Article::create($data);
        return redirect()->route('articles.index')->with('success', 'Artikel baru berhasil disimpan sebagai draf.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate(
            [
                'title' => ['required', 'string', 'max:100', Rule::unique('articles')->ignore($article->id)],
                'content' => 'required|string',
                'banner_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=2/1',
            ],
            [
                'title.required' => 'Judul artikel tidak boleh kosong.',
                'title.unique' => 'Judul artikel ini sudah ada.',
                'content.required' => 'Konten tidak boleh kosong.',
                'banner_url.dimensions' => 'Rasio gambar banner harus 2:1 (lebar 2x, tinggi 1x).',
            ],
        );

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('banner_url')) {
            if ($article->banner_url && File::exists(public_path($article->banner_url))) {
                File::delete(public_path($article->banner_url));
            }
            $file = $request->file('banner_url');
            $filename = time() . '_' . $data['slug'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/articles'), $filename);
            $data['banner_url'] = '/images/articles/' . $filename;
        }

        $article->update($data);
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->banner_url && File::exists(public_path($article->banner_url))) {
            File::delete(public_path($article->banner_url));
        }
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function updateStatus(Article $article)
    {
        $newStatus = $article->status === 'active' ? 'inactive' : 'active';
        $article->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'Artikel berhasil di-publish.' : 'Artikel berhasil di-private.';

        return redirect()->route('articles.index')->with('success', $message);
    }
}
