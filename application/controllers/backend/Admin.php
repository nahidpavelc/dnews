<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

  function __construct()
  {

    parent::__construct();

    $this->lang->load('content', $_SESSION['lang']);

    if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
      redirect('login', 'refresh');
    }
    if ($_SESSION['userType'] != 'admin')
      redirect('login', 'refresh');
    //Model Loading
    $this->load->model('AdminModel');
    $this->load->model('AccountsModel');
    $this->load->library("pagination");
    $this->load->helper("url");
    $this->load->helper("text");

    date_default_timezone_set("Asia/Dhaka");
  }

  public function index()
  {

    $data['title']      = 'Admin Panel • HRSOFTBD News Portal Admin Panel';
    $data['page']       = 'backEnd/dashboard_view';
    $data['activeMenu'] = 'dashboard_view';


    $this->load->view('backEnd/master_page', $data);
  }

  //Theme setting
  public function theme_setting($param1 = '', $param2 = '', $param3 = '')
  {

    $theme_data_temp    = $this->db->get('tbl_backend_theme')->result();
    $data['theme_data'] = array();
    foreach ($theme_data_temp as $value) {
      $data['theme_data'][$value->name]  = $value->value;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $long_title = $this->input->post('long_title', true);
      $this->AdminModel->theme_text_update('long_title', $long_title);

      $short_title = $this->input->post('short_title', true);
      $this->AdminModel->theme_text_update('short_title', $short_title);

      $tagline = $this->input->post('tagline', true);
      $this->AdminModel->theme_text_update('tagline', $tagline);

      $share_title = $this->input->post('share_title', true);
      $this->AdminModel->theme_text_update('share_title', $share_title);

      $share_title = $this->input->post('version', true);
      $this->AdminModel->theme_text_update('version', $share_title);

      $share_title = $this->input->post('organization', true);
      $this->AdminModel->theme_text_update('organization', $share_title);


      if (!empty($_FILES['logo']['name'])) {

        $path_parts                 = pathinfo($_FILES["logo"]['name']);
        $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config_c['file_name']      = $newfile_name . '_' . $dir;
        $config_c['remove_spaces']  = TRUE;
        $config_c['upload_path']    = 'assets/themeLogo/';
        $config_c['max_size']       = '20000'; //  less than 20 MB
        $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config_c);
        $this->upload->initialize($config_c);
        if (!$this->upload->do_upload('logo')) {
        } else {

          $upload_c = $this->upload->data();
          $logo['logo'] = $config_c['upload_path'] . $upload_c['file_name'];
          $this->image_size_fix($logo['logo'], 300, 300);
        }
        $this->AdminModel->theme_text_update('logo', $logo['logo']);
      }



      if (!empty($_FILES['share_banner']['name'])) {

        $path_parts                 = pathinfo($_FILES["share_banner"]['name']);
        $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config['file_name']      = $newfile_name . '_' . $dir;
        $config['remove_spaces']  = TRUE;
        $config['upload_path']    = 'assets/themeBanner/';
        $config['max_size']       = '20000'; //  less than 20 MB
        $config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('share_banner')) {
        } else {

          $upload = $this->upload->data();
          $share_banner['share_banner'] = $config['upload_path'] . $upload['file_name'];
          $this->image_size_fix($share_banner['share_banner'], 600, 315);
        }
        $this->AdminModel->theme_text_update('share_banner', $share_banner['share_banner']);
      }



      $this->session->set_flashdata('message', 'Theme Info Updated Successfully!');
      redirect('admin/theme-setting', 'refresh');
    }

    $data['page']       = 'backEnd/admin/theme_setting';
    $data['activeMenu'] = 'theme_setting';

    $this->load->view('backEnd/master_page', $data);
  }

  //Add User
  public function add_user($param1 = '')
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $saveData['firstname'] = $this->input->post('first_name', true);
      $saveData['lastname']  = $this->input->post('last_name', true);
      $saveData['username']  = $this->input->post('user_name', true);
      $saveData['email']     = $this->input->post('email', true);
      $saveData['phone']     = $this->input->post('phone', true);
      $saveData['password']  = sha1($this->input->post('password', true));
      $saveData['address']   = $this->input->post('address', true);
      $saveData['roadHouse'] = $this->input->post('road_house', true);
      $saveData['userType']  = $this->input->post('user_type', true);
      $saveData['photo']     = 'assets/userPhoto/defaultUser.jpg';

      if (!empty($_FILES['photo']['name'])) {

        $path_parts                 = pathinfo($_FILES["photo"]['name']);
        $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config_c['file_name']      = $newfile_name . '_' . $dir;
        $config_c['remove_spaces']  = TRUE;
        $config_c['upload_path']    = 'assets/userPhoto/';
        $config_c['max_size']       = '20000'; //  less than 20 MB
        $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config_c);
        $this->upload->initialize($config_c);
        if (!$this->upload->do_upload('photo')) {
        } else {

          $upload_c = $this->upload->data();
          $saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
          $this->image_size_fix($saveData['photo'], 400, 400);
        }
      }

      //This will returns as third parameter num_rows, result_array, result
      $username_check = $this->AdminModel->isRowExist('user', array('username' => $saveData['username']), 'num_rows');
      $email_check = $this->AdminModel->isRowExist('user', array('email' => $saveData['email']), 'num_rows');

      if ($username_check > 0 || $email_check > 0) {
        //Invalid message
        $messagePage['page'] = 'backEnd/admin/insertFailed';
        $messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " can not be create.";
        if ($username_check > 0) {

          $messagePage['noteMessage'] .= '<br> Cause this username is already exist.';
        } else if ($email_check > 0) {

          $messagePage['noteMessage'] .= '<br> Cause this email is already exist.';
        }
      } else {
        //success
        $insertId = $this->AdminModel->saveDataInTable('user', $saveData, 'true');

        $messagePage['page'] = 'backEnd/admin/insertSuccessfull';
        $messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " has been created successfully.";

        // Category allocate for users
        if (!empty($this->input->post('selectCategory', true))) {

          foreach ($this->input->post('selectCategory', true) as $cat_value) {

            $this->db->insert('category_user', array('userId' => $insertId, 'categoryId' => $cat_value));
          }
        }
      }
    }

    $messagePage['divissions'] = $this->db->get('tbl_divission')->result_array();
    $messagePage['userType']   = $this->db->get('user_type')->result();

    $messagePage['title']      = 'Add User Admin Panel • HRSOFTBD Admin Panel';
    $messagePage['page']       = 'backEnd/admin/add_user';
    $messagePage['activeMenu'] = 'add_user';


    $this->load->view('backEnd/master_page', $messagePage);
  }
  //Edit User
  public function edit_user($param1 = '')
  {
    // Update using post method 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if (strlen($this->input->post('password', true)) > 3) {
        $saveData['password']  = sha1($this->input->post('password', true));
      }

      $saveData['firstname'] = $this->input->post('first_name', true);
      $saveData['lastname']  = $this->input->post('last_name', true);
      $saveData['email']     = $this->input->post('email', true);
      $saveData['phone']     = $this->input->post('phone', true);
      $saveData['address']   = $this->input->post('address', true);
      $saveData['roadHouse'] = $this->input->post('road_house', true);
      $saveData['userType']  = $this->input->post('user_type', true);
      $user_id               = $param1;

      if (!empty($_FILES['photo']['name'])) {

        $path_parts                 = pathinfo($_FILES["photo"]['name']);
        $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
        $dir                        = date("YmdHis", time());
        $config_c['file_name']      = $newfile_name . '_' . $dir;
        $config_c['remove_spaces']  = TRUE;
        $config_c['upload_path']    = 'assets/userPhoto/';
        $config_c['max_size']       = '20000'; //  less than 20 MB
        $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

        $this->load->library('upload', $config_c);
        $this->upload->initialize($config_c);
        if (!$this->upload->do_upload('photo')) {
        } else {

          $upload_c = $this->upload->data();
          $saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
          $this->image_size_fix($saveData['photo'], 400, 400);
        }
      }

      if (isset($saveData['photo']) && file_exists($saveData['photo'])) {

        $result = $this->db->select('photo')->from('user')->where('id', $user_id)->get()->row()->photo;

        if (file_exists($result)) {
          unlink($result);
        }
      }

      $this->db->where('id', $user_id);
      $this->db->update('user', $saveData);

      $data['page']        = 'backEnd/admin/insertSuccessfull';
      $data['noteMessage'] = "<hr> Data has been Updated successfully.";
    } else if ($this->AdminModel->isRowExist('user', array('id' => $param1), 'num_rows') > 0) {

      $data['userDetails']   = $this->AdminModel->isRowExist('user', array('id' => $param1), 'result_array');

      $myupozilla_id         = $this->db->get_where('tbl_upozilla', array("id" => $data['userDetails'][0]['address']))->row();

      $data['myzilla_id']    = $myupozilla_id->zilla_id;
      $data['mydivision_id'] = $myupozilla_id->division_id;

      $data['divissions']    = $this->db->get('tbl_divission')->result();

      $data['distrcts']      = $this->db->get_where('tbl_zilla', array('divission_id' => $data['mydivision_id']))->result();
      $data['upozilla']      = $this->db->get_where('tbl_upozilla', array('zilla_id' => $data['myzilla_id']))->result();

      $data['userType'] = $this->db->get('user_type')->result_array();

      $data['user_id']  = $param1;
      $data['page']     = 'backEnd/admin/edit_user';
    } else {

      $data['page']        = 'errors/invalidInformationPage';
      $data['noteMessage'] = $this->lang->line('wrong_info_search');
    }

    $data['user_type']   = $this->db->select('id, value, name')->get('user_type')->result();


    $data['title']      = 'Users List Admin Panel • HRSOFTBD Admin Panel';
    $data['activeMenu'] = 'user_list';
    $this->load->view('backEnd/master_page', $data);
  }
  //Suspend User
  public function suspend_user($id, $setvalue)
  {
    $this->db->where('id', $id);
    $this->db->update('user', array('status' => $setvalue));
    $this->session->set_flashdata('message', 'Data Saved Successfully.');

    redirect('admin/user_list', 'refresh');
  }
  //Delete User
  public function delete_user($id)
  {
    $old_image_url = $this->db->where('id', $id)->get('user')->row();
    $this->db->where('id', $id)->delete('user');
    if (isset($old_image_url->photo)) {
      unlink($old_image_url->photo);
    }

    $this->session->set_flashdata('message', 'Data Deleted.');
    redirect('admin/user_list', 'refresh');
  }
  //User List
  public function user_list()
  {
    $this->db->where('userType !=', 'admin');
    $data['myUsers']    = $this->db->select('user.id,user.firstname,user.email,user.phone,user.lastname,user.status,
                                                    user.photo,user.userType')

      ->get('user')->result_array();

    $data['title']      = 'Users List • HRSOFTBD Admin Panel';
    $data['page']       = 'backEnd/admin/user_list';
    $data['activeMenu'] = 'user_list';

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

    $this->load->helper('download');

    $filePath = $file_name;

    if ($file_name == 'full' && ($fullpath != '' || $fullpath != null)) $filePath = $fullpath;

    if ($_GET['file_path']) $filePath = $_GET['file_path'];

    if (file_exists($filePath)) {

      force_download($filePath, NULL);
    } else {

      die('The provided file path is not valid.');
    }
  }

  public function profile($param1 = '')
  {

    $user_id            = $this->session->userdata('userid');
    $data['user_info']  = $this->AdminModel->get_user($user_id);


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

          redirect('admin/profile', 'refresh');
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
          redirect('admin/profile', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Password Update Failed');
          redirect('admin/profile', 'refresh');
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


        $current_password = sha1($this->input->post('password', true));

        $db_password      = $data['user_info']->password;

        if ($current_password == $db_password) {

          if ($this->AdminModel->update_pro_info($update_data, $user_id)) {

            $this->session->set_userdata('username_first', $update_data['firstname']);
            $this->session->set_userdata('username_last', $update_data['lastname']);
            $this->session->set_userdata('username', $update_data['username']);

            $this->session->set_flashdata('message', 'Information Updated Successfully!');
            redirect('admin/profile', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Information Update Failed!');
            redirect('admin/profile', 'refresh');
          }
        } else {

          $this->session->set_flashdata('message', 'Current Password Does Not Match!');
          redirect('admin/profile', 'refresh');
        }
      }
    }

    $data['title']      = 'Profile Admin Panel • HRSOFTBD News Portal Admin Panel';
    $data['activeMenu'] = 'Profile';
    $data['page']       = 'backEnd/admin/profile';

    $this->load->view('backEnd/master_page', $data);
  }

  //video album
  public function video_album($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_video_album['album_title']      = $this->input->post('album_title', true);
        $insert_video_album['priority']         = $this->input->post('priority', true);
        $insert_video_album['insert_by']      = $_SESSION['userid'];
        $insert_video_album['insert_time']         = date('Y-m-d H:i:s');


        $video_album_add = $this->db->insert('tbl_video_album', $insert_video_album);

        if ($video_album_add) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/video-album/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/video-album/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_video_album['album_title']      = $this->input->post('album_title', true);
        $update_video_album['priority']         = $this->input->post('priority', true);


        if ($this->AdminModel->video_album_update($update_video_album, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/video-album', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/video-album', 'refresh');
        }
      }

      $data['video_album_info'] = $this->db->get_where('tbl_video_album', array('id' => $param2));

      if ($data['video_album_info']->num_rows() > 0) {

        $data['video_album_info']    = $data['video_album_info']->row();
        $data['video_album_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/video-album', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_video_album($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/video-album', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/video-album', 'refresh');
      }
    }

    $data['title']      = 'Video Album';
    $data['activeMenu'] = 'video_album';
    $data['page']       = 'backEnd/admin/video_album';
    $data['video_album_list'] = $this->db->order_by('priority', 'desc')->get('tbl_video_album')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //video gallery
  public function video_gallery($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_video_gallery['video_album_id']         = $this->input->post('video_album_id', true);
        $insert_video_gallery['youtube_video_link']     = $this->input->post('youtube_video_link', true);
        $insert_video_gallery['title']                  = $this->input->post('title', true);
        $insert_video_gallery['insert_by']             = $_SESSION['userid'];
        $insert_video_gallery['insert_time']             = date('Y-m-d H:i:s');

        $add_video_gallery = $this->db->insert('tbl_video_gallery', $insert_video_gallery);

        if ($add_video_gallery) {

          $this->session->set_flashdata('message', 'Data Created Successfully!');
          redirect('admin/video-gallery/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('admin/video-gallery', 'refresh');
        }
      }

      $data['video_album_list']  = $this->db->order_by('priority', 'desc')->get('tbl_video_album')->result();

      $data['title']         = 'Video Gallery Add';
      $data['page']          = 'backEnd/admin/video_gallery_add';
      $data['activeMenu']    = 'video_gallery_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_video_gallery');

      if ($check_table_row->num_rows() > 0) {

        $data['video_gallery_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_video_gallery['video_album_id']         = $this->input->post('video_album_id', true);
          $update_video_gallery['youtube_video_link']     = $this->input->post('youtube_video_link', true);
          $update_video_gallery['title']                  = $this->input->post('title', true);




          if ($this->AdminModel->get_video_gallery_update($update_video_gallery, $param2)) {

            $this->session->set_flashdata('message', 'Data Updated Successfully!');
            redirect('admin/video-gallery/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('admin/video-gallery/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('admin/video-gallery/list', 'refresh');
        }
      }

      $data['video_album_list']  = $this->db->order_by('priority', 'desc')->get('tbl_video_album')->result();

      $data['title']         = 'Video Gallery Update';
      $data['page']          = 'backEnd/admin/video_gallery_edit';
      $data['activeMenu']    = 'video_gallery_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/video-gallery/list");
      $config["total_rows"] = $this->db->get(' tbl_video_gallery')->num_rows();
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

      $data["links"] = $this->pagination->create_links();

      $data['video_gallery_list'] = $this->AdminModel->get_video_gallery_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Video Gallery List';
      $data['page']       = 'backEnd/admin/video_gallery_list';
      $data['activeMenu'] = 'video_gallery_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->video_gallery_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('admin/video-gallery/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('admin/video-gallery/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('admin/video-gallery/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //Photo Album
  public function photo_album($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_photo_album['album_title']      = $this->input->post('album_title', true);
        $insert_photo_album['priority']         = $this->input->post('priority', true);
        $insert_photo_album['insert_by']        = $_SESSION['userid'];
        $insert_photo_album['insert_time']     = date('Y-m-d H:i:s');

        $video_album_add = $this->db->insert('tbl_photo_album', $insert_photo_album);

        if ($video_album_add) {
          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/photo-album/', 'refresh');
        } else {
          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/photo-album/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_photo_album['album_title']      = $this->input->post('album_title', true);
        $update_photo_album['priority']         = $this->input->post('priority', true);


        if ($this->AdminModel->photo_album_update($update_photo_album, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/photo-album', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/photo-album', 'refresh');
        }
      }

      $data['photo_album_info'] = $this->db->get_where('tbl_photo_album', array('id' => $param2));

      if ($data['photo_album_info']->num_rows() > 0) {

        $data['photo_album_info']    = $data['photo_album_info']->row();
        $data['photo_album_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/photo-album', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_photo_album($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/photo-album', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/photo-album', 'refresh');
      }
    }

    $data['title']      = 'photo Album';
    $data['activeMenu'] = 'photo_album';
    $data['page']       = 'backEnd/admin/photo_album';
    $data['photo_album_list'] = $this->db->order_by('priority', 'desc')->get('tbl_photo_album')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Photo Gallery
  public function photo_gallery($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_photo_gallery['photo_album_id']      = $this->input->post('photo_album_id', true);
        $insert_photo_gallery['title']            = $this->input->post('title', true);
        $insert_photo_gallery['insert_by']          = $_SESSION['userid'];
        $insert_photo_gallery['insert_time']          = date('Y-m-d H:i:s');

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
          redirect('admin/photo-gallery/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('admin/photo-gallery', 'refresh');
        }
      }

      $data['photo_album_list']  = $this->db->order_by('id', 'desc')->get('tbl_photo_album')->result();

      $data['title']         = 'Photo Gallery Add';
      $data['page']          = 'backEnd/admin/photo_gallery_add';
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
            redirect('admin/photo-gallery/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('admin/photo-gallery/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('admin/photo-gallery/list', 'refresh');
        }
      }

      $data['photo_album_list']  = $this->db->order_by('id', 'desc')->get('tbl_photo_album')->result();

      $data['title']         = 'Photo Gallery Update';
      $data['page']          = 'backEnd/admin/photo_gallery_edit';
      $data['activeMenu']    = 'photo_gallery_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/photo-gallery/list");
      $config["total_rows"] = $this->db->get(' tbl_photo_gallery')->num_rows();
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

      $data["links"] = $this->pagination->create_links();

      $data['photo_gallery_list'] = $this->AdminModel->get_photo_gallery_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Photo Gallery List';
      $data['page']       = 'backEnd/admin/photo_gallery_list';
      $data['activeMenu'] = 'photo_gallery_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->photo_gallery_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('admin/photo-gallery/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('admin/photo-gallery/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('admin/photo-gallery/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  public function mail_setting()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      foreach ($this->input->post('mail_setting_id', true) as $key => $id_value) {

        $id    = $id_value;
        $value = $this->input->post('value', true)[$key];

        $this->db->where('id', $id)->update('tbl_mail_send_setting', array('value' => $value));
      }

      $this->session->set_flashdata('message', 'Mail Send Setting Updated Successfully!');
      redirect('admin/mail_setting', 'refresh');
    }

    $data['title']             = 'Mail Setting';
    $data['activeMenu']        = 'mail_setting';
    $data['page']              = 'backEnd/admin/mail_setting';
    $data['mail_setting_info'] = $this->db->get('tbl_mail_send_setting')->result();
    $this->load->view('backEnd/master_page', $data);
  }

  //News
  public function news($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($this->input->post('news_date', true)) {

          $insert_news['news_date']      = date('Y-m-d', strtotime($this->input->post('news_date', true)));
        }
        $insert_news['title']            = $this->input->post('title', true);
        $insert_news['subtitle']            = $this->input->post('subtitle', true);
        $insert_news['is_published']        = $this->input->post('is_published', true);
        $insert_news['approve_status']       = $this->input->post('approve_status', true);
        $insert_news['news_body']            = $this->input->post('news_body', true);
        $insert_news['insert_by']          = $_SESSION['userid'];
        $insert_news['insert_time']          = date('Y-m-d H:i:s');

        $insert_news['tags']   =    "";

        foreach ($this->input->post('tags', true) as $key => $input_field_single) {
          if (strlen($input_field_single) > 1) {
            if ($key > 0) $insert_news['tags'] .=  "**";
            $insert_news['tags'] .= $input_field_single;
          }
        }


        if (!empty($_FILES['thumb_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["thumb_photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/newsPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('thumb_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_news['thumb_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_news['thumb_photo'], 400, 400);
          }
        }



        $add_news = $this->db->insert('tbl_news', $insert_news);

        if ($add_news) {

          $this->session->set_flashdata('message', 'Data Created Successfully!');
          redirect('admin/news/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('admin/news', 'refresh');
        }
      }


      $data['title']         = 'News Add';
      $data['page']          = 'backEnd/admin/news_add';
      $data['activeMenu']    = 'news_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_news');

      if ($check_table_row->num_rows() > 0) {

        $data['news_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          if ($this->input->post('news_date', true)) {

            $update_news['news_date']      = date('Y-m-d', strtotime($this->input->post('news_date', true)));
          }
          $update_news['title']            = $this->input->post('title', true);
          $update_news['subtitle']            = $this->input->post('subtitle', true);
          $update_news['is_published']        = $this->input->post('is_published', true);
          $update_news['approve_status']       = $this->input->post('approve_status', true);
          $update_news['news_body']            = $this->input->post('news_body', true);

          $update_news['tags']   = "";

          foreach ($this->input->post('tags', true) as $key => $single_tags) {
            if (strlen($single_tags) > 1) {
              if ($key > 0) $update_news['tags'] .= "**";
              $update_news['tags']  .= $single_tags;
            }
          }

          if (!empty($_FILES['thumb_photo']['name'])) {

            $path_parts                 = pathinfo($_FILES["thumb_photo"]['name']);
            $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newfile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/newsPhoto/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('thumb_photo')) {
            } else {

              $upload_c = $this->upload->data();
              $update_news['thumb_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_news['thumb_photo'], 400, 400);
            }
          }


          if ($this->AdminModel->news_update($update_news, $param2)) {

            $this->session->set_flashdata('message', 'Data Updated Successfully!');
            redirect('admin/news/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('admin/news/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('admin/news/list', 'refresh');
        }
      }


      $data['title']         = 'News Update';
      $data['page']          = 'backEnd/admin/news_edit';
      $data['activeMenu']    = 'news_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/news/list");
      $config["total_rows"] = $this->db->get(' tbl_news')->num_rows();
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

      $data["links"] = $this->pagination->create_links();

      $data['news_list'] = $this->AdminModel->get_news_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'News List';
      $data['page']       = 'backEnd/admin/news_list';
      $data['activeMenu'] = 'news_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->news_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('admin/news/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('admin/news/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('admin/news/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //News Category
  public function news_category($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_news_category['category_name']      = $this->input->post('category_name', true);
        $insert_news_category['insert_by']          = $_SESSION['userid'];
        $insert_news_category['insert_time']         = date('Y-m-d H:i:s');

        if (!empty($_FILES['category_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["category_photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/newsCategory/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('category_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_news_category['category_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_news_category['category_photo'], 400, 400);
          }
        }


        $news_category_add = $this->db->insert('tbl_news_category', $insert_news_category);

        if ($news_category_add) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/news-category/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/news-category/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_news_category['category_name']      = $this->input->post('category_name', true);

        if (!empty($_FILES['category_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["category_photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/newsCategory/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('category_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $update_news_category['category_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($update_news_category['category_photo'], 400, 400);
          }
        }


        if ($this->AdminModel->news_category_update($update_news_category, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/news-category', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/news-category', 'refresh');
        }
      }

      $data['news_category_info'] = $this->db->get_where('tbl_news_category', array('id' => $param2));

      if ($data['news_category_info']->num_rows() > 0) {

        $data['news_category_info']    = $data['news_category_info']->row();
        $data['news_category_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/news-category', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_news_category($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/news-category', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/news-category', 'refresh');
      }
    }

    $data['title']      = 'News Category';
    $data['activeMenu'] = 'news_category';
    $data['page']       = 'backEnd/admin/news_category';
    $data['news_category_list'] = $this->db->order_by('id', 'desc')->get('tbl_news_category')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //News Sub Category
  public function news_sub_category($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_news_sub_category['category_id']        = $this->input->post('category_id', true);
        $insert_news_sub_category['sub_category_name']  = $this->input->post('sub_category_name', true);
        $insert_news_sub_category['insert_by']          = $_SESSION['userid'];
        $insert_news_sub_category['insert_time']         = date('Y-m-d H:i:s');

        if (!empty($_FILES['category_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["category_photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/newsSubCategory/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('category_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_news_sub_category['category_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_news_sub_category['category_photo'], 400, 400);
          }
        }


        $news_sub_category_add = $this->db->insert('tbl_news_sub_category', $insert_news_sub_category);

        if ($news_sub_category_add) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/news-sub-category/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/news-sub-category/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_news_sub_category['category_id']        = $this->input->post('category_id', true);
        $update_news_sub_category['sub_category_name']  = $this->input->post('sub_category_name', true);

        if (!empty($_FILES['category_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["category_photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/newsSubCategory/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('category_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $update_news_sub_category['category_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($update_news_sub_category['category_photo'], 400, 400);
          }
        }


        if ($this->AdminModel->news_sub_category_update($update_news_sub_category, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/news-sub-category', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/news-sub-category', 'refresh');
        }
      }

      $data['news_sub_category_info'] = $this->db->get_where('tbl_news_sub_category', array('id' => $param2));

      if ($data['news_sub_category_info']->num_rows() > 0) {

        $data['news_sub_category_info']    = $data['news_sub_category_info']->row();
        $data['news_sub_category_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/news-sub-category', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_news_sub_category($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/news-sub-category', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/news-sub-category', 'refresh');
      }
    }

    $data['news_category_list']  = $this->db->order_by('id', 'desc')->get('tbl_news_category')->result();
    $data['title']      = 'News Sub Category';
    $data['activeMenu'] = 'news_sub_category';
    $data['page']       = 'backEnd/admin/news_sub_category';
    $data['news_sub_category_list'] = $this->db->select('tbl_news_sub_category.id,tbl_news_sub_category.sub_category_name,
                                                             tbl_news_sub_category.sub_category_name,tbl_news_sub_category.category_photo as sub_category_photo,
                                                             tbl_news_category.category_name')
      ->join('tbl_news_category', 'tbl_news_category.id = tbl_news_sub_category.category_id', 'left')
      ->order_by('id', 'desc')->get('tbl_news_sub_category')->result();


    $this->load->view('backEnd/master_page', $data);
  }

  //News Photo
  public function news_photos($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_news_photo['news_id']         = $this->input->post('news_id', true);
        $insert_news_photo['insert_by']       = $_SESSION['userid'];
        $insert_news_photo['insert_time']     = date('Y-m-d H:i:s');

        if (!empty($_FILES['news_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["news_photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/newsPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('news_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_news_photo['news_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_news_photo['news_photo'], 400, 400);
          }
        }


        $news_photo_add = $this->db->insert('tbl_news_photos', $insert_news_photo);

        if ($news_photo_add) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/news-photos/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/news-photos/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_news_photo['news_id']         = $this->input->post('news_id', true);

        if (!empty($_FILES['news_photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["news_photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/newsPhoto/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('news_photo')) {
          } else {

            $upload_c = $this->upload->data();
            $update_news_photo['news_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($update_news_photo['news_photo'], 400, 400);
          }
        }


        if ($this->AdminModel->news_photo_update($update_news_photo, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/news-photos', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/news-photos', 'refresh');
        }
      }

      $data['news_photo_info'] = $this->db->get_where('tbl_news_photos', array('id' => $param2));

      if ($data['news_photo_info']->num_rows() > 0) {

        $data['news_photo_info']    = $data['news_photo_info']->row();
        $data['news_photo_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/news-photos', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_news_photo($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/news-photos', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/news-photos', 'refresh');
      }
    }

    $data['get_news_list']  = $this->db->order_by('id', 'desc')->get('tbl_news')->result();


    $data['title']      = 'News Photo';
    $data['activeMenu'] = 'news_photo';
    $data['page']       = 'backEnd/admin/news_photo';
    $data['news_photo_list'] = $this->db->select('tbl_news_photos.id,tbl_news_photos.news_photo,
                                                            tbl_news.title')
      ->join('tbl_news', 'tbl_news.id = tbl_news_photos.news_id', 'left')
      ->order_by('id', 'desc')
      ->get('tbl_news_photos')
      ->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //News Videos
  public function news_videos($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_news_video['news_id']                   = $this->input->post('news_id', true);
        $insert_news_video['youtube_video_link']        = $this->input->post('youtube_video_link', true);
        $insert_news_video['facebook_video_link']       = $this->input->post('facebook_video_link', true);
        $insert_news_video['insert_by']                 = $_SESSION['userid'];
        $insert_news_video['insert_time']             = date('Y-m-d H:i:s');


        $news_video_add = $this->db->insert('tbl_news_videos', $insert_news_video);

        if ($news_video_add) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/news-videos/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/news-videos/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_news_video['news_id']                   = $this->input->post('news_id', true);
        $update_news_video['youtube_video_link']        = $this->input->post('youtube_video_link', true);
        $update_news_video['facebook_video_link']       = $this->input->post('facebook_video_link', true);


        if ($this->AdminModel->news_videos_update($update_news_video, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/news-videos', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/news-videos', 'refresh');
        }
      }

      $data['news_video_info'] = $this->db->get_where('tbl_news_videos', array('id' => $param2));

      if ($data['news_video_info']->num_rows() > 0) {

        $data['news_video_info']    = $data['news_video_info']->row();
        $data['news_video_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/news-videos', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_news_videos($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/news-videos', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/news-videos', 'refresh');
      }
    }

    $data['get_news_list']  = $this->db->order_by('id', 'desc')->get('tbl_news')->result();


    $data['title']      = 'News Videos';
    $data['activeMenu'] = 'news_videos';
    $data['page']       = 'backEnd/admin/news_videos';
    $data['news_video_list'] = $this->db->select('tbl_news_videos.id,tbl_news_videos.youtube_video_link,tbl_news_videos.facebook_video_link,
                                                            tbl_news.title')
      ->join('tbl_news', 'tbl_news.id = tbl_news_videos.news_id', 'left')
      ->order_by('id', 'desc')
      ->get('tbl_news_videos')
      ->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //News Category Set
  public function news_category_set($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_news_category_set['news_id']                   = $this->input->post('news_id', true);
        $insert_news_category_set['news_category_id']          = $this->input->post('news_category_id', true);
        $insert_news_category_set['news_sub_category_id']      = $this->input->post('news_sub_category_id', true);
        $insert_news_category_set['insert_by']                 = $_SESSION['userid'];
        $insert_news_category_set['insert_time']                = date('Y-m-d H:i:s');


        $news_video_add = $this->db->insert('tbl_news_category_set', $insert_news_category_set);

        if ($news_video_add) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/news-category-set/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/news-category-set/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_news_category_set['news_id']                   = $this->input->post('news_id', true);
        $update_news_category_set['news_category_id']          = $this->input->post('news_category_id', true);
        $update_news_category_set['news_sub_category_id']      = $this->input->post('news_sub_category_id', true);


        if ($this->AdminModel->news_category_set_update($update_news_category_set, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/news-category-set', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/news-category-set', 'refresh');
        }
      }

      $data['news_category_set_info'] = $this->db->get_where('tbl_news_category_set', array('id' => $param2));

      if ($data['news_category_set_info']->num_rows() > 0) {

        $data['news_category_set_info']    = $data['news_category_set_info']->row();
        $data['news_category_set_info_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/news-category-set', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->delete_news_category_set($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/news-category-set', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/news-category-set', 'refresh');
      }
    }

    $data['get_news_list']                  = $this->db->order_by('id', 'desc')->get('tbl_news')->result();
    $data['get_news_category_list']         = $this->db->order_by('id', 'desc')->get('tbl_news_category')->result();
    $data['get_news_sub_category_list']     = $this->db->order_by('id', 'desc')->get('tbl_news_sub_category')->result();


    $data['title']      = 'News Category Set';
    $data['activeMenu'] = 'news_category_set';
    $data['page']       = 'backEnd/admin/news_category_set';
    $data['news_category_set_list'] = $this->db->select('tbl_news_category_set.id,tbl_news.title as news_title,tbl_news_category.category_name,tbl_news_sub_category.sub_category_name')
      ->join('tbl_news', 'tbl_news.id = tbl_news_category_set.news_id', 'left')
      ->join('tbl_news_category', 'tbl_news_category.id = tbl_news_category_set.news_category_id', 'left')
      ->join('tbl_news_sub_category', 'tbl_news_sub_category.id = tbl_news_category_set.news_sub_category_id', 'left')
      ->order_by('id', 'desc')
      ->get('tbl_news_category_set')
      ->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Footer Address 
  public function footer_address($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_footer_address['title']            = $this->input->post('title', true);
        $insert_footer_address['details']        = $this->input->post('details', true);
        $insert_footer_address['priority']        = $this->input->post('priority', true);
        $insert_footer_address['insert_by']          = $_SESSION['userid'];
        $insert_footer_address['insert_time']      = date('Y-m-d H:i:s');


        if (!empty($_FILES['icon']['name'])) {

          $path_parts                 = pathinfo($_FILES["icon"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/footerAddress/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('icon')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_footer_address['icon'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_footer_address['icon'], 400, 400);
          }
        }



        $add_footer_address = $this->db->insert('tbl_footer_address', $insert_footer_address);

        if ($add_footer_address) {

          $this->session->set_flashdata('message', 'Data Created Successfully!');
          redirect('admin/footer-address/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('admin/footer-address', 'refresh');
        }
      }


      $data['title']         = 'Footer Address Add';
      $data['page']          = 'backEnd/admin/footer_address_add';
      $data['activeMenu']    = 'footer_address_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_footer_address');

      if ($check_table_row->num_rows() > 0) {

        $data['footer_address_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_footer_address['title']            = $this->input->post('title', true);
          $update_footer_address['details']        = $this->input->post('details', true);
          $update_footer_address['priority']        = $this->input->post('priority', true);

          if (!empty($_FILES['icon']['name'])) {

            $path_parts                 = pathinfo($_FILES["icon"]['name']);
            $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newfile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/footerAddress/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('icon')) {
            } else {

              $upload_c = $this->upload->data();
              $update_footer_address['icon'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_footer_address['icon'], 400, 400);
            }
          }


          if ($this->AdminModel->footer_address_update($update_footer_address, $param2)) {

            $this->session->set_flashdata('message', 'Data Updated Successfully!');
            redirect('admin/footer-address/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('admin/footer-address/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('admin/footer-address/list', 'refresh');
        }
      }


      $data['title']         = 'Footer Address Update';
      $data['page']          = 'backEnd/admin/footer_address_edit';
      $data['activeMenu']    = 'footer_address_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/footer-address/list");
      $config["total_rows"] = $this->db->get('tbl_footer_address')->num_rows();
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

      $data["links"] = $this->pagination->create_links();

      $data['footer_address_list'] = $this->AdminModel->get_footer_address_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Footer Address List';
      $data['page']       = 'backEnd/admin/footer_address_list';
      $data['activeMenu'] = 'footer_address_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->footer_address_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('admin/footer-address/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('admin/footer-address/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('admin/footer-address/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //footer Authorty 
  public function footer_authorty($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_footer_authorty['title']            = $this->input->post('title', true);
        $insert_footer_authorty['details']        = $this->input->post('details', true);
        $insert_footer_authorty['priority']        = $this->input->post('priority', true);
        $insert_footer_authorty['insert_by']          = $_SESSION['userid'];
        $insert_footer_authorty['insert_time']      = date('Y-m-d H:i:s');


        if (!empty($_FILES['icon']['name'])) {

          $path_parts                 = pathinfo($_FILES["icon"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/footerAuthority/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('icon')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_footer_authorty['icon'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_footer_authorty['icon'], 400, 400);
          }
        }



        $add_footer_authority = $this->db->insert('tbl_footer_authorty', $insert_footer_authorty);

        if ($add_footer_authority) {

          $this->session->set_flashdata('message', 'Data Created Successfully!');
          redirect('admin/footer-authorty/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('admin/footer-authorty', 'refresh');
        }
      }


      $data['title']         = 'Footer Authority Add';
      $data['page']          = 'backEnd/admin/footer_authority_add';
      $data['activeMenu']    = 'footer_authority_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_footer_authorty');

      if ($check_table_row->num_rows() > 0) {

        $data['footer_authority_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_footer_authority['title']        = $this->input->post('title', true);
          $update_footer_authority['details']        = $this->input->post('details', true);
          $update_footer_authority['priority']        = $this->input->post('priority', true);

          if (!empty($_FILES['icon']['name'])) {

            $path_parts                 = pathinfo($_FILES["icon"]['name']);
            $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newfile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/footerAuthority/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('icon')) {
            } else {

              $upload_c = $this->upload->data();
              $update_footer_authority['icon'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_footer_authority['icon'], 400, 400);
            }
          }


          if ($this->AdminModel->footer_authority_update($update_footer_authority, $param2)) {

            $this->session->set_flashdata('message', 'Data Updated Successfully!');
            redirect('admin/footer-authorty/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('admin/footer-authorty/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('admin/footer-authorty/list', 'refresh');
        }
      }


      $data['title']         = 'Footer Address Update';
      $data['page']          = 'backEnd/admin/footer_authority_edit';
      $data['activeMenu']    = 'footer_authority_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/footer-authority/list");
      $config["total_rows"] = $this->db->get('tbl_footer_authorty')->num_rows();
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

      $data["links"] = $this->pagination->create_links();

      $data['footer_authority_list'] = $this->AdminModel->get_footer_authority_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Footer Authority List';
      $data['page']       = 'backEnd/admin/footer_authority_list';
      $data['activeMenu'] = 'footer_authority_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->footer_authority_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('admin/footer-authorty/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('admin/footer-authorty/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('admin/footer-authorty/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //Online Poll
  public function online_poll($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($this->input->post('poll_date', true)) {

          $insert_online_poll['poll_date']           = date('Y-m-d', strtotime($this->input->post('poll_date', true)));
        }
        $insert_online_poll['poll_title']          = $this->input->post('poll_title', true);
        $insert_online_poll['is_published']        = $this->input->post('is_published', true);
        $insert_online_poll['insert_by']           = $_SESSION['userid'];
        $insert_online_poll['insert_time']        = date('Y-m-d H:i:s');


        $add_online_poll = $this->db->insert('tbl_online_poll', $insert_online_poll);

        if ($add_online_poll) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/online-poll/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/online-poll/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($this->input->post('poll_date', true)) {

          $update_online_poll['poll_date']           = date('Y-m-d', strtotime($this->input->post('poll_date', true)));
        }
        $update_online_poll['poll_title']          = $this->input->post('poll_title', true);
        $update_online_poll['is_published']        = $this->input->post('is_published', true);


        if ($this->AdminModel->online_poll_update($update_online_poll, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/online-poll', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/online-poll', 'refresh');
        }
      }

      $data['online_poll_info'] = $this->db->get_where('tbl_online_poll', array('id' => $param2));

      if ($data['online_poll_info']->num_rows() > 0) {

        $data['online_poll_info']    = $data['online_poll_info']->row();
        $data['online_polll_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/online-poll', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->online_poll_Delete($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/online-poll', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/online-poll', 'refresh');
      }
    }

    $data['title']      = 'Online Poll';
    $data['activeMenu'] = 'online_poll';
    $data['page']       = 'backEnd/admin/online_poll';
    $data['online_poll_list'] = $this->db->select('tbl_online_poll.id,tbl_online_poll.poll_date,tbl_online_poll.poll_title,tbl_online_poll.is_published')->order_by('id', 'desc')->get('tbl_online_poll')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Poll Voting 
  public function poll_voting($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_poll_voting['poll_id']                  = $this->input->post('poll_id', true);
        $insert_poll_voting['ip_address']               = $this->input->post('ip_address', true);
        $insert_poll_voting['selected_option_id']       = $this->input->post('selected_option_id', true);
        $insert_poll_voting['insert_time']             = date('Y-m-d H:i:s');


        $add_poll_voting = $this->db->insert('tbl_poll_voting', $insert_poll_voting);

        if ($add_poll_voting) {

          $this->session->set_flashdata('message', "Data Added Successfully.");
          redirect('admin/poll-voting/', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Add Failed.");
          redirect('admin/poll-voting/', 'refresh');
        }
      }
    } else if ($param1 == 'edit' && $param2 > 0) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $update_poll_voting['poll_id']                  = $this->input->post('poll_id', true);
        $update_poll_voting['ip_address']               = $this->input->post('ip_address', true);
        $update_poll_voting['selected_option_id']       = $this->input->post('selected_option_id', true);


        if ($this->AdminModel->poll_voting_update($update_poll_voting, $param2)) {

          $this->session->set_flashdata('message', "Data Updated Successfully.");
          redirect('admin/poll-voting', 'refresh');
        } else {

          $this->session->set_flashdata('message', "Data Update Failed.");
          redirect('admin/poll-voting', 'refresh');
        }
      }

      $data['poll_voting_info'] = $this->db->get_where('tbl_poll_voting', array('id' => $param2));

      if ($data['poll_voting_info']->num_rows() > 0) {

        $data['poll_voting_info']    = $data['poll_voting_info']->row();
        $data['poll_voting_id'] = $param2;
      } else {

        $this->session->set_flashdata('message', "Wrong Attempt !");
        redirect('admin/poll-voting', 'refresh');
      }
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->poll_voting_Delete($param2)) {

        $this->session->set_flashdata('message', "Data Deleted Successfully.");
        redirect('admin/poll-voting', 'refresh');
      } else {

        $this->session->set_flashdata('message', "Data Delete Failed.");
        redirect('admin/poll-voting', 'refresh');
      }
    }


    $data['poll_list']  = $this->db->order_by('id', 'desc')->get('tbl_online_poll')->result();

    $data['title']      = 'Poll Voting';
    $data['activeMenu'] = 'poll_voting';
    $data['page']       = 'backEnd/admin/poll_voting';
    $data['poll_voting_list'] = $this->db->select('tbl_poll_voting.id,tbl_poll_voting.selected_option_id,tbl_poll_voting.ip_address,tbl_online_poll.poll_title')
      ->join('tbl_online_poll', 'tbl_online_poll.id = tbl_poll_voting.poll_id', 'left')
      ->order_by('id', 'desc')->get('tbl_poll_voting')->result();

    $this->load->view('backEnd/master_page', $data);
  }

  //Poll Options  
  public function poll_options($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_poll_options['poll_id']        = $this->input->post('poll_id', true);
        $insert_poll_options['option_1']        = $this->input->post('option_1', true);
        $insert_poll_options['option_2']        = $this->input->post('option_2', true);
        $insert_poll_options['option_3']        = $this->input->post('option_3', true);
        $insert_poll_options['option_4']        = $this->input->post('option_4', true);
        $insert_poll_options['option_5']        = $this->input->post('option_5', true);
        $insert_poll_options['correct_option']   = $this->input->post('correct_option', true);
        $insert_poll_options['insert_by']      = $_SESSION['userid'];
        $insert_poll_options['insert_time']      = date('Y-m-d H:i:s');


        $add_tbl_poll_options = $this->db->insert('tbl_poll_options', $insert_poll_options);

        if ($add_tbl_poll_options) {

          $this->session->set_flashdata('message', 'Data Created Successfully!');
          redirect('admin/poll-options/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('admin/poll-options', 'refresh');
        }
      }

      $data['poll_list']  = $this->db->order_by('id', 'desc')->get('tbl_online_poll')->result();

      $data['title']         = 'Poll Options Add';
      $data['page']          = 'backEnd/admin/poll_options_add';
      $data['activeMenu']    = 'poll_options_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_poll_options');

      if ($check_table_row->num_rows() > 0) {

        $data['poll_opitons_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_poll_options['poll_id']        = $this->input->post('poll_id', true);
          $update_poll_options['option_1']        = $this->input->post('option_1', true);
          $update_poll_options['option_2']        = $this->input->post('option_2', true);
          $update_poll_options['option_3']        = $this->input->post('option_3', true);
          $update_poll_options['option_4']        = $this->input->post('option_4', true);
          $update_poll_options['option_5']        = $this->input->post('option_5', true);
          $update_poll_options['correct_option']   = $this->input->post('correct_option', true);


          if ($this->AdminModel->poll_options_update($update_poll_options, $param2)) {

            $this->session->set_flashdata('message', 'Data Updated Successfully!');
            redirect('admin/poll-options/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('admin/poll-options/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('admin/poll-options/list', 'refresh');
        }
      }

      $data['poll_list']  = $this->db->order_by('id', 'desc')->get('tbl_online_poll')->result();

      $data['title']         = 'Poll Options';
      $data['page']          = 'backEnd/admin/poll_options_edit';
      $data['activeMenu']    = 'poll_options_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/poll-options/list");
      $config["total_rows"] = $this->db->get('tbl_poll_options')->num_rows();
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

      $data["links"] = $this->pagination->create_links();

      $data['poll_options_list'] = $this->AdminModel->get_poll_options_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Poll Options List';
      $data['page']       = 'backEnd/admin/poll_options_list';
      $data['activeMenu'] = 'poll_options_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->poll_opitons_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('admin/poll-options/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('admin/poll-options/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('admin/poll-options/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //Page Settings
  public function page_settings($param1 = 'add', $param2 = '', $param3 = '')
  {

    if ($param1 == 'add') {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $insert_page_settings['title']                = $this->input->post('title', true);
        $insert_page_settings['subtitle']            = $this->input->post('subtitle', true);
        $insert_page_settings['youtube_video_link']      = $this->input->post('youtube_video_link', true);
        $insert_page_settings['body']                    = $this->input->post('body', true);
        $insert_page_settings['insert_by']              = $_SESSION['userid'];
        $insert_page_settings['insert_time']              = date('Y-m-d H:i:s');


        if (!empty($_FILES['photo']['name'])) {

          $path_parts                 = pathinfo($_FILES["photo"]['name']);
          $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
          $dir                        = date("YmdHis", time());
          $config_c['file_name']      = $newfile_name . '_' . $dir;
          $config_c['remove_spaces']  = TRUE;
          $config_c['upload_path']    = 'assets/pageSettings/';
          $config_c['max_size']       = '20000'; //  less than 20 MB
          $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

          $this->load->library('upload', $config_c);
          $this->upload->initialize($config_c);
          if (!$this->upload->do_upload('photo')) {
          } else {

            $upload_c = $this->upload->data();
            $insert_page_settings['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
            $this->image_size_fix($insert_page_settings['photo'], 400, 400);
          }
        }



        $add_news = $this->db->insert('tbl_page_setting', $insert_page_settings);

        if ($add_news) {

          $this->session->set_flashdata('message', 'Data Created Successfully!');
          redirect('admin/page-settings/list', 'refresh');
        } else {

          $this->session->set_flashdata('message', 'Data Created Failed!');
          redirect('admin/page-settings', 'refresh');
        }
      }


      $data['title']         = 'Page Settings';
      $data['page']          = 'backEnd/admin/page_settings_add';
      $data['activeMenu']    = 'page_settings_add';
    } elseif ($param1 == 'edit' && (int) $param2 > 0) {

      $check_table_row = $this->db->where('id', $param2)->get('tbl_page_setting');

      if ($check_table_row->num_rows() > 0) {

        $data['page_settings_info'] = $check_table_row->row();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $update_page_settings['title']                = $this->input->post('title', true);
          $update_page_settings['subtitle']            = $this->input->post('subtitle', true);
          $update_page_settings['youtube_video_link']      = $this->input->post('youtube_video_link', true);
          $update_page_settings['body']                    = $this->input->post('body', true);

          if (!empty($_FILES['photo']['name'])) {

            $path_parts                 = pathinfo($_FILES["photo"]['name']);
            $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
            $dir                        = date("YmdHis", time());
            $config_c['file_name']      = $newfile_name . '_' . $dir;
            $config_c['remove_spaces']  = TRUE;
            $config_c['upload_path']    = 'assets/pageSettings/';
            $config_c['max_size']       = '20000'; //  less than 20 MB
            $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

            $this->load->library('upload', $config_c);
            $this->upload->initialize($config_c);
            if (!$this->upload->do_upload('photo')) {
            } else {

              $upload_c = $this->upload->data();
              $update_page_settings['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
              $this->image_size_fix($update_page_settings['photo'], 400, 400);
            }
          }


          if ($this->AdminModel->update_page_settings($update_page_settings, $param2)) {

            $this->session->set_flashdata('message', 'Data Updated Successfully!');
            redirect('admin/page-settings/list', 'refresh');
          } else {

            $this->session->set_flashdata('message', 'Data Update Failed!');
            redirect('admin/page-settings/list', 'refresh');
          }

          $this->session->set_flashdata('message', 'Data Updated Successfully');
          redirect('admin/page-settings/list', 'refresh');
        }
      }


      $data['title']         = 'Page Settings Edit';
      $data['page']          = 'backEnd/admin/page_settings_edit';
      $data['activeMenu']    = 'page_settings_edit';
    } elseif ($param1 == 'list') {

      $config = array();
      $config["base_url"] = base_url("admin/page-settings/list");
      $config["total_rows"] = $this->db->get(' tbl_page_setting')->num_rows();
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

      $data["links"] = $this->pagination->create_links();

      $data['page_settings_list'] = $this->AdminModel->get_page_settings_list($config["per_page"], $page);

      $data['new_serial'] = $page;

      $data['title']      = 'Page Settings list';
      $data['page']       = 'backEnd/admin/page_settings_list';
      $data['activeMenu'] = 'page_settings_list';
    } elseif ($param1 == 'delete' && $param2 > 0) {

      if ($this->AdminModel->page_settings_delete($param2)) {

        $this->session->set_flashdata('message', 'Data Deleted Successfully!');
        redirect('admin/page-settings/list', 'refresh');
      } else {

        $this->session->set_flashdata('message', 'Data Deleted Failed!');
        redirect('admin/page-settings/list', 'refresh');
      }
    } else {

      $this->session->set_flashdata('message', 'Wrong Attempt!');
      redirect('admin/page-settings/list', 'refresh');
    }


    $this->load->view('backEnd/master_page', $data);
  }

  //SMS Settings 
  public function sms_send_setting($param1 = 0)
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $update_sms_setting['username']     = $this->input->post('username', true);
      $update_sms_setting['password']     = $this->input->post('password', true);
      $update_sms_setting['last_update']  = date('Y-m-d H:i:s');

      $update_sms_setting = $this->db->update('tbl_sms_send_setting', $update_sms_setting);

      if ($update_sms_setting) {
        $this->session->set_flashdata('message', 'Data Updated Successfully!');
        redirect('admin/sms-send-setting', 'refresh');
      } else {
        $this->session->set_flashdata('message', 'Data Updated Failed!');
        redirect('admin/sms-send-setting', 'refresh');
      }
    }

    $data['sms_setting_info']  = $this->db->select('id,username,password')->where('id', 1)->get('tbl_sms_send_setting')->row();
    $data['title']      = 'SMS Settings';
    $data['page']       = 'backEnd/admin/sms_settings';
    $data['activeMenu'] = 'sms_settings';

    $this->load->view('backEnd/master_page', $data);
  }
}
