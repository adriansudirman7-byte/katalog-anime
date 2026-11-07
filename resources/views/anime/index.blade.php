<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Anime | Adrian 2511001</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
        body{background:#0a0a0a;color:#fff;padding:20px}
        header{text-align:center}
        header h1{color:#ff4757;font-size:34px}
        header p{color:#aaa;margin-top:5px}
        .stats{text-align:center;margin:15px 0;color:#ccc}
        .stats b{color:#ff4757}
        form.filter{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin:20px 0}
        form.filter input,form.filter select{padding:11px 16px;border-radius:25px;border:1px solid #333;background:#1a1a1a;color:#fff;outline:none}
        form.filter input{width:280px}
        .btn{padding:11px 20px;border-radius:25px;border:none;font-weight:bold;cursor:pointer;background:#ff4757;color:#fff}
        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:16px;max-width:1200px;margin:auto}
        .card{background:#181818;border-radius:16px;padding:14px}
        .card img{width:100%;aspect-ratio:3/4;object-fit:cover;border-radius:12px}
        .card h3{margin:10px 0 3px}
        .card p{color:#aaa;font-size:13px}
        .badge{display:inline-block;background:#ff4757;color:#fff;font-size:11px;font-weight:bold;padding:4px 10px;border-radius:20px;margin:8px 0}
        .rating{color:#ffd32a;font-weight:bold;font-size:13px;margin-bottom:8px}
        .btn-yt{display:block;background:#ff0000;color:#fff;text-decoration:none;text-align:center;padding:9px;border-radius:10px;font-size:12px;font-weight:bold;margin-bottom:10px}
        .card-actions{display:flex;gap:8px}
        .btn-edit{background:#f5c518;color:#000;text-decoration:none;padding:8px 14px;border-radius:10px;font-size:12px;font-weight:bold}
        .btn-hapus{background:#e22134;color:#fff;text-decoration:none;padding:8px 14px;border-radius:10px;font-size:12px;font-weight:bold}
        .empty{grid-column:1/-1;text-align:center;color:#777;padding:40px}
        .tambah{background:#1e1e1e;max-width:800px;margin:20px auto;padding:20px;border-radius:16px}
        .tambah h2{color:#ff4757;margin-bottom:12px}
        .tambah input,.tambah select{width:100%;padding:11px;margin-bottom:10px;border-radius:10px;border:1px solid #333;background:#111;color:#fff}
        .row{display:flex;gap:10px}
        .row select,.row input{flex:1}
    </style>
</head>
<body>
    <header><h1>🎌 DAFTAR - ANIME FAVORIT SAYA</h1><p>Adrian • NIM 2511001</p></header>
    <p class="stats">Total: <b>{{ $total }}</b> | Menampilkan: <b>{{ $anime->count() }}</b></p>

    <form class="filter" method="GET" action="{{ route('anime.index') }}">
        <input type="text" name="cari" placeholder="🔍 Cari judul / studio..." value="{{ $cari }}">
        <select name="genre">
            @foreach (['Semua','Action','Fantasy','Romance','Comedy','Drama','Horror'] as $g)
                <option {{ $filterGenre==$g?'selected':'' }}>{{ $g }}</option>
            @endforeach
        </select>
        <button class="btn" type="submit">Cari</button>
    </form>

    <div class="grid">
        @forelse ($anime as $a)
            <div class="card">
                <img src="{{ $a['cover'] }}" alt="{{ $a['judul'] }}">
                <h3>{{ $a['judul'] }}</h3>
                <p>{{ $a['studio'] }} • {{ $a['tahun'] }} • {{ $a['episode'] }} Eps</p>
                <span class="badge">{{ $a['genre'] }}</span>
                <p class="rating">⭐ {{ $a['rating'] }} / 10</p>
                @if (!empty($a['trailer']))
                    <a href="{{ $a['trailer'] }}" target="_blank" class="btn-yt">▶️ Tonton Trailer di YouTube</a>
                @endif
                <div class="card-actions">
                    <a href="{{ route('anime.edit', $a['id']) }}" class="btn-edit">✏️ Edit</a>
                    <a href="{{ route('anime.hapus', $a['id']) }}" onclick="return confirm('Hapus anime ini?')" class="btn-hapus">🗑️ Hapus</a>
                </div>
            </div>
        @empty
            <p class="empty">😢 Anime tidak ditemukan</p>
        @endforelse
    </div>

    <div class="tambah">
        <h2>+ Tambah Anime Baru</h2>
        <form method="POST" action="{{ route('anime.store') }}">
            @csrf
            <input name="judul" placeholder="Judul Anime *" required>
            <input name="studio" placeholder="Studio *" required>
            <div class="row">
                <select name="genre"><option>Action</option><option>Fantasy</option><option>Romance</option><option>Comedy</option><option>Drama</option><option>Horror</option></select>
                <input name="tahun" placeholder="Tahun" type="number">
                <input name="episode" placeholder="Jumlah Episode" type="number">
                <input name="rating" placeholder="Rating 0-10" type="number" step="0.1">
            </div>
            <input name="cover" placeholder="Link Cover (opsional)">
            <input name="trailer" placeholder="Link Trailer YouTube (opsional)">
            <button class="btn" type="submit" style="width:100%">Simpan Anime</button>
        </form>
    </div>
</body>
</html>