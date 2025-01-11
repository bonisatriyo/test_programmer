<h1>Edit Produk</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('produk.update', $produk) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="nama_produk">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}">
    </div>
    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}">
    </div>
    <div class="form-group">
        <label for="kategori_id">Kategori</label>
        <select class="form-control" id="kategori_id" name="kategori_id">
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="status_id">Status</label>
        <select class="form-control" id="status_id" name="status_id">
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" {{ old('status_id', $produk->status_id) == $status->id ? 'selected' : '' }}>{{ $status->nama_status }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>