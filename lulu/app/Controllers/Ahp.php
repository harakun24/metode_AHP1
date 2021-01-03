<?php

namespace App\Controllers;

class Ahp extends BaseController
{
    function __construct()
    {
        $this->admin = new Admin();
        $this->kriteria = new \App\Models\kriteriaModel();
        $this->alter = new \App\Models\alternatifModel();
        $this->nk = new \App\Models\nilaiKModel();
        $this->na = new \App\Models\nilaiAModel();
        $this->rnk = new \App\Models\rankingModel();
    }
    public function index()
    {
        if ($this->admin->isLogged()) {
            $data = [
                'kriteria' => count($this->kriteria->findAll()),
                'alter' => count($this->alter->findAll()),
            ];
            return view("ahp/home", $data);
        } else {
            return redirect()->to("/");
        }
    }
    public function kriteria()
    {
        if ($this->admin->isLogged()) {
            $data['kriteria'] = $this->kriteria->findAll();
            // dd($data);
            return view("ahp/kriteria", $data);
        } else {
            return redirect()->to("/");
        }
    }
    public function add_kriteria()
    {
        $this->kriteria->save([
            'nama_kriteria' => $this->request->getVar('nama')
        ]);
        session()->setFlashData('save', true);
        return redirect()->to("/ahp/kriteria");
    }
    public function get_kriteria($id)
    {
        return json_encode($this->kriteria->find($id));
    }
    public function edit_kriteria($id)
    {
        $this->kriteria->save([
            'id_kriteria' => $id,
            'nama_kriteria' => $this->request->getVar('nama')
        ]);
        session()->setFlashData('edit', true);
        return redirect()->to("/ahp/kriteria");
    }
    public function del_kriteria($id)
    {
        $this->kriteria->delete($id);
        session()->setFlashData('delete', true);
        return redirect()->to("/ahp/kriteria");
    }
    // alternatif
    public function alternatif()
    {
        if ($this->admin->isLogged()) {
            $data['alternatif'] = $this->alter->findAll();
            // dd($data);
            return view("ahp/alternatif", $data);
        } else {
            return redirect()->to("/");
        }
    }
    public function add_alternatif()
    {
        // dd($this->request->getVar('nama'));
        $this->alter->save([
            'nama_alternatif' => $this->request->getVar('nama')
        ]);
        session()->setFlashData('save', true);
        return redirect()->to("/ahp/alternatif");
    }
    public function get_alternatif($id)
    {
        return json_encode($this->alter->find($id));
    }
    public function edit_alternatif($id)
    {
        $this->alter->save([
            'id_alternatif' => $id,
            'nama_alternatif' => $this->request->getVar('nama')
        ]);
        session()->setFlashData('edit', true);
        return redirect()->to("/ahp/alternatif");
    }
    public function del_alternatif($id)
    {
        $this->alter->delete($id);
        session()->setFlashData('delete', true);
        return redirect()->to("/ahp/alternatif");
    }
    // nilai kriteria
    public function cek_kriteria()
    {
        $kriteria = $this->kriteria->findAll();
        foreach (range(0, count($kriteria) - 1) as $i) {
            foreach (range($i, count($kriteria) - 1) as $j) {
                $tmp = [
                    'id_kriteria1' => $kriteria[$i]['id_kriteria'],
                    'id_kriteria2' => $kriteria[$j]['id_kriteria']
                ];
                if (
                    $this->nk->where($tmp)->first() == null &&
                    $i != $j
                ) {
                    $tmp['nilai'] = 1;
                    d($tmp);
                    $this->nk->save($tmp);
                }
            }
        }
    }
    public function nilai_kriteria()
    {
        $this->cek_kriteria();
        $data = [
            'kriteria' => $this->kriteria->findAll(),
            'nk' => $this->nk->findAll(),
        ];
        return view("ahp/nilai/kriteria", $data);
    }

    public function update_nk($id, $nilai)
    {
        $this->nk->save([
            'id_nilai' => $id,
            'nilai' => $nilai
        ]);
        echo json_encode($this->nk->find($id));
    }
    // nilai alternatif
    public function cek_alter()
    {
        $this->cek_kriteria();
        $kriteria = $this->kriteria->findAll();
        foreach (range(0, count($kriteria) - 1) as $k) {
            $alter = $this->alter->findAll();
            foreach (range(0, count($alter) - 1) as $i) {
                foreach (range($i, count($alter) - 1) as $j) {
                    $tmp = [
                        'id_kriteria' => $kriteria[$k]['id_kriteria'],
                        'alternatif1' => $alter[$i]['id_alternatif'],
                        'alternatif2' => $alter[$j]['id_alternatif'],
                    ];
                    $f = $this->na->where($tmp)->first();
                    if ($i != $j && $f == null) {
                        $tmp['nilai'] = 1;
                        $this->na->save($tmp);
                    }
                }
            }
        }
    }

    public function nilai_alternatif()
    {
        $this->cek_alter();
        $data = [
            'kriteria' => $this->kriteria->findAll(),
        ];
        return view("ahp/nilai/alternatif", $data);
    }
    public function get_nilaiA($kriteria)
    {
        echo json_encode([
            'alter' => $this->alter->findAll(),
            'nilai' => $this->na->where('id_kriteria', $kriteria)->orderBy('id_kriteria')->orderBy('alternatif1')->orderBy('alternatif2')->findAll()
        ]);
    }
    public function update_na($id, $nilai)
    {
        $this->na->save([
            'id_nilai' => $id,
            'nilai' => $nilai
        ]);
        echo json_encode($this->nk->find($id));
    }
    public function ranking()
    {
        if ($this->admin->isLogged()) {

            $this->cek_kriteria();
            function normalisasi($kriteria, $nk, $t = "alter")
            {
                $mapK = [];
                foreach ($kriteria as $k1) {
                    $tmp = [];
                    foreach ($kriteria as $k2) {
                        if ($k1 == $k2) {
                            array_push($tmp, 1);
                        } else {
                            foreach ($nk as $n) {
                                $status = false;
                                if ($t == "kriteria") {
                                    $status = $n['id_kriteria1'] == $k1['id_kriteria'] &&
                                        $n['id_kriteria2'] == $k2['id_kriteria'];
                                } else {
                                    $status = $n['alternatif1'] == $k1['id_alternatif'] &&
                                        $n['alternatif2'] == $k2['id_alternatif'];
                                }
                                $status2 = false;
                                if ($t == "kriteria") {
                                    $status2 = $n['id_kriteria1'] == $k2['id_kriteria'] &&
                                        $n['id_kriteria2'] == $k1['id_kriteria'];
                                } else {
                                    $status2 = $n['alternatif1'] == $k2['id_alternatif'] &&
                                        $n['alternatif2'] == $k1['id_alternatif'];
                                }
                                if (
                                    $status
                                ) {
                                    switch ($n['nilai']) {
                                        case 0.11:
                                            $n['nilai'] = 1 / 9;
                                            break;
                                        case 0.125:
                                            $n['nilai'] = 1 / 8;
                                            break;
                                        case 0.142857:
                                            $n['nilai'] = 1 / 7;
                                            break;
                                        case 0.166667:
                                            $n['nilai'] = 1 / 6;
                                            break;
                                        case 0.2:
                                            $n['nilai'] = 1 / 5;
                                            break;
                                        case 0.25:
                                            $n['nilai'] = 1 / 4;
                                            break;
                                        case 0.3:
                                            $n['nilai'] = 1 / 3;
                                            break;
                                        case 0.5:
                                            $n['nilai'] = 1 / 2;
                                            break;
                                    }
                                    array_push($tmp, $n['nilai']);
                                } else if (
                                    $status2
                                ) {
                                    switch ($n['nilai']) {
                                        case 0.11:
                                            $n['nilai'] = 9;
                                            break;
                                        case 0.125:
                                            $n['nilai'] = 8;
                                            break;
                                        case 0.142857:
                                            $n['nilai'] = 7;
                                            break;
                                        case 0.166667:
                                            $n['nilai'] = 6;
                                            break;
                                        case 0.2:
                                            $n['nilai'] = 5;
                                            break;
                                        case 0.25:
                                            $n['nilai'] = 4;
                                            break;
                                        case 0.3:
                                            $n['nilai'] = 3;
                                            break;
                                        case 0.5:
                                            $n['nilai'] = 2;
                                            break;
                                        default:
                                            $n['nilai'] = 1 / $n['nilai'];
                                    }
                                    // d($n['nilai']);
                                    array_push($tmp, $n['nilai']);
                                }
                            }
                        }
                    }
                    array_push($mapK, $tmp);
                }
                //total
                $total = array_fill(0, count($mapK), 0);
                foreach (range(0, count($mapK) - 1) as $i) {
                    foreach ($mapK as $m) {
                        $total[$i] += $m[$i];
                    }
                }
                $normal = $mapK;
                foreach (range(0, count($total) - 1) as $i) {
                    foreach (range(0, count($normal) - 1) as $j) {
                        $normal[$j][$i] = $normal[$j][$i] / $total[$i];
                    }
                }

                $jumlah = [];
                foreach ($normal as $n) {
                    array_push($jumlah, array_sum($n));
                }
                $pv = [];
                foreach ($jumlah as $j) {
                    array_push($pv, $j / count($kriteria));
                }
                $ri = 0;
                switch (count($jumlah)) {
                    case 1:
                    case 2:
                    case 3:
                        $ri = 0.58;
                        break;
                    case 4:
                        $ri = 0.90;
                        break;
                    case 5:
                        $ri = 1.12;
                        break;
                    case 6:
                        $ri = 1.24;
                        break;
                    case 7:
                        $ri = 1.32;
                        break;
                    case 8:
                        $ri = 1.41;
                        break;
                    case 9:
                        $ri = 1.45;
                        break;
                    case 10:
                        $ri = 0.49;
                        break;
                    case 11:
                        $ri = 1.51;
                        break;
                    case 12:
                        $ri = 1.48;
                        break;
                    case 13:
                        $ri = 1.56;
                        break;
                    case 14:
                        $ri = 1.57;
                        break;
                    case 15:
                        $ri = 0.59;
                        break;
                }
                $max = 0;
                foreach (range(0, count($total) - 1) as $i) {
                    $max += $total[$i] * $pv[$i];
                }
                $ci = ($max - count($total)) / (count($total) - 1);
                return [
                    'map' => $mapK,
                    'total' => $total,
                    'normal' => $normal,
                    'jumlah' => $jumlah,
                    'pv' => $pv,
                    'raw' => $kriteria,
                    'data' => $nk,
                    'ri' => $ri,
                    'max' => $max,
                    'ci' => $ci,
                    'cr' => $ci / $ri,
                    'isCons' => ($ci / $ri) < 0.1 ? true : false
                ];
            }

            $kriteria = $this->kriteria->findAll();
            $nk = $this->nk->findAll();
            $na = $this->na->findAll();
            $alter  = $this->alter->findAll();

            $mapK = normalisasi($kriteria, $nk, $t = "kriteria");

            $vp = [];
            foreach ($mapK['map'] as $m) {
                $tmp = 1;
                foreach ($m as $dat) {
                    $tmp *= $dat;
                }
                $tmp = pow($tmp, 1 / count($m));
                array_push($vp, $tmp);
            }

            $mapA = [];
            foreach ($kriteria as $k) {
                $tmp = [];
                foreach ($na as $n) {
                    if ($n['id_kriteria'] == $k['id_kriteria'])
                        array_push($tmp, $n);
                }
                $m = normalisasi($alter, $tmp);
                array_push($mapA, $m);
            }
            $ranking = [];
            $ranking['raw'] = [];
            foreach (range(0, count($alter) - 1) as $i) {
                $tmp = [];
                foreach ($mapA as $m) {
                    array_push($tmp, $m['pv'][$i]);
                }
                array_push($ranking['raw'], $tmp);
            }
            $ranking['total'] = [];
            foreach (range(0, count($alter) - 1) as $i) {
                $tmp = [];
                foreach (range(0, count($kriteria) - 1) as $j) {
                    $total = $ranking['raw'][$i][$j] * ($vp[$j] / array_sum($vp));
                    array_push($tmp, $total);
                    // $tmp['val'] += $total;
                }
                array_push($ranking['total'], $tmp);
            }
            $total = [];
            foreach ($ranking['total'] as $t) {
                array_push($total, array_sum($t));
            }
            $this->rnk->emptyTable();
            foreach (range(0, count($alter) - 1) as $i) {
                $this->rnk->save([
                    'alternatif' => $alter[$i]['id_alternatif'],
                    'total' => $total[$i]
                ]);
            }

            $total = $this->rnk->orderBy('total', 'DESC')->findAll();

            //matrik pasang banding kriteria
            return view('ahp/hasil', [
                'kriteria' => $kriteria,
                'alter' => $alter,
                'mapK' => $mapK,
                'mapA' => $mapA,
                'vp' => $vp,
                'ranking' => $ranking,
                'total' => $total
            ]);
        } else {
            return redirect()->to("/");
        }
    }
}