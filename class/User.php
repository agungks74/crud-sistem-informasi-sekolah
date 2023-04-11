<?php
class User
{
    private $_db = null;
    private $_formItem = [];
    private $_categories = null;

    public function validasiInsert($formMethod)
    {
        $validate = new Validate($formMethod);
       
        
        $this->_formItem['nama'] = $validate->setRules('nama', 'Nama', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 1,
            ]);
        
        $this->_formItem['password'] = $validate->setRules('password', 'Password', [
                'sanitize' => 'string',
                'required' => true,
                'min_char' => 6,
                'regexp' => '/[A-Za-z]+[0-9]|[0-9]+[A-Za-z]/'
                ]);

        $this->_formItem['ulangi_password'] =
                $validate->setRules('ulangi_password', 'Ulangi password', [
                'sanitize' => 'string',
                'required' => true,
                'matches' => 'password'
                ]);
        
        $this->_formItem['alamat'] = $validate->setRules('alamat', 'Alamat', [
                    'sanitize' => 'string',
                    'required' => true,
                    'min_char' => 1,
                    ]);

        $this->_categories = $validate->setRules(
            'categories',
            'Kategori',
            ['sanitize' => 'string',
                            'required' => true,
                            'regexp' => '/^guru|siswa$/']
        );
        
        if (!$validate->isPassed()) {
            return $validate->getError();
        }

        $this->_formItem['email'] = $validate->setRules('email', 'Email', [
                'sanitize' => 'string',
                'required' => true,
                'email' => true,
                'unique' => [$this->_categories =>'email'],
                ]);

     
       
       
        if (!$validate->isPassed()) {
            return $validate->getError();
        }
    }

    public function validasiLogin($formMethod)
    {
        $validate = new Validate($formMethod);

        $this->_formItem['email'] = $validate->setRules('email', 'Email', ['sanitize' => 'string','required' => true]);
        $this->_formItem['password'] = $validate->setRules('password', 'Password', ['sanitize' => 'string', 'required' => true]);

        if (!$validate->isPassed()) {
            return $validate->getError();
        } else {
            $this->_db = DB::getInstance();
            $this->_db->select('password, nama');
            
            $result = $this->_db->getWhereOnce('siswa', ['email','=',$this->_formItem['email']]);
            $this->_categories = 'siswa';

            if (empty($result)) {
                $result = $this->_db->getWhereOnce('guru', ['email','=',$this->_formItem['email']]);
                $this->_categories = 'guru';
            }

      

            if (empty($result)) {
                $result = $this->_db->getWhereOnce('admin', ['email','=',$this->_formItem['email']]);
                $this->_categories = 'admin';
            }
            
            if (empty($result) || !password_verify($this->_formItem['password'], $result->password)) {
                $pesanError[] = "Maaf, username / password salah";
                return $pesanError;
            }
            $this->_formItem['nama'] = $result->nama;
        }
    }

    public function validasiUpdate($formMethod)
    {
        $validate = new Validate($formMethod);

        $this->_formItem['nama'] = $validate->setRules('nama', 'Nama', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 1,
            ]);

 

        $this->_formItem['alamat'] = $validate->setRules('alamat', 'Alamat', [
                'sanitize' => 'string',
                'required' => true,
                'min_char' => 1,
                ]);


        if (!$validate->isPassed()) {
            return $validate->getError();
        }
    }

    public function login()
    {
        $_SESSION['email'] = $this->getItem('email');
        $_SESSION['nama'] = $this->getItem('nama');
        $_SESSION['categories'] = $this->_categories;


        header("Location: dashboard.php");
    }

    public function logout()
    {
        unset($_SESSION['email']);
        unset($_SESSION['categories']);
        unset($_SESSION['nama']);

        header("Location: login.php");
    }

    public function getItem($item)
    {
        return $this->_formItem[$item] ?? '';
    }

    public function insert()
    {
        $this->_db = DB::getInstance();

        $id = strval(rand(00000000, 99999999));

        $idColumn = $this->_categories=='guru'? 'nig':'nis';

        $newUser = [
            $idColumn => $id,
            'nama' => $this->getItem('nama'),
            'password' => password_hash($this->getItem('password'), PASSWORD_DEFAULT),
            'email' => $this->getItem('email'),
            'alamat' => $this->getItem('alamat'),
        ];

        return $this->_db->insert($this->_categories, $newUser);
    }

    public function update($categories)
    {
        $dataBaru = ['nama' => $this->getItem("nama"),'alamat' => $this->getItem("alamat")];

        
        if ($categories == 'siswa') {
            $this->_db->update($categories, $dataBaru, ['nis','=',$this->_formItem['nis']]);
        } elseif ($categories == 'guru') {
            $this->_db->update($categories, $dataBaru, ['nig','=',$this->_formItem['nig']]);
        }
    }

    public function delete($id, $categories)
    {
        if ($categories == 'siswa') {
            $this->_db->delete($categories, ['nis','=',$id]);
        } elseif ($categories == 'guru') {
            $this->_db->delete($categories, ['nig','=',$id]);
        }
    }

    public function cekUserSession()
    {
        if (!isset($_SESSION['email'])) {
            header("Location: login.php");
        }
    }

    public function generate($id, $categories)
    {
        $this->_db = DB::getInstance();
        if ($categories == 'siswa') {
            $result = $this->_db->getWhereOnce($categories, ['nis','=',$id]);
        } elseif ($categories == 'guru') {
            $result = $this->_db->getWhereOnce($categories, ['nig','=',$id]);
        }
        
        foreach ($result as $key=>$val) {
            $this->_formItem[$key] = $val;
        }
    }
}
