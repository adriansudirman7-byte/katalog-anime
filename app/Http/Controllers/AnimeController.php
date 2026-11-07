<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('anime')) {
            session(['anime' => [
                ['id'=>1, 'judul'=>'One Piece', 'studio'=>'Toei Animation', 'genre'=>'Action', 'tahun'=>1999, 'episode'=>1100, 'rating'=>9.1, 'cover'=>'https://cdn.myanimelist.net/images/anime/6/73245.jpg', 'trailer'=>'https://www.youtube.com/watch?v=S8_YwFLCh4U'],
                ['id'=>2, 'judul'=>'Naruto Shippuden', 'studio'=>'Pierrot', 'genre'=>'Action', 'tahun'=>2007, 'episode'=>500, 'rating'=>8.7, 'cover'=>'https://cdn.myanimelist.net/images/anime/5/17407.jpg', 'trailer'=>'https://www.youtube.com/watch?v=22R0j8UKRzY'],
                ['id'=>3, 'judul'=>'Jujutsu Kaisen', 'studio'=>'MAPPA', 'genre'=>'Action', 'tahun'=>2020, 'episode'=>47, 'rating'=>8.8, 'cover'=>'https://cdn.myanimelist.net/images/anime/1171/109222.jpg', 'trailer'=>'https://www.youtube.com/watch?v=pkKu9hLT-t8'],
                ['id'=>4, 'judul'=>'Frieren: Beyond Journey\'s End', 'studio'=>'Madhouse', 'genre'=>'Fantasy', 'tahun'=>2023, 'episode'=>28, 'rating'=>9.3, 'cover'=>'https://cdn.myanimelist.net/images/anime/1015/138006.jpg', 'trailer'=>'https://www.youtube.com/watch?v=R8Q7m0s2Q3o'],
                ['id'=>5, 'judul'=>'Demon Slayer', 'studio'=>'ufotable', 'genre'=>'Action', 'tahun'=>2019, 'episode'=>55, 'rating'=>8.7, 'cover'=>'https://cdn.myanimelist.net/images/anime/1286/99889.jpg', 'trailer'=>'https://www.youtube.com/watch?v=VQGCKyvzIM4'],
                ['id'=>6, 'judul'=>'Attack on Titan', 'studio'=>'Wit Studio', 'genre'=>'Action', 'tahun'=>2013, 'episode'=>89, 'rating'=>9.0, 'cover'=>'https://cdn.myanimelist.net/images/anime/10/47347.jpg', 'trailer'=>'https://www.youtube.com/watch?v=MGRm4IzK1SQ'],
            ]]);
        }

        $anime = collect(session('anime'));

        if ($request->cari) {
            $anime = $anime->filter(fn($a) => str_contains(strtolower($a['judul']), strtolower($request->cari)) || str_contains(strtolower($a['studio']), strtolower($request->cari)));
        }

        if ($request->genre && $request->genre != 'Semua') {
            $anime = $anime->where('genre', $request->genre);
        }

        return view('anime.index', [
            'anime' => $anime,
            'total' => count(session('anime')),
            'cari' => $request->cari,
            'filterGenre' => $request->genre ?? 'Semua'
        ]);
    }

    public function store(Request $request)
    {
        $anime = session('anime');
        $anime[] = [
            'id' => time(),
            'judul' => $request->judul,
            'studio' => $request->studio,
            'genre' => $request->genre,
            'tahun' => $request->tahun,
            'episode' => $request->episode,
            'rating' => $request->rating,
            'cover' => $request->cover ?: 'https://picsum.photos/300?random='.time(),
            'trailer' => $request->trailer ?: 'https://www.youtube.com/results?search_query='.urlencode($request->judul.' trailer'),
        ];
        session(['anime' => $anime]);
        return redirect()->route('anime.index');
    }

    public function destroy($id)
    {
        $anime = collect(session('anime'))->reject(fn($a) => $a['id'] == $id)->values()->all();
        session(['anime' => $anime]);
        return redirect()->route('anime.index');
    }

    public function edit($id)
    {
        $anime = collect(session('anime'))->firstWhere('id', $id);
        if (!$anime) return redirect()->route('anime.index');
        return view('anime.edit', ['a' => $anime]);
    }

    public function update(Request $request, $id)
    {
        $anime = collect(session('anime'))->map(function($a) use ($request, $id) {
            if ($a['id'] == $id) {
                $a['judul'] = $request->judul;
                $a['studio'] = $request->studio;
                $a['genre'] = $request->genre;
                $a['tahun'] = $request->tahun;
                $a['episode'] = $request->episode;
                $a['rating'] = $request->rating;
                $a['cover'] = $request->cover ?: $a['cover'];
                $a['trailer'] = $request->trailer ?: ($a['trailer'] ?? '');
            }
            return $a;
        })->values()->all();
        session(['anime' => $anime]);
        return redirect()->route('anime.index');
    }
}