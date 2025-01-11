<h1>Daftar Produk</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>

<table class="table">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produks as $produk)
        <tr>
            <td>{{ $produk->nama_produk }}</td>
            <td>{{ $produk->harga }}</td>
            <td>{{ $produk->kategori->nama_kategori }}</td>
            <td>{{ $produk->status->nama_status }}</td>
            <td>
                <a href="{{ route('produk.edit', $produk) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('produk.destroy', $produk) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>