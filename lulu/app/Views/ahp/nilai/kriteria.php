<?= $this->extend('blank') ?>
<?= $this->section('content') ?>
<style>
#alert {
    transition: 0.5s;
}
</style>
<title>Dashboard</title>
<!-- Page Heading -->
<div class="d-sm-flex align-items-start flex-column justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nilai Kriteria</h1>
</div>

<!-- Content Row -->
<div class="row d-flex justify-content-center flex-wrap">
    <div class="col-10 d-flex p-0">
        <div class="alert-success alert w-auto" style="opacity: 0; height:0;" id="alert">
            <i class="fa fa-check-circle"></i>
            tersimpan
        </div>
    </div>
    <div class="card col-10 py-2">
        <div class="card-body">
            <?php foreach ($nk as $n) : ?>

            <div class="col-12 d-flex m-2 justify-content-center">
                <?php foreach ($kriteria as $k) : ?>
                <?php if ($k['id_kriteria'] == $n['id_kriteria1']) : ?>

                <b class="col-3 text-right"><?= $k['nama_kriteria']; ?></b>
                <?php endif ?>
                <?php endforeach ?>
                <select class="form-control col-lg-4 col-sm-6 py-2" oninput="update(<?= $n['id_nilai']; ?>,this)">
                    <option value="1" <?= $n['nilai'] == 1 ? "selected" : ""; ?>>1 - sama penting dari</option>
                    <option value="2" <?= $n['nilai'] == 2 ? "selected" : ""; ?>>2 - mendekati sedikit lebih penting
                        dari
                    </option>
                    <option value="3" <?= $n['nilai'] == 3 ? "selected" : ""; ?>>3 - sedikit lebih penting dari</option>
                    <option value="4" <?= $n['nilai'] == 4 ? "selected" : ""; ?>>4 - emdekati lebih penting dari
                    </option>
                    <option value="5" <?= $n['nilai'] == 5 ? "selected" : ""; ?>>5 - lebih penting dari</option>
                    <option value="6" <?= $n['nilai'] == 6 ? "selected" : ""; ?>>6 - emdekati lebih mutlak penting dari
                    </option>
                    <option value="7" <?= $n['nilai'] == 7 ? "selected" : ""; ?>>7 - lebih mutlak dari</option>
                    <option value="8" <?= $n['nilai'] == 8 ? "selected" : ""; ?>>8 - mendekati mutlak penting dari
                    </option>
                    <option value="9" <?= $n['nilai'] == 9 ? "selected" : ""; ?>>9 - mutlak penting dari</option>
                    <option value="0.5" <?= $n['nilai'] == 0.5 ? "selected" : ""; ?>>1/2 - mendekati sedikit lebih tidak
                        penting dari</option>
                    <option value="0.3" <?= $n['nilai'] == 0.3 ? "selected" : ""; ?>>1/3 - sedikit lebih tidak penting
                        dari</option>
                    <option value="0.25" <?= $n['nilai'] == 0.25 ? "selected" : ""; ?>>1/4 - mendekati lebih tidak
                        penting dari
                    </option>
                    <option value="0.2" <?= $n['nilai'] == 0.2 ? "selected" : ""; ?>>1/5 - lebih tidak penting dari
                    </option>
                    <option value="0.166667" <?= $n['nilai'] == 0.166667 ? "selected" : ""; ?>>1/6 - mendekati lebih
                        mutlak tidak dari
                    </option>
                    <option value="0.142857" <?= $n['nilai'] == 0.142857 ? "selected" : ""; ?>>1/7 - lebih mutlak tidak
                        dari</option>
                    <option value="0.125" <?= $n['nilai'] == 0.125 ? "selected" : ""; ?>>1/8 - mendekati mutlak tidak
                        penting dari
                    </option>
                    <option value="0.11" <?= $n['nilai'] == 0.11 ? "selected" : ""; ?>>1/9 - mutlak tidak penting dari
                    </option>
                </select>
                <?php foreach ($kriteria as $k) : ?>

                <?php if ($k['id_kriteria'] == $n['id_kriteria2']) : ?>

                <b class="col-3"><?= $k['nama_kriteria']; ?></b>
                <?php endif ?>
                <?php endforeach ?>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
<script src="/assets/js/swal2.min.js"></script>
<script>
function update(id, context) {
    console.log(id);
    console.log(context.value);
    fetch(`/ahp/kriteria/update/${id}/${context.value}`)
        .then(res => res.json())
        .then(res => {
            console.log(res);
            alert = document.getElementById("alert");
            alert.style.opacity = 1;
            alert.style.height = 'initial';
            setTimeout(() => {
                alert.style.opacity = 0;
                alert.style.height = 0;
            }, 2000);
        })
}
</script>
<?= $this->endSection() ?>