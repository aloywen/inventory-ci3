<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        // $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $role = $this->session->userdata('role_id');

        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('user_role', 'user_role.uid = user.role_id');
        $this->db->where('user_role.uid', $role);
        $data['user'] = $this->db->get()->row_array();

        // var_dump($dataa);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }


    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $username = $this->input->post('username');

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->dispay_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('username', $username);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil DiUpdate</div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
                    redirect('user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('username', $this->session->userdata('username'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
 
    // BARANG

    public function data_barang() {
        $data['title'] = 'Data Barang';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('stok_akhir', 'stok_akhir.uid = barang.id');
        $data['barang'] = $this->db->get()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/data_barang', $data);
        $this->load->view('templates/footer');
    }

    public function addProduct() 
    {

        $this->form_validation->set_rules('nama_barang', 'Nama_barang', 'required|trim');
        $this->form_validation->set_rules('kode_barang', 'Kode_barang', 'required|trim');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Data Barang';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/data_barang', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kode_barang' => htmlspecialchars($this->input->post('kode_barang', true)),
                'nama_barang' => htmlspecialchars(addslashes($this->input->post('nama_barang', true))),
            ];

            // var_dump($data);
            $this->db->insert('barang', $data);


            $getid = $this->db->get_where('barang', ['kode_barang' => $this->input->post('kode_barang')])->row_array();
            $gId = $getid['id'];

            $this->db->insert('stok_akhir', ['uid' => $gId, 'kode_barang' => htmlspecialchars($this->input->post('kode_barang', true)), 'stok' => 0 ]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Berhasil Ditambah!</div>');
            redirect('user/data_barang');
        }
    }

    public function editProduct($id) {
            $data['title'] = 'Data Barang';
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

            $this->form_validation->set_rules('kode_barang', 'Kode_barang', 'required|trim');
            $this->form_validation->set_rules('nama_barang', 'Nama_barang', 'required|trim');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('user/supplier', $data);
                $this->load->view('templates/footer');
            } else {
                $kode_barang = $this->input->post('kode_barang');
                $nama_barang = $this->input->post('nama_barang');


                // var_dump($id,$kode_barang,$nama_barang);
                $this->db->set(['kode_barang' => $kode_barang, 'nama_barang' => $nama_barang]);
                $this->db->where('id', $id);
                $this->db->update('barang');

                $this->db->set(['kode_barang' => $kode_barang]);
                $this->db->where('uid', $id);
                $this->db->update('stok_akhir');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang Berhasil Di Update!</div>');
                redirect('user/data_barang');
        }
    }

    public function hapusProduct($id) {
        $this->db->where('id', $id);
        $this->db->delete('barang');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang Berhasil Dihapus!</div>');
        redirect('user/data_barang'); 
    }

    public function getBarang()
    {
        $kode_barang = $this->input->post('kode_barang');
        $dataExp = $this->db->get_where('kode', ['kode_barang' => $kode_barang])->result();

        echo json_encode($dataExp);
    }

    // BARANG MASUK 

    public function barang_masuk()
    {
        $data['title'] = 'Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('*');
        $this->db->from('barang_masuk');
        $this->db->join('barang', 'barang.kode_barang = barang_masuk.kode_barang');
        $data['barang'] = $this->db->get()->result_array();

        $query = $this->db->query("SELECT MAX(nomor_transaksi) as m_transaksi from barang_masuk");
        $da = $query->row();
        $data['no_transaksi'] = $da->m_transaksi;


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/barang_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function addMasuk()
    {
        $data['title'] = 'Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();


        // $query = $this->db->query("SELECT MAX(nomor_transaksi) as m_transaksi from barang_keluar");
        // $da = $query->row();
        // $data['no_transaksi'] = $da->m_transaksi;

        $data['pengiriman'] = $this->db->get('jasa_kirim')->result_array();

        // echo $getNomor;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/tambahmasuk', $data);
        $this->load->view('templates/footer');
    }

    public function tambahMasuk()
    {

        $this->form_validation->set_rules('nomor_transaksi', 'nomor_Transaksi', 'required|trim');
        $this->form_validation->set_rules('kode_barang', 'Kode_Barang', 'required|trim');
        $this->form_validation->set_rules('supplier', 'Supplier', 'required|trim');
        $this->form_validation->set_rules('qty', 'Qty', 'required|trim');
        $this->form_validation->set_rules('tgl_transaksi', 'Tgl_transaksi', 'required|trim');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Barang Masuk';

            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/tambahmasuk', $data);
            $this->load->view('templates/footer');
        } else {
            
            $getNomor = $this->db->get_where('barang_masuk', ['nomor_transaksi' => $this->input->post('nomor_transaksi')])->num_rows();

            $getKodebarang = $this->db->get_where('barang', ['kode_barang' => $this->input->post('kode_barang')])->num_rows();

            $getNamabarang = $this->db->get_where('barang', ['nama_barang' => $this->input->post('nama_barang')])->num_rows();

            $getSupplier = $this->db->get_where('supplier', ['nama_supplier' => $this->input->post('supplier')])->num_rows();

            // CEK NOMOR TRANSAKSI BILA BLM ADA
            if( $getNomor < 1) {
                    // CEK VALIDASI BARANG & SUPPLIER SESUAI DATABASE
                    if($getNamabarang > 0 && $getKodebarang > 0 && $getSupplier > 0) {

                        $data = [
                            'nomor_transaksi' => htmlspecialchars(strtoupper($this->input->post('nomor_transaksi', true))),
                            'kode_barang' => htmlspecialchars($this->input->post('kode_barang', true)),
                            'supplier' => htmlspecialchars($this->input->post('supplier', true)),
                            'qty' => htmlspecialchars($this->input->post('qty', true)),
                            'tgl_transaksi' => date('Y-m-d', strtotime($this->input->post('tgl_transaksi'))),
                        ];
                        
                        // INSERT DATA BARANG MASUK
                        $this->db->insert('barang_masuk', $data);
                                                
            
                        // ambil stok terakhir
                        $stok_akhir = $this->db->get_where('stok_akhir', ['kode_barang' => $this->input->post('kode_barang')])->row_array();
                        $nilai = $stok_akhir['stok'];
            
                        // stok akhir ditambah barang masuk
                        $masuk_stok = $nilai + $this->input->post('qty');
            
                        // UPDATE STOK BARANG BARU
                        $this->db->set(['stok' => $masuk_stok]);
                        $this->db->where('kode_barang', $this->input->post('kode_barang'));
                        $this->db->update('stok_akhir');
                    
            
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang Berhasil Ditambah!</div>');
                        redirect('user/barang_masuk');

                    } elseif ($getNamabarang < 1 || $getKodebarang < 1 || $getSupplier < 1) {

                        $this->session->set_flashdata('namabarang', '<div class="alert alert-danger" role="alert">Kode Barang / Barang / Supplier Tidak Valid!</div>');
            
                        redirect('user/addMasuk');
                    }

                // CEK NOMOR TRANSAKSI BILA SUDAH ADA
            } else if ( $getNomor > 0) {

                $this->session->set_flashdata('nomor', '<div class="alert alert-danger" role="alert">Nomor Transaksi sudah ada!</div>');
            
                redirect('user/addMasuk');
            }

        }
    }

    public function hapusMasuk()
    {
        $uid = $this->uri->segment(3);
        $nomor_transaksi = $this->uri->segment(4);
        $kode_barang = $this->uri->segment(5);

        $t = $this->db->get_where('barang_masuk', ['nomor_transaksi' => $nomor_transaksi])->row_array();
        $qtyMasuk = $t['qty'];
        
        $stok_akhir = $this->db->get_where('stok_akhir', ['kode_barang' => $kode_barang])->row_array();
        $nilai_stok = $stok_akhir['stok'];
        
        $update = $nilai_stok - $qtyMasuk;

        $this->db->set(['stok' => $update]);
        $this->db->where('kode_barang', $kode_barang);
        $this->db->update('stok_akhir');


        $this->db->where('uid', $uid);
        $this->db->delete('barang_masuk');


        $this->db->where('uid', $uid);
        $this->db->delete('mutasi');


        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaksi Berhasil Dihapus!</div>');
        redirect('user/barang_masuk');
    }

    public function editM($id)
    {
        $data['title'] = ' Detail Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        // $data['barang'] = $this->db->get_where('barang_masuk', ['id' => $id])->row_array();

        $this->db->select('*');
        $this->db->from('barang_masuk');
        $this->db->join('barang', 'barang.kode_barang = barang_masuk.kode_barang');
        $this->db->where('barang_masuk.nomor_transaksi', $id);
        $data['barang'] = $this->db->get()->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/editmasuk', $data);
        $this->load->view('templates/footer');
    }

    public function editMasuk($uid)
    {
        $data['title'] = 'Detail Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('kode_barang', 'Kode_Barang', 'required|trim');
        $this->form_validation->set_rules('supplier', 'Nama_supplier', 'required|trim');
        $this->form_validation->set_rules('qty', 'Qty', 'required|trim');
        $this->form_validation->set_rules('temp', 'Temp', 'required|trim');
        $this->form_validation->set_rules('tgl_transaksi', 'Tgl_transaksi', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/editmasuk', $data);
            $this->load->view('templates/footer');
        } else {
            // $uid = $this->input->post('uid');
            $tempNo = $this->input->post('tempno');
            $nomor_transaksi = $this->input->post('nomor_transaksi');
            $kode_barang = $this->input->post('kode_barang');
            $nama_barang = $this->input->post('nama_barang');
            $supplier = $this->input->post('supplier');
            $qty = $this->input->post('qty');
            $tgl_transaksi = $this->input->post('tgl_transaksi');
            $temp = $this->input->post('temp');
            $tempQty = $this->input->post('tempQty');


            // var_dump($id,$kode_barang,$nama_barang,$supplier,$qty,$tgl_transaksi);

            $getNomor = $this->db->get_where('barang_masuk', ['nomor_transaksi' => $nomor_transaksi])->num_rows();

            $getKodebarang = $this->db->get_where('barang', ['kode_barang' => $kode_barang])->num_rows();

            $getNamabarang = $this->db->get_where('barang', ['nama_barang' => $nama_barang])->num_rows();

            $getSupplier = $this->db->get_where('supplier', ['nama_supplier' => $supplier])->num_rows();


            // CEK NO TRANSAKSI JIKA MSH SAMA ATAU NOMOR BARU DAN BLM ADA
            if( $tempNo == $nomor_transaksi || $getNomor < 1) {
                    // CEK VALIDASI BARANG & SUPPLIER SESUAI DATABASE
                    if($getNamabarang > 0 && $getKodebarang > 0 && $getSupplier > 0) {
                        // JIKA PERUBAHAN BARANG YG SAMA
                        if($temp == $kode_barang){
            
                            // CEK QTY TRANSAKSI SEBELUM EDIT
                            $t = $this->db->get_where('barang_masuk', ['uid' => $uid])->row_array();
                            $qtyMasuk = $t['qty'];
                            
                            // CEK STOK AWAL
                            $stok_akhir = $this->db->get_where('stok_akhir', ['kode_barang' => $kode_barang])->row_array();
                            $nilai_stok = $stok_akhir['stok'];
                            
                            // JIKA QTY BARU LEBIH BANYAK DARI SEBELUMNYA
                            if($qty > $tempQty){
                                $kode = $this->input->post('kode_barang');
                
                                // STOK AWAL DITAMBAH QTY BARU
                                $d = $qty - $tempQty;
                                $new = $nilai_stok + $d;
                            
                                // UPDATE STOK
                                $this->db->set(['stok' => $new]);
                                $this->db->where('kode_barang', $kode);
                                $this->db->update('stok_akhir');
                
                                // UPDATE TRANSAKSI BARANG MASUK
                                $this->db->set(['nomor_transaksi' => $nomor_transaksi, 'kode_barang' => $kode_barang, 'supplier' => $supplier, 'qty' => $qty, 'tgl_transaksi' => $tgl_transaksi]);
                                $this->db->where('uid', $uid);
                                $this->db->update('barang_masuk');
                
                                // JIKA QTY BARU LEBIH SEDIKIT DARI SEBELUMNYA
                            } else if ($qty < $tempQty) {
                                $kode = $this->input->post('kode_barang');
                
                                // STOK AWAL DIKURANG QTY BARU
                                $d = $tempQty - $qty;
                                $new = $nilai_stok - $d;
                                
                
                                // UPDATE STOK
                                $this->db->set(['stok' => $new]);
                                $this->db->where('kode_barang', $kode);
                                $this->db->update('stok_akhir');
                
                                // UPDATE TRANSAKSI BARANG MASUK
                                $this->db->set(['nomor_transaksi' => $nomor_transaksi, 'kode_barang' => $kode_barang, 'supplier' => $supplier, 'qty' => $qty, 'tgl_transaksi' => $tgl_transaksi]);
                                $this->db->where('uid', $uid);
                                $this->db->update('barang_masuk');
                
                                // JIKA QTY BARU SAMA DGN QTY SEBELUMNYA
                            } else if ($qty == $tempQty) {
            
                                // UPDATE TRANSAKSI BARANG MASUK
                                $this->db->set(['nomor_transaksi' => $nomor_transaksi, 'kode_barang' => $kode_barang, 'supplier' => $supplier, 'qty' => $qty, 'tgl_transaksi' => $tgl_transaksi]);
                                $this->db->where('uid', $uid);
                                $this->db->update('barang_masuk');
                
                            }
            
                        } else if ($temp !== $kode_barang) {
            
                            /// CEK QTY TRANSAKSI SEBELUM EDIT
                            $t = $this->db->get_where('barang_masuk', ['uid' => $uid])->row_array();
                            $qtyMasuk = $t['qty'];
                            
                            // CEK STOK BARANG SEBELUMNYA
                            $s = $this->db->get_where('stok_akhir', ['kode_barang' => $temp])->row_array();
                            $stok_barangsebelumnya = $s['stok'];
                            
                            // CEK STOK BARANG BARU
                            $st = $this->db->get_where('stok_akhir', ['kode_barang' => $kode_barang])->row_array();
                            $stok_barangbaru = $st['stok'];
                            
                            // HITUNG PENGURANGAN STOK BARANG SEBELUMNYA
                            $hapusQty = $stok_barangsebelumnya - $qtyMasuk;
                            
                            // HITUNG PENAMBAHAN STOK BARANG BARU
                            $updateQty = $stok_barangbaru + $qty;
            
                            // UPDATE STOK BARANG YG TERGANTI
                            $this->db->set(['stok' => $hapusQty]);
                            $this->db->where('kode_barang', $temp);
                            $this->db->update('stok_akhir');
            
                            // UPDATE STOK BARANG YG BARU
                            $this->db->set(['stok' => $updateQty]);
                            $this->db->where('kode_barang', $kode_barang);
                            $this->db->update('stok_akhir');
            
                            // UPDATE TRANSAKSI BARANG MASUK
                            $this->db->set(['nomor_transaksi' => $nomor_transaksi, 'kode_barang' => $kode_barang, 'supplier' => $supplier, 'qty' => $qty]);
                            $this->db->where('uid', $uid);
                            $this->db->update('barang_masuk');
            
            
                        }
            
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaksi Berhasil Di Update!</div>');
                        redirect('user/barang_masuk');

                    } elseif ($getNamabarang < 1 || $getKodebarang < 1 || $getSupplier < 1) {

                        $this->session->set_flashdata('namabarang', '<div class="alert alert-danger" role="alert">Kode Barang / Barang / Supplier Tidak Valid!</div>');
            
                        $url = base_url('user/editM/').$tempNo;
                        redirect($url, 'refresh');
                    }

                } else if ( $tempNo !== $nomor_transaksi && $getNomor > 0) {

                $this->session->set_flashdata('nomor', '<div class="alert alert-danger" role="alert">Nomor Transaksi sudah ada!</div>');
            
                $url = base_url('user/editM/').$tempNo;
                redirect($url, 'refresh');
            }

        }
    }

    // BARANG KELUAR 

    public function barang_keluar()
    {
        $data['title'] = 'Barang Keluar';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('*');
        $this->db->from('barang_keluar');
        $this->db->join('barang', 'barang.kode_barang = barang_keluar.kode_barang');
        $data['barang'] = $this->db->get()->result_array();

        $query = $this->db->query("SELECT MAX(nomor_transaksi) as m_transaksi from barang_keluar");
        $da = $query->row();
        $data['no_transaksi'] = $da->m_transaksi;


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/barang_keluar', $data);
        $this->load->view('templates/footer');
    }

    public function addKeluar()
    {
        $data['title'] = 'Barang Keluar';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();


        $query = $this->db->query("SELECT MAX(nomor_transaksi) as m_transaksi from barang_keluar");
        $da = $query->row();
        $data['no_transaksi'] = $da->m_transaksi;

        $data['pengiriman'] = $this->db->get('jasa_kirim')->result_array();

        // echo $getNomor;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/tambahkeluar', $data);
        $this->load->view('templates/footer');
    }

    public function tambahKeluar()
    {

        $this->form_validation->set_rules('nomor_transaksi', 'Nomor Transaksi', 'required|trim');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required|trim');
        $this->form_validation->set_rules('pelanggan', 'Pelanggan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('qty', 'Qty', 'required|trim');
        $this->form_validation->set_rules('tgl_keluar', 'Tgl Keluar', 'required|trim');
        $this->form_validation->set_rules('kirim_by', 'Kirim Via', 'required|trim');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Barang Keluar';

            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/tambahkeluar', $data);
            $this->load->view('templates/footer');
        } else {

            $getNomor = $this->db->get_where('barang_keluar', ['nomor_transaksi' => $this->input->post('nomor_transaksi')])->num_rows();

            $getKodebarang = $this->db->get_where('barang', ['kode_barang' => $this->input->post('kode_barang')])->num_rows();

            $gStok = $this->db->get_where('stok_akhir', ['kode_barang' => $this->input->post('kode_barang')])->row_array();
            $getStok = $gStok['stok'];

            $getNamabarang = $this->db->get_where('barang', ['nama_barang' => $this->input->post('nama_barang')])->num_rows();

            $getJasa = $this->db->get_where('jasa_kirim', ['nama_jasa' => $this->input->post('kirim_by')])->num_rows();
            
            // CEK NOMOR TRANSAKSI BILA BLM ADA
            if( $getNomor < 1 ) {

                // CEK BILA STOK ADA
                if($getStok > 0) {

                    // CEK VALIDASI BARANG & JASA SESUAI DATABASE
                    if($getNamabarang > 0 && $getKodebarang > 0 && $getJasa > 0) {
    
                        $data = [
                            'nomor_transaksi' => htmlspecialchars(strtoupper($this->input->post('nomor_transaksi', true))),
                            'kode_barang' => htmlspecialchars($this->input->post('kode_barang', true)),
                            'pelanggan' => htmlspecialchars($this->input->post('pelanggan', true)),
                            'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                            'qty' => htmlspecialchars($this->input->post('qty', true)),
                            'tgl_keluar' => date('Y-m-d', strtotime($this->input->post('tgl_keluar'))),
                            'kirim_by' => htmlspecialchars($this->input->post('kirim_by', true)),
                        ];
                        
                        // TAMBAH DATA BARANG KELUAR
                        $this->db->insert('barang_keluar', $data);
            
                        $qtyKeluar = $this->input->post('qty');
                        $kode_barang = $this->input->post('kode_barang');
            
                        // CARI NILAI STOK TERAKHIR DARI BARANG TERPILIH
                        $stok_akhir = $this->db->get_where('stok_akhir', ['kode_barang' => $kode_barang])->row_array();
                        $nilai_stok = $stok_akhir['stok'];
                        
                        // HITUNG PENGURANGAN STOK
                        $update = $nilai_stok - $qtyKeluar;
            
                        // UPDATE STOK BARANG
                        $this->db->set(['stok' => $update]);
                        $this->db->where('kode_barang', $kode_barang);
                        $this->db->update('stok_akhir');
            
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang Berhasil Ditambah!</div>');
                        redirect('user/barang_keluar');
    
                        // CEK JIKA BARANG & JASA TIDAK VALID
                    } else if ($getNamabarang < 1 || $getKodebarang < 1 || $getJasa < 1) {
    
                        $this->session->set_flashdata('namabarang', '<div class="alert alert-danger" role="alert">Kode Barang / Barang / Jasa Tidak Valid!</div>');
            
                        redirect('user/addKeluar');
                    }

                    // CEK JIKA STOK KOSONG
                } else if ($getStok < 1) {

                    $this->session->set_flashdata('stok', '<div class="alert alert-danger" role="alert">Stok Kosong!</div>');
        
                    redirect('user/addKeluar');

                }

                // CEK BILA NOMOR TRANSAKSI SUDAH ADA
            } else if ( $getNomor > 0 ) {
                $this->session->set_flashdata('nomor', '<div class="alert alert-danger" role="alert">Nomor Transaksi sudah ada!</div>');
            
                redirect('user/addKeluar', 'refresh');
            }

        }
    }

    public function hapusKeluar()
    {
        $uid = $this->uri->segment(3);
        $nomor_transaksi = $this->uri->segment(4);
        $kode_barang = $this->uri->segment(5);

        // var_dump($nomor_transaksi);

        $t = $this->db->get_where('barang_keluar', ['nomor_transaksi' => $nomor_transaksi])->row_array();
        $qtyMasuk = $t['qty'];
        // echo 'qty yg dipilih '.$qtyMasuk;
        // echo '<br/>';
        
        $stok_akhir = $this->db->get_where('stok_akhir', ['kode_barang' => $kode_barang])->row_array();
        $nilai_stok = $stok_akhir['stok'];
        // echo 'stok sekarang'.$nilai_stok;
        // echo '<br/>';
        
        $update = $nilai_stok + $qtyMasuk;
        // echo 'stok terupdate'.$update;

        $this->db->set(['stok' => $update]);
        $this->db->where('kode_barang', $kode_barang);
        $this->db->update('stok_akhir');

        
        $this->db->where('uid', $uid);
        $this->db->delete('barang_keluar');

        $this->db->where('uid', $uid);
        $this->db->delete('mutasi');


        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaksi Berhasil Dihapus!</div>');
        redirect('user/barang_keluar');
    }

    public function editK($nomor_transaksi)
    {
        $data['title'] = 'Detail Barang Keluar';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('*');
        $this->db->from('barang_keluar');
        $this->db->join('barang', 'barang.kode_barang = barang_keluar.kode_barang');
        $this->db->where('barang_keluar.nomor_transaksi', $nomor_transaksi);
        $data['barang'] = $this->db->get()->row_array();

        $data['pengiriman'] = $this->db->get('jasa_kirim')->result_array();

        // var_dump($dataa);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/editkeluar', $data);
        $this->load->view('templates/footer');
    }

    public function editKeluar($uid)
    {
        $data['title'] = 'Detail Barang Keluar';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('nomor_transaksi', 'Nomor_transaksi', 'required|trim');
        $this->form_validation->set_rules('kode_barang', 'Kode_Barang', 'required|trim');
        $this->form_validation->set_rules('pelanggan', 'Pelanggan', 'required|trim');
        $this->form_validation->set_rules('qty', 'Qty', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('tgl_keluar', 'Tgl_Keluar', 'required|trim');
        $this->form_validation->set_rules('kirim_by', 'kirim_by', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/editkeluar', $data);
            $this->load->view('templates/footer');
        } else {
            $tempKode_barang = $this->input->post('tempKode_barang');
            $tempNo = $this->input->post('tempno');
            $nomor_transaksi = $this->input->post('nomor_transaksi');
            $kode_barang = $this->input->post('kode_barang');
            $qty = $this->input->post('qty');
            $tempQty = $this->input->post('tempQty');
            $pelanggan = $this->input->post('pelanggan');
            $alamat = $this->input->post('alamat');
            $kirim_by = $this->input->post('kirim_by');
            $tgl_keluar = date('Y-m-d', strtotime($this->input->post('tgl_keluar')));
            


            // var_dump($uid,$tempKode_barang,$nomor_transaksi,$kode_barang,$qty,$tempQty);

            $getNomor = $this->db->get_where('barang_keluar', ['nomor_transaksi' => $this->input->post('nomor_transaksi')])->num_rows();

            $getKodebarang = $this->db->get_where('barang', ['kode_barang' => $this->input->post('kode_barang')])->num_rows();

            $gStok = $this->db->get_where('stok_akhir', ['kode_barang' => $this->input->post('kode_barang')])->row_array();
            $getStok = $gStok['stok'];

            $getNamabarang = $this->db->get_where('barang', ['nama_barang' => $this->input->post('nama_barang')])->num_rows();

            $getJasa = $this->db->get_where('jasa_kirim', ['nama_jasa' => $this->input->post('kirim_by')])->num_rows();

            // CEK NOMOR TRANSAKSI BILA USDAH ADA
            if( $tempNo == $nomor_transaksi || $getNomor < 1 ) {
                // CEK KETERSEDIAAN STOK
                if($getStok > 0) {
                    // CEK VALIDASI BARANG & JASA SESUAI DATABASE
                    if($getNamabarang > 0 && $getKodebarang > 0 && $getJasa > 0) {
                        if($tempKode_barang == $kode_barang){
                            
                            $stok_akhir = $this->db->get_where('stok_akhir', ['kode_barang' => $kode_barang])->row_array();
                            $nilai_stok = $stok_akhir['stok'];
                            
                            // JIKA QTY BARU LEBIH BESAR QTY SEBELUMNYA
                            if($qty > $tempQty){
                                
                                // HITUNG SELISIH QTY BARU DGN QTY LAMA
                                $d = $qty - $tempQty;

                                // HITUNG STOK AWAL DIKURANG QTY BARU
                                $new = $nilai_stok - $d;
                                
                                // UPDATE STOK
                                $this->db->set(['stok' => $new]);
                                $this->db->where('kode_barang', $kode_barang);
                                $this->db->update('stok_akhir');
                
                                // UPDATE TRANSAKSI BARANG KELUAR
                                $this->db->set(['nomor_transaksi' => $nomor_transaksi, 'kode_barang' => $kode_barang, 'pelanggan' => $pelanggan, 'qty' => $qty, 'alamat' => $alamat, 'tgl_keluar' => date('Y-m-d', strtotime($this->input->post('tgl_keluar'))), 'kirim_by' => $kirim_by]);
                                $this->db->where('uid', $uid);
                                $this->db->update('barang_keluar');
        
                
                                // JIKA QTY BARU LEBIH KECIL QTY SEBELUMNYA
                            } else if ($qty < $tempQty) {
                
                                // HITUNG SELISIH QTY SEBELUMNYA DIKURANG QTY BARU
                                $d = $tempQty - $qty;

                                // HITUNG STOK AWAL DITAMBAH QTY BARU
                                $new = $nilai_stok + $d;
                
                                // UPDATE STOK
                                $this->db->set(['stok' => $new]);
                                $this->db->where('kode_barang', $kode_barang);
                                $this->db->update('stok_akhir');
                
                                // UPDATE BARANG KELUAR
                                $this->db->set(['nomor_transaksi' => strtoupper($nomor_transaksi),'kode_barang' => $kode_barang, 'qty' => $qty, 'tgl_keluar' => $tgl_keluar, 'pelanggan' => $pelanggan, 'alamat' => $alamat, 'kirim_by' => $kirim_by ]);
                                $this->db->where('uid', $uid);
                                $this->db->update('barang_keluar');
                
                                // JIKA QTY BARU SAMA QTY SEBELUMYA
                            } else if ($qty == $tempQty) {

                                // UPDATE TRANSAKSI BARANG KELUAR
                                $this->db->set(['nomor_transaksi' => strtoupper($nomor_transaksi), 'kode_barang' => $kode_barang, 'pelanggan' => $pelanggan, 'qty' => $qty, 'alamat' => $alamat, 'tgl_keluar' => date('Y-m-d', strtotime($this->input->post('tgl_keluar'))), 'kirim_by' => $kirim_by]);
                                $this->db->where('uid', $uid);
                                $this->db->update('barang_keluar');
        
                            }
                            
                        } else if ( $tempKode_barang !== $kode_barang){
                            
                            // CEK STOK BARANG BARU
                            $stok_akhir = $this->db->get_where('stok_akhir', ['kode_barang' => $kode_barang])->row_array();
                            $nilai_stok = $stok_akhir['stok'];

                            // HITUNG STOK BARANG BARU DIKURANG QTY BARU
                            $newData = $nilai_stok - $qty;
                            
                            // UPDATE STOK
                            $this->db->set(['stok' => $newData]);
                            $this->db->where('kode_barang', $kode_barang);
                            $this->db->update('stok_akhir');
                            
                            // STOK BARANG SEBELUMNYA
                            $stok = $this->db->get_where('stok_akhir', ['kode_barang' => $tempKode_barang])->row_array();
                            $stok_lama = $stok['stok'];

                            
                            // STOK BARANG SEBELUMNYA DITAMBAH QTY LAMA
                            $updateK = $stok_lama + $tempQty;
                            
                            // UPDATE STOK SEBELUMNYA
                            $this->db->set(['stok' => $updateK]);
                            $this->db->where('kode_barang', $tempKode_barang);
                            $this->db->update('stok_akhir');


                            // UPDATE TRANSAKSI BARANG KELUAR
                            $this->db->set(['nomor_transaksi' => strtoupper($nomor_transaksi), 'kode_barang' => $kode_barang, 'qty' => $qty, 'pelanggan' => $pelanggan, 'alamat' => $alamat, 'tgl_keluar' => $tgl_keluar, 'kirim_by' => $kirim_by]);
                            $this->db->where('uid', $uid);
                            $this->db->update('barang_keluar');
                            
                        }
                        // CEK JIKA BARANG & JASA TIDAK SESUAI DATABASE
                    } else if ($getNamabarang < 1 || $getKodebarang < 1 || $getJasa < 1) {
    
                        $this->session->set_flashdata('namabarang', '<div class="alert alert-danger" role="alert">Kode Barang / Barang / Jasa Tidak Valid!</div>');
            
                        $url = base_url('user/editK/').$tempNo;
                        redirect($url, 'refresh');
                    }

                    // CEK JIKA STOK KOSONG
                } else if ($getStok < 1) {

                    $this->session->set_flashdata('stok', '<div class="alert alert-danger" role="alert">Stok Kosong!</div>');
        
                    $url = base_url('user/editK/').$tempNo;
                    redirect($url, 'refresh');

                }
                // CEK NOMOR TRANSAKSI BILA BARU DAN SUDAH ADA
            } else if ( $tempNo !== $nomor_transaksi && $getNomor > 0 ) {
                $this->session->set_flashdata('nomor', '<div class="alert alert-danger" role="alert">Nomor Transaksi sudah ada!</div>');
            
                $url = base_url('user/editK/').$tempNo;
                redirect($url, 'refresh');
            }
            
            
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaksi Berhasil Di Update!</div>');
            redirect('user/barang_keluar');
        }
    }

    // SUPPLIER

    public function supplier() 
    {

        $data['title'] = 'Supplier';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $data['supplier'] = $this->db->get('supplier')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/supplier', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tambahSupplier() 
    {

        $this->form_validation->set_rules('kode_supplier', 'Kode_supplier', 'required|trim');
        $this->form_validation->set_rules('nama_supplier', 'Nama_supplier', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Supplier';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/supplier', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kode_supplier' => htmlspecialchars($this->input->post('kode_supplier', true)),
                'nama_supplier' => htmlspecialchars($this->input->post('nama_supplier', true)),
                'alamat' => htmlspecialchars($this->input->post('alamat', true)),
            ];

            // var_dump($data);
            $this->db->insert('supplier', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Supplier Berhasil Ditambah!</div>');
            redirect('user/supplier');
        }
    }

    public function editSupplier($id)
    {
        $data['title'] = 'Supplier';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('kode_supplier', 'Kode_supplier', 'required|trim');
        $this->form_validation->set_rules('nama_supplier', 'Nama_supplier', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/supplier', $data);
            $this->load->view('templates/footer');
        } else {
            $kode_supplier = $this->input->post('kode_supplier');
            $nama_supplier = $this->input->post('nama_supplier');
            $alamat = $this->input->post('alamat');


            // var_dump($id,$kode_barang,$nama_barang,$supplier,$alamat,$tgl_keluar);
            $this->db->set(['kode_supplier' => $kode_supplier, 'nama_supplier' => $nama_supplier, 'alamat' => $alamat]);
            $this->db->where('id', $id);
            $this->db->update('supplier');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Supplier Berhasil Di Update!</div>');
            redirect('user/supplier');
        }
    }

    public function hapusSupplier($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('supplier');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Supplier Berhasil Dihapus!</div>');
            redirect('user/supplier');
    }

    public function cari(){

        $name=$_GET['barang'];
        $fieldName=$_GET['fieldName'];


        // $this->db->select('*');
        // $this->db->from('barang');
        // $this->db->like('nama_barang', $name);
        // $query = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('stok_akhir');
        $this->db->join('barang', 'barang.kode_barang = stok_akhir.kode_barang');
        $this->db->like('nama_barang', $name);
        // $this->db->where('barang_keluar.nomor_transaksi', $nomor_transaksi);
        $query = $this->db->get()->result_array();
        
        echo json_encode($query);
    }

    public function cariJasa(){

        $name=$_GET['kirim_by'];
        $fieldName=$_GET['fieldName'];


        $this->db->select('*');
        $this->db->from('jasa_kirim');
        $this->db->like('nama_jasa', $name);
        $query = $this->db->get()->result_array();
        echo json_encode($query);
    }

    public function cariSupplier(){

        $name=$_GET['supplier'];
        $fieldName=$_GET['fieldName'];


        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->like('nama_supplier', $name);
        $query = $this->db->get()->result_array();
        echo json_encode($query);
    }

    // LAPORAN

    public function laporan()
    {
        $data['title'] = 'Menu Laporan';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function print()
    {
        $tgl_dari = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $lap = $this->input->post('lap');

        $data['tgl_dari'] = date('d F Y', strtotime($this->input->post('tgl_dari')));
        $data['tgl_sampai'] = date('d F Y', strtotime($this->input->post('tgl_sampai')));
        $data['lap'] = $this->input->post('lap');

            // CEK JIKA PILIHAN LAPORANNYA BARANG MASUK
            if($lap == 'Barang Masuk'){

                $tgl_dari = $this->input->post('tgl_dari');
                $tgl_sampai = $this->input->post('tgl_sampai');

                $d = date('d F Y', strtotime($tgl_dari));
                $s = date('d F Y', strtotime($tgl_sampai));

                $mpdf = new \Mpdf\Mpdf();

                // AMBIL DATA TRANSAKSI BARANG MASUK SESUAI TGL
                $this->db->select('*');
                $this->db->from('barang_masuk');
                $this->db->join('barang', 'barang.kode_barang = barang_masuk.kode_barang');
                $this->db->where('barang_masuk.tgl_transaksi >=', $tgl_dari); 
                $this->db->where('barang_masuk.tgl_transaksi <=', $tgl_sampai); 
                $datab = $this->db->get()->result_array();

                $this->db->select_sum('qty');
                $this->db->from('barang_masuk');
                // $this->db->where('tipe', 'masuk'); 
                $this->db->where('tgl_transaksi >=', $tgl_dari); 
                $this->db->where('tgl_transaksi <=', $tgl_sampai); 
                $sum = $this->db->get()->row_array();

                $data = $this->load->view('laporan/bprint', ['data' => $datab, 'tgl_dari' => $d, 'tgl_sampai' => $s, 'lap' => $lap, 'total' => $sum], TRUE);
                $mpdf->WriteHTML($data);
                $mpdf->Output();    

                // CEK JIKA PILIHAN LAPORANNYA BARANG KELUAR
            } else if($lap == 'Barang Keluar'){

                $tgl_dari = $this->input->post('tgl_dari');
                $tgl_sampai = $this->input->post('tgl_sampai');

                $d = date('d F Y', strtotime($tgl_dari));
                $s = date('d F Y', strtotime($tgl_sampai));

                $mpdf = new \Mpdf\Mpdf();

                $this->db->select('*');
                $this->db->from('barang_keluar');
                $this->db->join('barang', 'barang.kode_barang = barang_keluar.kode_barang');
                // $this->db->where('mutasi.tipe', 'keluar'); 
                $this->db->where('barang_keluar.tgl_keluar >=', $tgl_dari); 
                $this->db->where('barang_keluar.tgl_keluar <=', $tgl_sampai); 
                $datab = $this->db->get()->result_array();

                $this->db->select_sum('qty');
                $this->db->from('barang_keluar');
                // $this->db->where('tipe', 'keluar'); 
                $this->db->where('tgl_keluar >=', $tgl_dari); 
                $this->db->where('tgl_keluar <=', $tgl_sampai); 
                $sum = $this->db->get()->row_array();

                $data = $this->load->view('laporan/kprint', ['data' => $datab, 'tgl_dari' => $d, 'tgl_sampai' => $s, 'lap' => $lap, 'total' => $sum], TRUE);
                $mpdf->WriteHTML($data);
                $mpdf->Output();  

            }
           

    }

    public function pengiriman()
    {
        $data['title'] = 'Jasa Pengiriman';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $data['pengiriman'] = $this->db->get('jasa_kirim')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/pengiriman', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tambahJasa() 
    {

        $this->form_validation->set_rules('nama_jasa', 'Nama_jasa', 'required|trim');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Supplier';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/pengiriman', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nama_jasa' => htmlspecialchars(strtoupper($this->input->post('nama_jasa', true))),
            ];

            // var_dump($data);
            $this->db->insert('jasa_kirim', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Berhasil Ditambah!</div>');
            redirect('user/pengiriman');
        }
    }

    public function editJasa($id)
    {
        $data['title'] = 'Jasa Pengiriman';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('nama_jasa', 'Nama_jasa', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/pengiriman', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_jasa = $this->input->post('nama_jasa');


            // var_dump($id,$kode_barang,$nama_barang,$supplier,$alamat,$tgl_keluar);
            $this->db->set(['nama_jasa' => strtoupper($nama_jasa)]);
            $this->db->where('id', $id);
            $this->db->update('jasa_kirim');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jasa Berhasil Di Update!</div>');
            redirect('user/pengiriman');
        }
    }

    public function hapusJasa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jasa_kirim');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jasa Berhasil Dihapus!</div>');
            redirect('user/pengiriman');
    }
    
}
 