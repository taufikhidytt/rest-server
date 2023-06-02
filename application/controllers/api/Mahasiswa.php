<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Mahasiswa extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');

    }

    // function ambil data
    public function index_get()
    {
        $id = $this->get('id');

        if($id === null){
            $mahasiswa = $this->mahasiswa->getData();
        }else{
            $mahasiswa = $this->mahasiswa->getData($id);
        }
        
        if($mahasiswa){
            $this->response([
                'status' => true,
                'message' => 'data ok',
                'data' => $mahasiswa,
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'data not found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // function delete data
    public function index_delete()
    {
        $id = $this->delete('id');

        if($id === null){
            $this->response([
                'status' => false,
                'message' => 'provide an id',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            if($this->mahasiswa->deleteMahasiswa($id) > 0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted the resource',
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'data not found',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    // function tambah data
    public function index_post()
    {
        $data = [
            'nim'       => $this->post('nim'),
            'nama'      => $this->post('nama'),
            'email'     => $this->post('email'),
            'jurusan'   => $this->post('jurusan'),
        ];

        if($this->mahasiswa->createMahasiswa($data) > 0 ){
            $this->response([
                'status' => true,
                'message' => 'added a resource',
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed to create new data',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nim'       => $this->put('nim'),
            'nama'      => $this->put('nama'),
            'email'     => $this->put('email'),
            'jurusan'   => $this->put('jurusan'),
        ];

        if($this->mahasiswa->updateMahasiswa($data, $id) > 0 ){
            $this->response([
                'status' => true,
                'id' => $id,
                'message' => 'update a resource',
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed to update data id not found',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}


?>