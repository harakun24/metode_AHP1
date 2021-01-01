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
        d($kriteria);
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
        d($this->nk->findAll());
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
}