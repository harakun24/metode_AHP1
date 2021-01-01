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
    }
    public function index()
    {
        if ($this->admin->isLogged()) {
            return view("ahp/home");
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
}