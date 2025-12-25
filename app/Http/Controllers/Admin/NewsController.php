<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index()
    {
        // Eager Loading untuk menghindari N+1 query problem
        $news = News::with('author')
            ->latest()
            ->paginate(10);

        return view('admin.news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new news.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', // Max 2MB
        ], [
            'title.required' => 'Judul berita wajib diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'body.required' => 'Isi berita wajib diisi',
            'body.min' => 'Isi berita minimal 10 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Tambahkan author_id dari user yang sedang login
        $validated['author_id'] = Auth::id();

        // Handle upload gambar dengan resize
        if ($request->hasFile('image')) {
            $validated['image'] = $this->resizeAndSaveImage($request->file('image'));
        }

        // Simpan ke database
        News::create($validated);

        // Redirect dengan pesan sukses
        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified news.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    /**
     * Update the specified news in storage.
     */
    public function update(Request $request, News $news)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'title.required' => 'Judul berita wajib diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'body.required' => 'Isi berita wajib diisi',
            'body.min' => 'Isi berita minimal 10 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle upload gambar baru dengan resize
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }

            // Upload dan resize gambar baru
            $validated['image'] = $this->resizeAndSaveImage($request->file('image'));
        }

        // Update data
        $news->update($validated);

        // Redirect dengan pesan sukses
        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    /**
     * Remove the specified news from storage.
     */
    public function destroy(News $news)
    {
        // Hapus gambar jika ada
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }

        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Resize and save uploaded image using native PHP GD
     * Auto-resize to max width 500px while maintaining aspect ratio
     */
    private function resizeAndSaveImage($file)
    {
        // Generate unique filename
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $imagePath = public_path('images/news/' . $imageName);
        
        // Get original image info
        $imageInfo = getimagesize($file->getRealPath());
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // If width <= 500px, just save original
        if ($originalWidth <= 500) {
            $file->move(public_path('images/news'), $imageName);
            return 'images/news/' . $imageName;
        }
        
        // Calculate new dimensions
        $newWidth = 500;
        $newHeight = (int)(($originalHeight / $originalWidth) * $newWidth);
        
        // Create image resource from file based on type
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $sourceImage = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($file->getRealPath());
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($file->getRealPath());
                break;
            default:
                // Unsupported format, save original
                $file->move(public_path('images/news'), $imageName);
                return 'images/news/' . $imageName;
        }
        
        // Create new image with resized dimensions
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG
        if ($mimeType === 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
        }
        
        // Resize image
        imagecopyresampled(
            $resizedImage,
            $sourceImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $originalWidth,
            $originalHeight
        );
        
        // Save resized image based on type
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($resizedImage, $imagePath, 85);
                break;
            case 'image/png':
                imagepng($resizedImage, $imagePath, 8);
                break;
            case 'image/webp':
                imagewebp($resizedImage, $imagePath, 85);
                break;
        }
        
        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
        
        return 'images/news/' . $imageName;
    }
}
