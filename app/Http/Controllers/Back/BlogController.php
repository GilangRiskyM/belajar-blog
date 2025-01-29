<?php

namespace App\Http\Controllers\Back;

use DOMDocument;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class BlogController extends Controller
{
    private function generateSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = Blog::where('slug', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->count();

        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        return $slug;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $cari = $request->cari;

        if ($user->can('admin-blog')) {
            $data = Blog::where(function ($query) use ($cari) {
                if ($cari) {
                    $query->where('title', 'like', '%' . $cari . '%')
                        ->where('content', 'like', '%' . $cari . '%');
                }
            })->orderBy('id', 'desc')
                ->paginate(5)
                ->withQueryString();
        } else {
            $data = Blog::where('user_id', $user->id)
                ->where(function ($query) use ($cari) {
                    if ($cari) {
                        $query->where('title', 'like', '%' . $cari . '%')
                            ->where('content', 'like', '%' . $cari . '%');
                    }
                })->orderBy('id', 'desc')
                ->paginate(5)
                ->withQueryString();
        }


        return view('back.blog.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'content' => 'required'
        ], [
            'title.required' => 'Judul wajib diisi!',
            'description.required' => 'Deskripsi wajib diisi!',
            'content.required' => 'Konten wajib diisi!',
            'thumbnail.required' => 'Thumbnail wajib diisi!',
            'thumbnail.image' => 'Thumbnail harus berupa gambar!',
            'thumbnail.mimes' => 'Thumbnail harus berupa gambar dengan format .jpg, .jpeg, atau .png!',
            'thumbnail.max' => 'Thumbnail tidak boleh lebih dari :max MB!',
        ]);

        if ($request->hasFile('thumbnail')) {
            $gambar  = $request->file('thumbnail');
            $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
            $lokasi = public_path('thumbnail');
            $gambar->move($lokasi, $nama_gambar);
        }

        $content = $request->content;

        $dom = new DOMDocument();
        $dom->loadHTML($content, 9);
        $contentGambar = $dom->getElementsByTagName('img');

        foreach ($contentGambar as $key => $value) {
            $data = base64_decode(explode(',', explode(';', $value->getAttribute('src'))[1])[1]);
            $contentNamaGambar = "/upload/" . time() . $key . '.png';
            file_put_contents(public_path($contentNamaGambar), $data);

            $value->removeAttribute('src');
            $value->setAttribute('src', $contentNamaGambar);
        }

        $content = $dom->saveHTML();

        $data = [
            'title' => $request->title,
            'slug' => $this->generateSlug($request->title),
            'description' => $request->description,
            'thumbnail' => $nama_gambar,
            'content' => $content,
            'status' => $request->status,
            'user_id' => Auth::user()->id
        ];

        Blog::create($data);
        sweetalert()->success('Data berhasil disimpan!');
        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        Gate::authorize('edit', $blog);
        $data = Blog::findOrFail($blog->id);

        return view('back.blog.edit', [
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpg,jpeg,png|max:10240',
            'content' => 'required'
        ], [
            'title.required' => 'Judul wajib diisi!',
            'description.required' => 'Deskripsi wajib diisi!',
            'content.required' => 'Konten wajib diisi!',
            'thumbnail.image' => 'Thumbnail harus berupa gambar!',
            'thumbnail.mimes' => 'Thumbnail harus berupa gambar dengan format .jpg, .jpeg, atau .png!',
            'thumbnail.max' => 'Thumbnail tidak boleh lebih dari :max MB!',
        ]);

        if ($request->hasFile('thumbnail')) {
            if (isset($blog->thumnail) && file_exists(public_path('thumbnail/') . $blog->thumbnail)) {
                unlink(public_path('thumbnail/') . $blog->thumbnail);
            }
            $gambar  = $request->file('thumbnail');
            $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
            $lokasi = public_path('thumbnail');
            $gambar->move($lokasi, $nama_gambar);
        }

        $content = $request->content;

        $dom = new DOMDocument();
        $dom->loadHTML($content, 9);
        $contentGambar = $dom->getElementsByTagName('img');

        foreach ($contentGambar as $key => $value) {
            if (strpos($value->getAttribute('src'), 'data:image') === 0) {
                $data = base64_decode(explode(',', explode(';', $value->getAttribute('src'))[1])[1]);
                $contentNamaGambar = "/upload/" . time() . $key . '.png';
                file_put_contents(public_path() . $contentNamaGambar, $data);

                $value->removeAttribute('src');
                $value->setAttribute('src', $contentNamaGambar);
            }
        }

        $content = $dom->saveHTML();

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $content,
            'status' => $request->status,
            'thumbnail' => isset($nama_gambar) ? $nama_gambar : $blog->thumbnail,
            'slug' => $this->generateSlug($request->title, $blog->id),
        ];

        Blog::findOrFail($blog->id)->update($data);
        sweetalert()->success('Data berhasil diupdate');
        return redirect()->route('blog.index');
    }

    function delete(Blog $blog)
    {
        Gate::authorize('delete', $blog);
        $data = Blog::findOrFail($blog->id);
        return view('back.blog.delete', [
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $data = Blog::findOrFail($blog->id);

        $dom = new DOMDocument();
        $dom->loadHTML($data->content, 9);
        $gambar = $dom->getElementsByTagName('img');
        $links = $dom->getElementsByTagName('a');

        foreach ($gambar as $key => $img) {
            $src = $img->getAttribute('src');
            $path = Str::of($src)->after('/');

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        foreach ($links as $key => $link) {
            $href = $link->getAttribute('href');
            $path = Str::of($href)->after('/');

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        if (isset($data->thumbnail) && file_exists(public_path('thumbnail/' . $data->thumbnail))) {
            unlink(public_path('thumbnail/') . $data->thumbnail);
        }

        $data->delete();
        sweetalert()->success('Data berhasil dihapus');
        return redirect()->route('blog.index');
    }
}
