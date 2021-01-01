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
    <h1 class="h3 mb-0 text-gray-800">Nilai Alternatif</h1>
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
        <div class="card-body d-flex flex-column">
            <div class="col">
                <select oninput="getNilai(this)" class="form-control col w-auto" id="kriteria">
                    <option value="0">--memuat data--</option>
                </select>
            </div>
            <div class="row mt-2" id="nilai">

            </div>
        </div>
    </div>
</div>
<script src="/assets/js/swal2.min.js"></script>
<script>
const kriteria = <?= json_encode($kriteria); ?>;
window.onload = function() {
    console.log(kriteria)
    const input = document.getElementById("kriteria");
    input.innerHTML = "<option value='0'>--pilih kriteria</option>";
    for (k of kriteria) {
        let opt = document.createElement("option");
        opt.value = k.id_kriteria;
        opt.innerText = k.nama_kriteria;
        input.appendChild(opt);
    }
}

function getNilai(context) {
    const nilai = document.getElementById("nilai");
    nilai.innerHTML = "";
    if (context.value > 0) {

        fetch('/ahp/get_nilai/' + context.value)
            .then(res => res.json())
            .then(res => {
                console.log(res)
                for (dat of res.nilai) {
                    const wrapper = document.createElement("div");
                    wrapper.setAttribute("class", 'col-12 my-2 d-flex justify-content-center');
                    const af1 = document.createElement("b");
                    const af2 = document.createElement("b");
                    for (alt of res.alter) {
                        if (alt.id_alternatif == dat.alternatif1)
                            af1.innerText = alt.nama_alternatif;
                        else if (alt.id_alternatif == dat.alternatif2)
                            af2.innerText = alt.nama_alternatif;
                    }
                    let arr = [
                        1, 2, 3, 4, 5, 6, 7, 8, 9,
                        0.11, 0.125, 0.142857, 0.166667, 0.2, 0.25, 0.3, 0.5
                    ];
                    const input = document.createElement("select");
                    for (ar of arr) {
                        opt = document.createElement("option");
                        opt.value = ar;
                        opt.innerText = ar;
                        if (ar == dat.nilai)
                            opt.setAttribute("selected", "selected");
                        input.appendChild(opt)
                    }
                    input.setAttribute("class", "form-control col-4");
                    input.setAttribute("oninput", "update(" + dat.id_nilai + ",this)");

                    af1.setAttribute("class", "col-4 text-right");
                    af2.setAttribute("class", "col-4");

                    wrapper.appendChild(af1);
                    wrapper.appendChild(input);
                    wrapper.appendChild(af2);
                    nilai.appendChild(wrapper);
                }
            })
    }
}

function update(id, context) {
    console.log(id);
    console.log(context.value);
    fetch(`/ahp/alternatif/update/${id}/${context.value}`)
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