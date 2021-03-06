<?php
/*
 * pengguna_model.php
 * Penulis: Putu Wiramaswara Widya <initrunlevel0@gmail.com>
 * Kontributor: <<Silahkan diisi>>
 * 
 * Model ini terhubung dengan tabel "pengguna" (lihat PDM untuk lebih lanjut)
 */

class pengguna_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function tambahkan_pengguna($nama_login,$nama_lengkap,$no_handphone, $password_md5)
    {
        // Asumsi: Password telah dikonversi ke MD5 oleh pengendali
        $data = array(
            "nama_login" => $nama_login,
            "nama_lengkap" => $nama_lengkap,
            "surel" => $no_handphone,
            "password" => $password_md5,
            "kredit" => 0
        );
        
        $this->db->insert("pengguna", $data);
                
    }
    
    function baca_data_pengguna($nama_login)
    {
        $query = $this->db->get_where("pengguna", array("nama_login" => $nama_login));
        return $query->first_row("array");
    }
    
    function ubah_data_pengguna($nama_login, $nama_lengkap = null, $no_handphone = null, $password_md5 = null)
    {
        if(!is_null($nama_lengkap)) 
        {
            $this->db->where("nama_login", $nama_login);
            $this->db->update("pengguna", array("nama_lengkap" => $nama_lengkap));
        }
        
        if(!is_null($no_handphone)) 
        {
            $this->db->where("nama_login", $nama_login);
            $this->db->update("pengguna", array("no_handphone" => $no_handphone));
        }
        
        if(!is_null($password_md5)) 
        {
            $this->db->where("nama_login", $nama_login);
            $this->db->update("pengguna", array("password" => $password_md5));
        }
        
    }
    
    function verifikasi_pengguna($nama_login, $password_md5)
    {
        $query = $this->db->get_where("pengguna", array("nama_login" => $nama_login, "password" => $password_md5));
        if($query->num_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function top_up_kredit_pengguna($nama_login, $tambahan_topup)
    {
        // Ambil nilai kredit pengguna sebelumnya
        $query = $this->db->get_where("pengguna", array("nama_login" => $nama_login));
        $row = $query->first_row("array");
        $kredit = intval($row["kredit"]);
        
        // Tambahkan kredit
        $kredit += $tambahan_popup;
        
        $this->db->where("nama_login", $nama_login);
        $this->db->update("pengguna", array("kredit" => $kredit));
        
    }
    
    function lihat_kredit_pengguna($nama_login)
    {
        $data = $this->baca_data_pengguna($nama_login);
        return intval($data['kredit']);
    }
    
    function kurangi_kredit($nama_login, $pengurangan_poin)
    {
        // Ambil nilai kredit pengguna sebelumnya
        $query = $this->db->get_where("pengguna", array("nama_login" => $nama_login));
        $row = $query->first_row("array");
        $kredit = intval($row["kredit"]);
        
        
        // Kurangi kredit
        $kredit -= $pengurangan_poin;
        
        $this->db->where("nama_login", $nama_login);
        $this->db->update("pengguna", array("kredit" => $kredit));
    }
    
    function ambil_nama_login_dari_no_handphone($no_handphone)
    {
        $query = $this->db->get_where("pengguna", array("no_handphone" => $no_handphone));
        if($query->num_rows() > 0)
        {
            $data_pengguna = $query->first_row("array");
            return $data_pengguna['nama_login'];
        }
        else
        {
            return null;
        }
    }
}
?>
