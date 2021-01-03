<?= $this->extend('blank') ?>
<?= $this->section('content') ?>
<title>Dashboard</title>
<style>
td {
    align-items: start;
}

.col-12 {
    overflow-x: scroll;
    margin-top: 20px;
}
</style>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Perankingan</h1>
</div>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <!-- Kriteria -->
    <div class="card shadow mb-4 col-10 p-0">
        <!-- Card Header - Accordion -->
        <a href="#collapse1" class="d-block card-header py-3 bg-dark" data-toggle="collapse" role="button"
            aria-expanded="true" aria-controls="collapse1">
            <h6 class="m-0 font-weight-bold text-white">Matriks kriteria</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapse1">
            <div class="card-body">
                <div class="col-12">

                    <b>Tabel perbandingan berpasangan</b>
                    <table class="table table-bordered col-12">
                        <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($kriteria as $k) : ?>
                                <th><?= $k['nama_kriteria']; ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (range(0, count($kriteria) - 1) as $i) : ?>
                            <tr>
                                <td><?= $kriteria[$i]['nama_kriteria']; ?></td>
                                <?php foreach ($mapK['map'][$i] as $m) : ?>
                                <td><?= round($m, 3); ?></td>
                                <?php endforeach ?>
                            </tr>
                            <?php endforeach ?>
                            <tr>
                                <td>Total</td>
                                <?php foreach ($mapK['total'] as $t) : ?>
                                <td><?= round($t, 3); ?></td>
                                <?php endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-12">
                    <b>Tabel normalisasi</b>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($kriteria as $k) : ?>
                                <th><?= $k['nama_kriteria']; ?></th>
                                <?php endforeach ?>
                                <th>PV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (range(0, count($kriteria) - 1) as $i) : ?>
                            <tr>
                                <td><?= $kriteria[$i]['nama_kriteria']; ?></td>
                                <?php foreach ($mapK['normal'][$i] as $n) : ?>
                                <td><?= round($n, 3); ?></td>
                                <?php endforeach ?>
                                <td><?= round($mapK['pv'][$i], 3); ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <p>Pengujian Konsistensi
                    </p>
                    <table>
                        <tr>
                            <td>lmax</td>
                            <td>=
                                <?php foreach (range(0, count($kriteria) - 1) as $i) : ?>
                                (<?= round($mapK['total'][$i], 3); ?> x <?= round($mapK['pv'][$i], 3); ?>)
                                <?= $i < count($kriteria) - 1 ? "+" : ""; ?>
                                <?php endforeach ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-danger">= <?= round($mapK['max'], 3); ?></td>
                        </tr>
                        <tr class="mt-2">
                            <td>CI</td>
                            <td>= (<?= round($mapK['max'], 3) . " - " . count($kriteria); ?>) /
                                <?= count($kriteria) - 1; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-danger">= <?= round($mapK['ci'], 3); ?></td>
                        </tr>
                        <tr class="mt-2">
                            <td>CR</td>
                            <td>= <?= round($mapK['ci'], 3) . " / " . $mapK['ri']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-danger">= <?= round($mapK['cr'], 3); ?>
                                <?= round($mapK['cr'], 3) < 0.1 ? " < 0.1 KONSISTEN" : " > 0.1 TIDAK KONSISTEN"; ?></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- alter -->
    <?php foreach (range(0, count($kriteria) - 1) as $j) : ?>
    <div class="card shadow mb-4 col-10 p-0">
        <!-- Card Header - Accordion -->
        <a href="#collapse<?= $j + 2; ?>" class="d-block card-header py-3 bg-dark" data-toggle="collapse" role="button"
            aria-expanded="true" aria-controls="collapse<?= $j + 2; ?>">
            <h6 class="m-0 font-weight-bold text-white">Matriks jurusan - <?= $kriteria[$j]['nama_kriteria']; ?></h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapse<?= $j + 2; ?>">
            <div class="card-body">
                <div class="col-12">

                    <b>Tabel perbandingan berpasangan</b>
                    <table class="table table-bordered col-12">
                        <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($alter as $a) : ?>
                                <th><?= $a['nama_alternatif']; ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (range(0, count($alter) - 1) as $i) : ?>
                            <tr>
                                <td><?= $alter[$i]['nama_alternatif']; ?></td>
                                <?php foreach ($mapA[$j]['map'][$i] as $m) : ?>
                                <td><?= round($m, 3); ?></td>
                                <?php endforeach ?>
                            </tr>
                            <?php endforeach ?>
                            <tr>
                                <td>Total</td>
                                <?php foreach ($mapA[$j]['total'] as $t) : ?>
                                <td><?= round($t, 3); ?></td>
                                <?php endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-12">
                    <b>Tabel normalisasi</b>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($alter as $a) : ?>
                                <th><?= $a['nama_alternatif']; ?></th>
                                <?php endforeach ?>
                                <th>PV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (range(0, count($alter) - 1) as $i) : ?>
                            <tr>
                                <td><?= $alter[$i]['nama_alternatif']; ?></td>
                                <?php foreach ($mapA[$j]['normal'][$i] as $n) : ?>
                                <td><?= round($n, 3); ?></td>
                                <?php endforeach ?>
                                <td><?= round($mapA[$j]['pv'][$i], 3); ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <p>Pengujian Konsistensi
                    </p>
                    <table>
                        <tr>
                            <td>lmax</td>
                            <td>=
                                <?php foreach (range(0, count($alter) - 1) as $i) : ?>
                                (<?= round($mapA[$j]['total'][$i], 3); ?> x <?= round($mapA[$j]['pv'][$i], 3); ?>)
                                <?= $i < count($alter) - 1 ? "+" : ""; ?>
                                <?php endforeach ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-danger">= <?= round($mapA[$j]['max'], 3); ?></td>
                        </tr>
                        <tr class="mt-2">
                            <td>CI</td>
                            <td>= (<?= round($mapA[$j]['max'], 3) . " - " . count($alter); ?>) /
                                <?= count($alter) - 1; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-danger">= <?= round($mapA[$j]['ci'], 3); ?></td>
                        </tr>
                        <tr class="mt-2">
                            <td>CR</td>
                            <td>= <?= round($mapA[$j]['ci'], 3) . " / " . $mapA[$j]['ri']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-danger">= <?= round($mapA[$j]['cr'], 3); ?>
                                <?= round($mapA[$j]['cr'], 3) < 0.1 ? " < 0.1 KONSISTEN" : " > 0.1 TIDAK KONSISTEN"; ?>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <?php endforeach ?>
    <!-- end alter -->
    <!-- total -->
    <div class="card shadow mb-4 col-10 p-0">
        <!-- Card Header - Accordion -->
        <a href="#collapseLast" class="d-block card-header py-3 bg-dark" data-toggle="collapse" role="button"
            aria-expanded="true" aria-controls="collapseLast">
            <h6 class="m-0 font-weight-bold text-white">Total ranking</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseLast">
            <div class="card-body">
                <div class="col-12">

                    <b>Global</b>
                    <table class="table table-bordered col-12">
                        <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($kriteria as $k) : ?>
                                <th><?= $k['nama_kriteria']; ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (range(0, count($alter) - 1) as $i) : ?>
                            <tr>
                                <td><?= $alter[$i]['nama_alternatif']; ?></td>
                                <?php foreach ($ranking['raw'][$i] as $r) : ?>
                                <td><?= round($r, 3); ?></td>
                                <?php endforeach ?>
                            </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
                <?php foreach (range(0, count($alter) - 1) as $a) : ?>
                <div class="col-12">

                    <b>total ranking jurusan <?= $alter[$a]['nama_alternatif']; ?></b>
                    <table class="table table-bordered col-12">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Faktor evaluasi</th>
                                <th>Faktor Bobot</th>
                                <th>Bobot Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (range(0, count($kriteria) - 1) as $i) : ?>
                            <tr>
                                <td><?= $kriteria[$i]['nama_kriteria']; ?></td>
                                <td><?= round($ranking['raw'][$a][$i], 3); ?></td>
                                <td><?= round($vp[$i] / array_sum($vp), 3); ?></td>
                                <td><?= round($ranking['total'][$a][$i], 3); ?></td>
                            </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="2">TOTAL</td>
                                <td>1</td>
                                <td><?= round(array_sum($ranking['total'][$a]), 3); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php endforeach ?>

                <!-- ranking -->
                <div class="col-12">

                    <b>Ranking</b>
                    <table class="table table-bordered col-12">
                        <thead>
                            <tr>
                                <th>Jurusan</th>
                                <th>Total</th>
                                <th>Ranking</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (range(0, count($total) - 1) as $j) : ?>
                            <tr>
                                <td>
                                    <?php
                                        $id = $total[$j]['alternatif'];
                                        foreach ($alter as $a) {
                                            if ($a['id_alternatif'] == $total[$j]['alternatif'])
                                                echo $a['nama_alternatif'];
                                        }
                                        ?>
                                </td>
                                <td><?= round($total[$j]['total'], 3); ?></td>
                                <td><?= $j + 1; ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>