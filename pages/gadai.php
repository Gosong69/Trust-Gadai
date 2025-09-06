<form action="submit_gadai.php" method="post" enctype="multipart/form-data">
    Nama Barang: <input type="text" name="nama_barang"><br>
    Deskripsi: <textarea name="deskripsi"></textarea><br>
    Kategori:
    <select name="kategori">
        <option value="elektronik">Elektronik</option>
        <option value="kendaraan">Kendaraan</option>
        <option value="emas">Emas</option>
    </select><br>
    Harga: <input type="number" name="harga"><br>
    Lokasi (Alamat/GPS): <input type="text" name="lokasi"><br>
    Upload Foto (5 Foto): <br>
    <input type="file" name="foto1"><br>
    <input type="file" name="foto2"><br>
    <input type="file" name="foto3"><br>
    <input type="file" name="foto4"><br>
    <input type="file" name="foto5"><br>
    <button type="submit">Submit</button>
</form>
