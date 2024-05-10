<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    
        <div class="row" id="postModal">
            <div class="col-md-4 offset-4 rounded bg-info mt-3 py-3">
                <h2 class="text-center fw-bold" style="font-size: 20px">Tambah Data Produk</h2>
                <form class="mt-3" id="postForm" action="{{ route('postRequest', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Gambar Produk</label>
                        <input type="text" class="form-control" id="image" name="image" placeholder="Masukkan gambar produk">
                        <span id="image_error" class="invalid-feedback"></span>
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama produk">
                        <span id="nama_error" class="invalid-feedback"></span>
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Berat</label>
                        <input type="number" class="form-control" id="berat" name="berat" placeholder="Masukkan berat produk">
                        <span id="berat_error" class="invalid-feedback"></span>
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga produk">
                        <span id="harga_error" class="invalid-feedback"></span>
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan stok produk">
                        <span id="stok_error" class="invalid-feedback"></span>
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Kondisi</label>
                        <select class="form-select form-control" aria-label="Default select example" id="kondisi" name="kondisi">
                            <option selected value="0">Pilih Kondisi Barang</option>
                            <option value="Bekas">Bekas</option>
                            <option value="Baru">Baru</option>
                        </select>
                        <span id="kondisi_error" class="invalid-feedback"></span>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" id="exampleFormControlTextarea1" rows="3"
                            placeholder="Tuliskan deskripsi produk yang akan dijual"></textarea>
                            <span id="deskripsi_error" class="invalid-feedback"></span>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-dark mx-auto" id="submitForm" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#submitForm').on('click', function(e){
        e.preventDefault();
        let image = $('#image').val();
        let berat = $('#berat').val();
        let nama = $('#nama').val();
        let harga = $('#harga').val();
        let stok = $('#stok').val();
        let kondisi = $('#kondisi').val();
        let deskripsi = $('#deskripsi').val();
        $.ajax({
            type: 'POST',
            url: '/{user}/post-request',
            data: {
                _token: '{{ csrf_token() }}',
                image: image,
                berat: berat,
                nama: nama,
                harga: harga,
                stok: stok,
                kondisi: kondisi,
                deskripsi: deskripsi


            },
            success: function(data){
              $('#postModal').modal('hide');
                $('#postForm').trigger('reset');
                window.location.reload();
            },


            error: function(xhr, status, error){
            $.each(error.responseJson.errors, function(key, val){
                $('#'+key).addClass('is-invalid');
                $('#'+key+'_error').text(value);
            }
        });
    });
});
</script>

</html>
