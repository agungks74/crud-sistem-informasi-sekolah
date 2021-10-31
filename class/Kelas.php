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
}
