<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anime - {{ $a['judul'] }}</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
        body{background:#0a0a0a;color:#fff;padding:20px;display:flex;justify-content:center}
        .box{background:#181818;max-width:600px;width:100%;padding:25px;border-radius:16px;margin-top:30px}
        .box h1{color:#ff4757;font-size:24px;text-align:center}
        .box p{text-align:center;color:#aaa;font-size:13px;margin:8px 0 20px}
        .box img{width:120px;height:160px;object-fit:cover;border-radius:10px;display:block;margin:0 auto 15px}
        label{font-size:13px;color:#aaa;display:block;margin:12px 0 5px}
        input, select{width:100%;padding:12px;border-radius:10px;border:1px solid #333;background:#111;color:#fff;outline:none}
        input:focus, select:focus{border-color:#ff4757}
        .row{display:flex;gap:10px}
        .row div{flex:1}
        .btn-save{width:100%;padding:13px;border:none;border-radius:10px;background:#ff4757;color:#fff;font-weight:bold;cursor:pointer;margin-top:20px;font-size:15px}
        .btn-back{display:block;text-align:center;margin-top:12px;color:#aaa;text-decoration:none;font-size:13px}
        .btn-back:hover{color:#fff}
    </style>
</head>
<body>
    <div class="box">
        <h1>✏️ Edit Anime</h1>
        <p>Adrian • NIM 2511001</p>

        <img src="{{ $a['cover'] }}" alt="{{ $a['judul'] }}">

        <form method="POST" action="{{ route('anime.update', $a['id']) }}">
            @csrf

            <label>Judul Anime *</label>
            <input name="judul" value="{{ $a['judul'] }}" required>

            <label>Studio *</label>
            <input name="studio" value="{{ $a['studio'] }}" required>

            <label>Genre</label>
            <select name="genre">
                @foreach (['Action','Fantasy','Romance','Comedy','Drama','Horror'] as $g)
                    <option value="{{ $g }}" {{ $a['genre'] == $g ? 'selected' : '' }}>{{ $g }}</option>
                @endforeach
            </select>

            <div class="row">
                <div>
                    <label>Tahun Rilis</label>
                    <input name="tahun" type="number" value="{{ $a['tahun'] }}">
                </div>
                <div>
                    <label>Jumlah Episode</label>
                    <input name="episode" type="number" value="{{ $a['episode'] }}">
                </div>
                <div>
                    <label>Rating (0-10)</label>
                    <input name="rating" type="number" step="0.1" value="{{ $a['rating'] }}">
                </div>
            </div>

            <label>Link Cover</label>
            <input name="cover" value="{{ $a['cover'] }}" placeholder="https://...">

            <label>Link Trailer YouTube</label>
            <input name="trailer" value="{{ $a['trailer'] ?? '' }}" placeholder="https://youtube.com/...">

            <button class="btn-save" type="submit">💾 Simpan Perubahan</button>
            <a href="{{ route('anime.index') }}" class="btn-back">← Batal, Kembali ke Katalog</a>
        </form>
    </div>
</body>
</html>