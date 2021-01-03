<?= $this->extend('blank') ?>
<?= $this->section('content') ?>
<title>Dashboard</title>
<!-- Page Heading -->
<div class="d-sm-flex align-items-start flex-column justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Kriteria</h1>
</div>

<!-- Content Row -->
<!-- <form action="#">
    <div class="input-group d-flex flex-column">
        <label for="">kriteria</label>
        <input class="form-control" type="text" name="nama" placeholder="Ex: UN">
    </div>
    <input type="submit" class="btn btn-primary" value="tambah">
</form> -->
<div class="row d-flex justify-content-center">
    <div class="card col-10">
        <div class="card-body">
            <a onclick="tambah()" class="btn btn-sm btn-primary shadow-sm mb-3">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                Tambah Data</a>
            <table class="text-center table table-bordered table-hover dataTable no-footer" id="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Kriteria</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kriteria as $k) : ?>
                    <tr>
                        <td style="width:10px" class="text-success">[K-<?= $k['id_kriteria']; ?>]</td>
                        <td><?= $k['nama_kriteria']; ?></td>
                        <td style="width:220px">
                            <button onclick="edit(<?= $k['id_kriteria']; ?>)" class="btn btn-success"><i
                                    class="fa fa-edit"></i> Edit</button>
                            <button onclick="hapus(<?= $k['id_kriteria']; ?>)" class="btn btn-danger"><i
                                    class="fa fa-trash"></i> Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="/assets/js/swal2.min.js"></script>
<script>
<?php if (session()->getFlashData('edit')) : ?>
let timerInterval
Swal.fire({
    title: 'Berhasil merubah data!',
    icon: 'success',

    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
        Swal.showLoading()

    },
    willClose: () => {
        clearInterval(timerInterval)
    }
}).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
    }
})
<?php endif ?>
<?php if (session()->getFlashData('save')) : ?>
let timerInterval
Swal.fire({
    title: 'Berhasil menambah data!',
    icon: 'success',

    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
        Swal.showLoading()

    },
    willClose: () => {
        clearInterval(timerInterval)
    }
}).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
    }
})
<?php endif ?>
<?php if (session()->getFlashData('delete')) : ?>
let timerInterval
Swal.fire({
    title: 'Berhasil menghapus data!',
    icon: 'success',

    timer: 2000,
    timerProgressBar: true,
    didOpen: () => {
        Swal.showLoading()

    },
    willClose: () => {
        clearInterval(timerInterval)
    }
}).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
    }
})
<?php endif ?>
window.onload = function() {
    $('#table').DataTable();

}

function tambah() {
    Swal.fire({
        title: 'Tambah data',
        html: `
            <form action="<?= route_to('add_kriteria'); ?>" method="post">
            <div class="input-group d-flex justify-content-start">
            <label for="" class="col-12 text-left">kriteria</label>
            <input class="form-control col-12" type="text" name="nama" placeholder="Ex: UN">
            </div>
            <div class="col-12 d-flex justify-content-end mt-2 px-0">
            <input type="submit" class="btn btn-primary" value="tambah">
            </div>
            </form>
            `,
        showConfirmButton: false
    });
}

function edit(id) {
    fetch(`/ahp/kriteria/cari/${id}`)
        .then(res => res.json())
        .then(res => {
            console.log(res);
            Swal.fire({
                title: 'Edit data',
                html: `
            <form action="/ahp/kriteria/edit/${id}" method="post">
            <div class="input-group d-flex justify-content-start">
            <label for="" class="col-12 text-left">kriteria</label>
            <input value="${res.nama_kriteria}" class="form-control col-12" type="text" name="nama" placeholder="Ex: UN">
            </div>
            <div class="col-12 d-flex justify-content-end mt-2 px-0">
            <input type="submit" class="btn btn-primary" value="edit">
            </div>
            </form>
            `,
                showConfirmButton: false
            });
        })
}

function hapus(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dipilih akan dihapus",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
    }).then((result) => {
        console.log(result);
        if (result.isConfirmed)
            window.location.href = "/ahp/kriteria/hapus/" + id;
    })
}
</script>
<?= $this->endSection() ?>