<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::published()
            ->with('penulis')
            ->latest('published_at')
            ->paginate(10);
            
        return view('alumni.pengumuman.index', compact('pengumuman'));
    }

    public function show(Pengumuman $pengumuman)
    {
        if (!$pengumuman->is_published) {
            abort(404);
        }
        
        return view('alumni.pengumuman.show', compact('pengumuman'));
    }
}
