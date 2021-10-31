<?php
class Kelas
{
    private $_db = null;
    private $_formItem = [];

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function validasi($formMethod, $optionSelect = "")
    {
        $validate = new Validate($formMethod);
        
        $this->_formItem['nama_kelas'] = $validate->setRules(
            'nama_kelas',
            'Nama Kelas',
            [
            'required' => true,
            'sanitize' => 'string'
        ]
        );

        $this->_formItem['wali_kelas'] = $validate->setRules(
            'wali_kelas',
            'Wali Kelas',
            ['sanitize' => 'string',
            'required' => true,
            'regexp' => '/^'.$optionSelect.'$/']
        );

        if (!$validate->isPassed()) {
            return $validate->getError();
        }
    }

    public function getItem($item)
    {
        return $this->_formItem[$item] ?? '';
    }

    public function insert()
    {
        $idk = strval(rand(00000000, 99999999));
        $kelasBaru = [
            'idk'=>$idk,
            'nama'=>$this->getItem('nama_kelas'),
            'nig'=>$this->getItem('wali_kelas')
        ];

        return $this->_db->insert('kelas', $kelasBaru);
    }

    public function insertToClass($idk, $nis)
    {
        $daftarSiswa = ['nis'=> $nis, 'idk'=>$idk];

        return $this->_db->insert('kelas_siswa', $daftarSiswa);
    }

    public function deleteFromClass($nis)
    {
        return $this->_db->delete('kelas_siswa', ['nis','=',$nis]);
    }

    public function generate($nis)
    {
        $result = $this->_db->get('siswa', 'INNER JOIN kelas_siswa ON siswa.nis = kelas_siswa.nis WHERE kelas_siswa.nis = ?', [$nis])[0];
    
        foreach ($result as $key=>$val) {
            $this->_formItem[$key] = $val;
        }
    }
}
