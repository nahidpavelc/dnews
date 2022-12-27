<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
class UserModel extends CI_Model
{

  // $returnmessage can be num_rows, result_array, result
  public function isRowExist($tableName, $data, $returnmessage, $user_id = NULL)
  {

    $this->db->where($data);
    if ($user_id !== NULL) {
      $this->db->where('userId', $user_id);
    }
    if ($returnmessage == 'num_rows') {
      return $this->db->get($tableName)->num_rows();
    } else if ($returnmessage == 'result_array') {
      return $this->db->get($tableName)->result_array();
    } else {
      return $this->db->get($tableName)->result();
    }
  }
  // saveDataInTable table name , array, and return type is null or last inserted ID.
  public function saveDataInTable($tableName, $data, $returnInsertId = 'false')
  {

    $this->db->insert($tableName, $data);
    if ($returnInsertId == 'true') {
      return $this->db->insert_id();
    } else {
      return -1;
    }
  }

  public function check_campaign_ambigus($start_date, $end_date)
  {

    if (date_format(date_create($start_date), "Y-m-d") > date_format(date_create($end_date), "Y-m-d")) {
      return -2;
    }

    $this->db->limit(1);
    $this->db->where('end_date >=', $start_date);
    $this->db->where('available_status', 1);
    $query = $this->db->get('create_campaign')->num_rows();
    if ($query > 0) {
      return -1;
    }
    return 1;
  }

  public function end_date_extends($end_date, $id)
  {

    $this->db->limit(1);
    $this->db->where('start_date >=', $end_date);
    $this->db->where('id', $id);
    $this->db->where('available_status', 1);
    $query = $this->db->get('create_campaign')->num_rows();
    if ($query > 0) {
      return -1;
    }
    $this->db->limit(1);
    $this->db->where('end_date >=', $end_date);
    $this->db->where('id !=', $id);
    $this->db->where('available_status', 1);
    $query2 = $this->db->get('create_campaign')->num_rows();
    if ($query2 > 0) {
      return -1;
    }
    return 1;
  }
  public function fetch_data_pageination($limit, $start, $table, $search = NULL, $approveStatus = NULL, $user_id = NULL)
  {

    $this->db->limit($limit, $start);

    if ($approveStatus !== NULL) {
      $this->db->where('approveStatus', $approveStatus);
    }

    if ($user_id !== NULL) {
      $this->db->where('userId', $user_id);
    }

    if ($search !== NULL) {
      $this->db->like('title', $search);
      $this->db->or_like('body', $search);
      $this->db->or_like('date', $search);
    }

    $this->db->order_by('date', 'desc');
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }
  public function fetch_images($limit = 18, $start = 0, $table, $search = NULL, $where_data = NULL)
  {

    $this->db->limit($limit, $start);

    if ($search !== NULL) {
      $this->db->like('date', $search);
      $this->db->or_like('photoCaption', $search);
    }
    if ($where_data !== NULL) {
      $this->db->where($where_data);
    }
    $this->db->group_by('photo');
    $this->db->order_by('date', 'desc');
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }

  public function usersCategory($userId)
  {

    $this->db->select('category.*');
    $this->db->join('category', 'category_user.categoryId = category.id', 'left');
    $this->db->where('category_user.userId', $userId);
    return $this->db->get('category_user')->result_array();
  }


  public function get_user($user_id)
  {
    $query = $this->db->select('user.*,tbl_upozilla.*')
      ->where('user.id', $user_id)
      ->from('user')
      ->join('tbl_upozilla', 'user.address = tbl_upozilla.id', 'left')
      ->get();

    return $query->row();
  }

  public function update_pro_info($update_data, $user_id)
  {
    return $this->db->where('id', $user_id)->update('user', $update_data);
  }





  //Photo Gallery Update
  public function photo_gallery_update($update_photo_gallery, $param2)
  {
    if (isset($update_photo_gallery['photo_file']) && file_exists($update_photo_gallery['photo_file'])) {

      $result = $this->db->select('photo_file')
        ->from('tbl_photo_gallery')
        ->where('id', $param2)
        ->get()
        ->row()->photo_file;

      if (file_exists($result)) {
        unlink($result);
      }
    }

    return $this->db->where('id', $param2)->update('tbl_photo_gallery', $update_photo_gallery);
  }

  //Photo gallery List
  public function get_photo_gallery_list($limit = 10, $start = 0)
  {
    $results = array();

    $this->db->select('tbl_photo_gallery.id, tbl_photo_gallery.photo_file, tbl_photo_gallery.title, tbl_photo_gallery.insert_by, tbl_photo_album.album_title as album_name');

    $this->db->join('tbl_photo_album', 'tbl_photo_album.id  = tbl_photo_gallery.photo_album_id', 'left');
    $this->db->limit($limit, $start);
    $this->db->Where('tbl_photo_gallery.insert_by', '5');
    $this->db->order_by('id', 'desc');
    $results = $this->db->get('tbl_photo_gallery')->result();

    // $data['photo_gallery_list'] = $this->db->where('insert_by', '5')->order_by('id', 'desc')->get('tbl_photo_album')->result();

    return $results;
  }
  //Photo Gallery Delete
  public function photo_gallery_delete($param2)
  {

    $result = $this->db->select('photo_file')
      ->from('tbl_photo_gallery')
      ->where('id', $param2)
      ->get()
      ->row()->photo_file;

    if (file_exists($result)) {
      unlink($result);
    }

    return $this->db->where('id', $param2)->delete('tbl_photo_gallery');
  }

  // Photo album Update
  public function photo_album_update($update_photo_album, $param2)
  {
    return $this->db->where('id', $param2)->update('tbl_photo_album', $update_photo_album);
  }
  //Photo Album list
  public function get_photo_album_list($limit = 10, $start = 0)
  {
    $results = array();

    $this->db->select('tbl_photo_album.id,tbl_photo_album.album_title,tbl_photo_album.priority');
    $this->db->limit($limit, $start);
    $this->db->order_by('priority', 'desc');
    $results = $this->db->get('tbl_photo_album')->result();

    return $results;
  }
  //Photo album Delete
  public function delete_photo_album($param2)
  {
    return $this->db->where('id', $param2)->delete('tbl_photo_album');
  }

}

?>

