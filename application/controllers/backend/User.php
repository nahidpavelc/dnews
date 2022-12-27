<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

  function __construct()
  {

    parent::__construct();

    $this->lang->load('content', $_SESSION['lang']);

    if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
      redirect('login', 'refresh');
    }
    if ($_SESSION['userType'] != 'user')
      redirect('login', 'refresh');

    $this->load->model('UserModel');
    $this->load->library("pagination");
    $this->load->helper("url");
    $this->load->helper("text");
    date_default_timezone_set("Asia/Dhaka");
  }

  public function index()
  {


    $user_id = $this->session->userdata('userid');

    $data['title']      = 'User Panel • HRSOFTBD';
    $data['page']       = 'backEnd/user/user_dashboard';
    $data['activeMenu'] = 'dashboard_view';

    $this->load->view('backEnd/master_page', $data);
  }

  public function image_size_fix($filename, $width = 600, $height = 400, $destination = '')
  {

    // Content type
    // header('Content-Type: image/jpeg');
    // Get new dimensions
    list($width_orig, $height_orig) = getimagesize($filename);

    // Output 20 May, 2018 updated below part
    if ($destination == '' || $destination == null)
      $destination = $filename;

    $extention = pathinfo($destination, PATHINFO_EXTENSION);
    if ($extention != "png" && $extention != "PNG" && $extention != "JPEG" && $extention != "jpeg" && $extention != "jpg" && $extention != "JPG") {

      return true;
    }
    // Resample
    $image_p = imagecreatetruecolor($width, $height);
    $image   = imagecreatefromstring(file_get_contents($filename));
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);



    if ($extention == "png" || $extention == "PNG") {
      imagepng($image_p, $destination, 9);
    } else if ($extention == "jpg" || $extention == "JPG" || $extention == "jpeg" || $extention == "JPEG") {
      imagejpeg($image_p, $destination, 70);
    } else {
      imagepng($image_p, $destination);
    }
    return true;
  }

  public function get_division()
  {

    $result = $this->db->select('id, name')->get('tbl_divission')->result();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }

  public function get_zilla_from_division($division_id = 1)
  {

    $result = $this->db->select('id, name')->where('divission_id', $division_id)->get('tbl_zilla')->result();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }

  public function get_upozilla_from_division_zilla($zilla_id = 1)
  {

    $result = $this->db->select('id, name')->where('zilla_id', $zilla_id)->get('tbl_upozilla')->result();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }

  public function download_file($file_name = '', $fullpath = '')
  {

    // echo $file_name; exit();
    $filePath = $file_name;

    if ($file_name == 'full' && ($fullpath != '' || $fullpath != null)) $filePath = $fullpath;

    if ($_GET['file_path']) $filePath = $_GET['file_path'];
    // echo $filePath; exit();
    if (file_exists($filePath)) {
      $fileName = basename($filePath);
      $fileSize = filesize($filePath);

      // Output headers.
      header("Cache-Control: private");
      header("Content-Type: application/stream");
      header("Content-Length: " . $fileSize);
      header("Content-Disposition: attachment; filename=" . $fileName);

      // Output file.
      readfile($filePath);
      exit();
    } else {
      die('The provided file path is not valid.');
    }
  }

  public function profile($param1 = '')
  {

    $user_id            = $this->session->userdata('userid');
    $data['user_info']  = $this->UserModel->get_user($user_id);


    $myzilla_id         = $data['user_info']->zilla_id;
    $mydivision_id      = $data['user_info']->division_id;

    $data['divissions'] = $this->db->get('tbl_divission')->result();

    $data['distrcts']   = $this->db->get_where('tbl_zilla', array('divission_id' => $mydivision_id))->result();
    $data['upozilla']   = $this->db->get_where('tbl_upozilla', array('zilla_id'  => $myzilla_id))->result();

    if ($param1 == 'update_photo') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        //exta work
        $path_parts               = pathinfo($_FILES["photo"]['name']);
        $newfile_name             = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                      = date("YmdHis", time());
        $config['file_name']      = $newfile_name . '_' . $dir;
        $config['remove_spaces']  = TRUE;
        //exta work
        $config['upload_path']    = 'assets/userPhoto/';
        $config['max_size']       = '20000'; //  less than 20 MB
        $config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {

          // case - failure
          $upload_error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', "Failed to update image.");
        } else {

          $upload                 = $this->upload->data();
          $newphotoadd['photo']   = $config['upload_path'] . $upload['file_name'];

          $old_photo              = $this->db->where('id', $user_id)->get('user')->row()->photo;

          if (file_exists($old_photo)) unlink($old_photo);

          $this->image_size_fix($newphotoadd['photo'], 200, 200);

          $this->db->where('id', $user_id)->update('user', $newphotoadd);

          $this->session->set_userdata('userPhoto', $newphotoadd['photo']);
          $this->session->set_flashdata('message', 'User Photo Updated Successfully!');

          redirect('user/profile', 'refresh');
        }
      }
    } else if ($param1 == 'update_pass') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $old_pass    = sha1($this->input->post('old_pass', true));
        $new_pass    = sha1($this->input->post('new_pass', true));
        $user_id     = $this->session->userdata('userid');

        $get_user    = $this->db->get_where('user', array('id' => $user_id, 'password' => $old_pass));
        $user_exist  = $get_user->row();

        if ($user_exist) {

          $this->db->where('id', $user_id)
            ->update('user', array('password' => $new_pass));
          $this->session->set_flashdata('message', 'Password Updated Successfully');
          redirect('user/profile', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Password Update Failed');
          redirect('user/profile', 'refresh');
        }
      }
    } else if ($param1 == 'update_info') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_data['firstname']   = $this->input->post('firstname', true);
        $update_data['lastname']    = $this->input->post('lastname', true);
        $update_data['roadHouse']   = $this->input->post('roadHouse', true);
        $update_data['address']     = $this->input->post('address', true);


        $db_email     = $this->db->where('id!=', $user_id)->where('email', $this->input->post('email', true))->get('user')->num_rows();
        $db_username  = $this->db->where('id!=', $user_id)->where('username', $this->input->post('username', true))->get('user')->num_rows();


        if ($db_username == 0) {

          $update_data['username']    = $this->input->post('username', true);
        }
        if ($db_email == 0) {

          $update_data['email']       = $this->input->post('email', true);
        }


        if ($this->UserModel->update_pro_info($update_data, $user_id)) {

          $this->session->set_userdata('username_first', $update_data['firstname']);
          $this->session->set_userdata('username_last', $update_data['lastname']);
          $this->session->set_userdata('username', $update_data['username']);

          $this->session->set_flashdata('message', 'Information Updated Successfully!');
          redirect('user/profile', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Information Update Failed!');
          redirect('user/profile', 'refresh');
        }
      }
    }

    $data['title']      = 'Profile user Panel • HRSOFTBD News Portal user Panel';
    $data['activeMenu'] = 'Profile';
    $data['page']       = 'backEnd/user/profile';

    $this->load->view('backEnd/master_page', $data);
  }

  // Photo Album
  public function photo_album($param1 = 'add', $param2 = '', $param3 = '')
  {
    if ($param1 = 'add') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $insert_photo_album['album_title']      = $this->input->post('album_title', true);
        $insert_photo_album['priority']         = $this->input->post('priority', true);
        $insert_photo_album['insert_by']        = $_SESSION['userid'];
        $insert_photo_album['insert_time']      = date('Y-m-d H:i:s');

        $photo_album_add = $this->db->insert('tbl_photo_album', $insert_photo_album);
        if ($photo_album_add) {
          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('user/photo_album', 'refresh');
        } else {
          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('user/photo_album', 'refresh');
        }
      }
    } else if ($param1   == 'edit'   && $param2 > 0) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $update_photo_album['album_title']      = $this->input->post('album_title', true);
        $update_photo_album['priority']         = $this->input->post('priority', true);
        $update_photo_album['inset_by']         = $_SESSION['userid'];
        $update_photo_album['inset_time']       = date('y-m-d H:i:s');

        if ($this->UserModel->photo_album_update($update_photo_album, $param2)) {
          $this->session->set_flashdata('message', "Data Update Successfully");
          redirect('admin/admin-album', 'refresh');
        } else {
          $this->session->set_flashdata('message', "Data Update Failed");
          redirect('admin/photo_album', 'refresh');
        }
      }

      $data['photo_album_info'] = $this->db->get_where('tbl_photo_album', array('id' => $param2));

      if ($data['photo_album_info']->num_rows() > 0) {
        $data['photo_album_info'] = $data['photo_album_info']->row();
        $data['photo_album_id'] = $param2;
      } else {
        $this->session->set_flashdata('message', "Wrong Attempt!");
        redirect('user/photo-album', 'refresh');
      }
    } elseif ($param1   == 'delete' && $param2 > 0) {

      if ($this->UserModel->delete_photo_album($param2)) {
        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('user/photo_album', 'refresh');
      } else {
        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('user/photo_album', 'refresh');
      }
    }

    $data['title']      = 'Photo Album';
    $data['activeMenu'] = 'photo_album';
    $data['page']       = 'backEnd/user/photo_album';
    $data['photo_album_list'] = $this->db->Where('insert_by', '5')->order_by('priority', 'desc')->get('tbl_photo_album')->result();

    $this->load->view('backEnd/master_page', $data);
  }
  //Photo Gallery
  public function photo_gallery($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_photo_gallery['photo_album_id']   = $this->input->post('photo_album_id', true);
        $insert_photo_gallery['title']            = $this->input->post('title', true);
        $insert_photo_gallery['insert_by']        = $_SESSION['userid'];
        $insert_photo_gallery['insert_time']      = date('Y-m-d H:i:s');

        if (!empty($_FILES['photo_file']['name'])) {

          $path_parts                 = pathinfo($_FILES["photo_file"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/photoGallery/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo_file')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_photo_gallery['photo_file'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_photo_gallery['photo_file'], 400, 400);
          }
        }

        $add_photo_gallery = $this->db->insert('tbl_photo_gallery', $insert_photo_gallery);

        if ($add_photo_gallery) {

          $this->session->set_flashdata('message', 'Data Created Successfully!');
          redirect('user/photo-gallery/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('user/photo-gallery', 'refresh');
        }
      }

      $data['photo_album_list']  = $this->db->where('insert_by', '5')->order_by('id', 'desc')->get('tbl_photo_album')->result();

      $data['title']         = 'Photo Gallery Add';
      $data['page']          = 'backEnd/user/photo_gallery_add';
      $data['activeMenu']    = 'photo_gallery_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_photo_gallery');

      if ($check_table_row->num_rows() > 0) {

        $data['photo_gallery_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_photo_gallery['photo_album_id']    = $this->input->post('photo_album_id', true);
          $update_photo_gallery['title']            = $this->input->post('title', true);

          if (!empty($_FILES['photo_file']['name'])) {

            $path_parts                 = pathinfo($_FILES["photo_file"]['name']);
            $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newfile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/photoGallery/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('photo_file')) {
            } else {

              $upload_c = $this->upload->data();
              $update_photo_gallery['photo_file'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_photo_gallery['photo_file'], 400, 400);
            }
          }


          if ($this->AdminModel->photo_gallery_update($update_photo_gallery, $param2)) {

            $this->session->set_flashdata('message', 'Data Updated Successfully!');
            redirect('user/photo-gallery/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('user/photo-gallery/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('user/photo-gallery/list', 'refresh');
        }
      }

      $data['photo_album_list']  = $this->db->order_by('id', 'desc')->get('tbl_photo_album')->result();

      $data['title']         = 'Photo Gallery Update';
      $data['page']          = 'backEnd/user/photo_gallery_edit';
      $data['activeMenu']    = 'photo_gallery_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("user/photo-gallery/list");
      $config["total_rows"] = $this->db->get('tbl_photo_gallery')->num_rows();
      $config["per_page"] = 10;
      $config["uri_segment"] = 4;

      //custom
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';

      $config['first_link'] = "First";
      $config['last_link'] = "Last";

      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';

      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);

      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

      $data["links"]      = $this->pagination->create_links();

      $data['photo_gallery_list'] = $this->UserModel->get_photo_gallery_list($config["per_page"], $page);



      $data['new_serial'] = $page;
      $data['title']      = 'Photo Gallery List';
      $data['page']       = 'backEnd/user/photo_gallery_list';
      $data['activeMenu'] = 'photo_gallery_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->UserModel->photo_gallery_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('user/photo-gallery/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('user/photo-gallery/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('user/photo-gallery/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }
}
