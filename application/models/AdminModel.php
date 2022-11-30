<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
	class AdminModel extends CI_Model{
		
	// $returnmessage can be num_rows, result_array, result
		public function isRowExist($tableName,$data, $returnmessage, $user_id = NULL){
		
				$this->db->where($data);
				if($user_id !== NULL) {
						$this->db->where('userId',$user_id);
				}
				if($returnmessage == 'num_rows'){
						return $this->db->get($tableName)->num_rows();
				}else if($returnmessage == 'result_array'){
						return $this->db->get($tableName)->result_array();
				}else{
						return $this->db->get($tableName)->result();
				}
		}
			// saveDataInTable table name , array, and return type is null or last inserted ID.
		public function saveDataInTable($tableName, $data, $returnInsertId = 'false'){
		
				$this->db->insert($tableName,$data);
				if($returnInsertId == 'true'){
						return $this->db->insert_id();
				}else{
						return -1;
				}
		}
			
		public function check_campaign_ambigus($start_date, $end_date){
					
				if(date_format(date_create($start_date),"Y-m-d") > date_format(date_create($end_date),"Y-m-d")){
						return -2;
					}
		
				$this -> db -> limit(1);
				$this -> db -> where('end_date >=', $start_date);
				$this -> db -> where('available_status', 1);
				$query = $this->db->get('create_campaign')->num_rows();
				if($query > 0){
						return -1;
				}
				return 1;
		}
		
		public function end_date_extends($end_date, $id){
		
				$this -> db -> limit(1);
				$this -> db -> where('start_date >=', $end_date);
				$this -> db -> where('id', $id);
				$this -> db -> where('available_status', 1);
				$query = $this->db->get('create_campaign')->num_rows();
				if($query > 0){
						return -1;
				}
				$this -> db -> limit(1);
				$this -> db -> where('end_date >=', $end_date);
				$this -> db -> where('id !=', $id);
				$this -> db -> where('available_status', 1);
				$query2 = $this->db->get('create_campaign')->num_rows();
				if($query2 > 0){
						return -1;
				}
				return 1;
		}
		public function fetch_data_pageination($limit, $start, $table, $search=NULL, $approveStatus=NULL, $user_id =NULL) {
				
				$this->db->limit($limit, $start);
	
			if($approveStatus!==NULL ){
						$this->db->where('approveStatus',$approveStatus);
				}
	
				if($user_id !== NULL ){
						$this->db->where('userId', $user_id);
				}
	
				if($search !== NULL){
						$this->db->like('title',$search);
						$this->db->or_like('body',$search);
						$this->db->or_like('date',$search);
				}
	
				$this->db->order_by('date','desc');
				$query = $this->db->get($table);
	
				if ($query->num_rows() > 0) {
						foreach ($query->result_array() as $row) {
								$data[] = $row;
						}
						return $data;
				}
				return false;
		}
		public function fetch_images($limit=18, $start=0, $table, $search=NULL,$where_data=NULL) {
				
				$this->db->limit($limit, $start);
	
				if($search !== NULL){
						$this->db->like('date',$search);
						$this->db->or_like('photoCaption',$search);
				}
				if($where_data !== NULL){
						$this->db->where($where_data);
				}
				$this->db->group_by('photo');
				$this->db->order_by('date','desc');
				$query = $this->db->get($table);
	
				if ($query->num_rows() > 0) {
						foreach ($query->result_array() as $row) {
								$data[] = $row;
						}
						return $data;
				}
				return false;
		}
		
		public function usersCategory($userId){
	
				$this->db->select('category.*');
				$this->db->join('category' , 'category_user.categoryId = category.id', 'left');
				$this->db->where('category_user.userId',$userId);
				return $this->db->get('category_user')->result_array();
		}
		
		
		public function get_user($user_id)
		{
			 $query = $this->db->select('user.*,tbl_upozilla.*')
							->where('user.id',$user_id)
							->from('user')
							->join('tbl_upozilla','user.address = tbl_upozilla.id', 'left')
							->get();
	
				return $query->row();
		}
		
		public function update_pro_info($update_data, $user_id)
		{
			 return $this->db->where('id',$user_id)->update('user',$update_data);
		}

		public function theme_text_update($name_index, $value){

			if($name_index == 'logo'){
				$result = $this->db->select('value')->where(array('id'=>6))->get('tbl_backend_theme')->row()->value;
				
				if (file_exists($result)) {
					unlink($result);
				}
		
			}elseif($name_index == 'share_banner'){
				$result = $this->db->select('value')->where(array('id'=>7))->get('tbl_backend_theme')->row()->value;
				
				if (file_exists($result)) {
					unlink($result);
				}
		
			} 

			$update_theme['value'] = $value;
			$this->db->where('name', $name_index)->update('tbl_backend_theme', $update_theme);
			return true;
		}

		// video album Update
		public function video_album_update($update_video_album, $param2)
		{
			return $this->db->where('id',$param2)->update('tbl_video_album',$update_video_album);
		}

		//video album Delete
		public function delete_video_album($param2)
		{
			return $this->db->where('id',$param2)->delete('tbl_video_album');
		}

		// video gallery Update
		public function video_gallery_update($update_video_galley, $param2)
		{
			return $this->db->where('id',$param2)->update('tbl_video_gallery',$update_video_galley);
		}

		//video gallery Delete
		public function delete_video_gallery($param2)
		{
			return $this->db->where('id',$param2)->delete('tbl_video_gallery');
		}

		//Photo Album Delete
		public function photo_album_delete($param2)
		{
			return $this->db->where('id',$param2)->delete('tbl_photo_album');
		}

		//Photo Album list
		public function get_photo_album_list($limit = 10, $start = 0){
			$results = array();

			$this->db->select('tbl_photo_album.id,tbl_photo_album.album_title,tbl_photo_album.priority');
			$this->db->limit($limit, $start);
			$this->db->order_by('priority', 'desc');
			$results = $this->db->get('tbl_photo_album')->result();

			return $results;
		}

		//Photo Gallery Update

		public function photo_gallery_update($update_photo_gallery, $param2)
		{
			if (isset($update_photo_gallery['photo_file']) && file_exists($update_photo_gallery['photo_file'])) {

				$result = $this->db->select('photo_file')
					->from('tbl_photo_gallery')
					->where('id',$param2)
					->get()
					->row()->photo_file;

				if (file_exists($result)) {
					unlink($result);
				}
			}

			return $this->db->where('id',$param2)->update('tbl_photo_gallery',$update_photo_gallery);
		}

		//Photo gallery List
		public function get_photo_gallery_list($limit = 10, $start = 0){
			$results = array();

			$this->db->select('tbl_photo_gallery.id,tbl_photo_gallery.photo_file,tbl_photo_gallery.title,tbl_photo_album.album_title as album_name');
			$this->db->join('tbl_photo_album', 'tbl_photo_album.id  = tbl_photo_gallery.photo_album_id', 'left');

			$this->db->limit($limit, $start);
			$this->db->order_by('id', 'desc');
			$results = $this->db->get('tbl_photo_gallery')->result();

			return $results;

		}


		//Photo Gallery Delete
		public function photo_gallery_delete($param2){

			$result = $this->db->select('photo_file')
							->from('tbl_photo_gallery')
							->where('id', $param2)
							->get()
							->row()->photo_file;

				if(file_exists($result)){
					unlink($result);
				}

				return $this->db->where('id', $param2)->delete('tbl_photo_gallery');
		}

		// Photo album Update
		public function photo_album_update($update_photo_album, $param2)
		{
			return $this->db->where('id',$param2)->update('tbl_photo_album',$update_photo_album);
		}

		//Photo album Delete
		public function delete_photo_album($param2)
		{
			return $this->db->where('id',$param2)->delete('tbl_photo_album');
		}

		//Video Gallery Update

		public function get_video_gallery_update($update_video_gallery, $param2)
		{

			return $this->db->where('id',$param2)->update('tbl_video_gallery',$update_video_gallery);
		}

		//Video gallery List
		public function get_video_gallery_list($limit = 10, $start = 0){
			$results = array();

			$this->db->select('tbl_video_gallery.id,tbl_video_gallery.title,tbl_video_album.album_title as album_name');
			$this->db->join('tbl_video_album', 'tbl_video_album.id  = tbl_video_gallery.video_album_id', 'left');

			$this->db->limit($limit, $start);
			$this->db->order_by('id', 'desc');
			$results = $this->db->get('tbl_video_gallery')->result();

			return $results;

		}


		//Video Gallery Delete
		public function video_gallery_delete($param2){

			return $this->db->where('id', $param2)->delete(' tbl_video_gallery');
		}

		//News Update
		public function news_update($update_news, $param2)
		{
			if (isset($update_news['thumb_photo']) && file_exists($update_news['thumb_photo'])) {

				$result = $this->db->select('thumb_photo')
					->from('tbl_news')
					->where('id',$param2)
					->get()
					->row()->thumb_photo;

				if (file_exists($result)) {
					unlink($result);
				}
			}

			return $this->db->where('id',$param2)->update('tbl_news',$update_news);
		}

		//News List
		public function get_news_list($limit = 10, $start = 0){
			$results = array();

			$this->db->select('id,news_date,title,tags,thumb_photo,is_published,approve_status');

			$this->db->limit($limit, $start);
			$this->db->order_by('id', 'desc');
			$results = $this->db->get('tbl_news')->result();

			return $results;

		}

		//News Delete
		public function news_delete($param2){

			$result = $this->db->select('thumb_photo')
							->from('tbl_news')
							->where('id', $param2)
							->get()
							->row()->thumb_photo;

				if(file_exists($result)){
					unlink($result);
				}

				return $this->db->where('id', $param2)->delete('tbl_news');
		}

		//News Category Update 
		public function news_category_update($update_news_category, $param2 ){

			if(isset($update_news_category['category_photo']) && file_exists($update_news_category['category_photo'])){
				$result = $this->db->select('category_photo')
									->from('tbl_news_category')
									->where('id', $param2)
									->get()
									->row()->category_photo;

						if(file_exists($result)){
							unlink($result);
						}			
			}

			return $this->db->where('id', $param2)->update('tbl_news_category', $update_news_category);
		}

		//News Category Delete
		public function delete_news_category($param2)
		{
			$result = $this->db->select('category_photo')
				->from('tbl_news_category')
				->where('id',$param2)
				->get()
				->row()->category_photo;

			if (file_exists($result)) {
				unlink($result);
			}


			return $this->db->where('id',$param2)->delete('tbl_news_category');
		}

		//News Sub Category Update
		public function news_sub_category_update($news_sub_category_update, $param2){

			if(isset($news_sub_category_update['category_photo']) && file_exists($news_sub_category_update['category_photo'])){
				$result = $this->db->select('category_photo')
									->from('tbl_news_sub_category')
									->where('id', $param2)
									->get()
									->row()->category_photo;
					
					if(file_exists($result)){
						unlink($result);
					}				
			}

			return $this->db->where('id', $param2)->update('tbl_news_sub_category', $news_sub_category_update);
		}

		//News Sub Category Delete
		public function delete_news_sub_category($param2){

			$result = $this->db->select('category_photo')
								->from('tbl_news_sub_category')
								->where('id', $param2)
								->get()
								->row()->category_photo;
						
					if(file_exists($result)){
						unlink($result);
					}

			return $this->db->where('id', $param2)->delete('tbl_news_sub_category');

		}
	
		//News Photo Update
		public function news_photo_update($update_news_photo, $param2){

			if(isset($update_news_photo['news_photo']) && file_exists($update_news_photo['news_photo'])){
				$result = $this->db->select('news_photo')
									->from('tbl_news_photos')
									->where('id', $param2)
									->get()
									->row()->news_photo;

					if(file_exists($result)){
						unlink($result);
					}

			}

			return $this->db->where('id', $param2)->update('tbl_news_photos', $update_news_photo);
		}

		//News Photo Delete 
		public function delete_news_photo($param2){

			$result = $this->db->select('news_photo')
								->from('tbl_news_photos')
								->where('id', $param2)
								->get()
								->row()->news_photo;

					if(file_exists($result)){
						unlink($result);
					}
					
				return $this->db->where('id', $param2)->delete('tbl_news_photos');		
								
		}

		//News Video Update
		public function news_videos_update($update_news_video, $param2){

			return $this->db->where('id', $param2)->update('tbl_news_videos',$update_news_video);
		}

		//News Video Delete
		public function delete_news_videos($param2){
			return $this->db->where('id', $param2)->delete('tbl_news_videos');
		}

		//News Category Set Udpate
		public function news_category_set_update($update_news_category_set, $param2){

			return $this->db->where('id', $param2)->update('tbl_news_category_set',$update_news_category_set);
		}

		//News Category Set Delete
		public function delete_news_category_set($param2){

			return $this->db->where('id', $param2)->delete('tbl_news_category_set');
		}

		//Footer Address Update
		public function footer_address_update($update_footer_address, $param2){
			
			if(isset($update_footer_address['icon']) && file_exists($update_footer_address['icon'])){

				$result = $this->db->select('icon')
									->from('tbl_footer_address')
									->where('id', $param2)
									->get()
									->row()->icon;

				if(file_exists($result)){
					unlink($result);
				}					
			}

			return $this->db->where('id', $param2)->update('tbl_footer_address', $update_footer_address);
		}

		//Footer Addres list
		public function get_footer_address_list($limit = 10, $start = 0){

			$results = array();

			$this->db->select('tbl_footer_address.id,tbl_footer_address.title,tbl_footer_address.priority,tbl_footer_address.icon');

			$this->db->limit($limit, $start);
			$this->db->order_by('priority', 'asc');
			$results = $this->db->get('tbl_footer_address')->result();

			return $results;
		}

		//Footer address Delete
		public function footer_address_delete($param2){

			$result = $this->db->select('icon')
								->from('tbl_footer_address')
								->where('id', $param2)
								->get()
								->row()->icon;


			if(file_exists($result)){
				unlink($result);
			}
			
			return $this->db->where('id', $param2)->delete('tbl_footer_address');
		}

		//Footer Authority Update
		public function footer_authority_update($update_footer_authority, $param2){
			
			if(isset($update_footer_authority['icon']) && file_exists($update_footer_authority['icon'])){

				$result = $this->db->select('icon')
									->from('tbl_footer_authorty')
									->where('id', $param2)
									->get()
									->row()->icon;

				if(file_exists($result)){
					unlink($result);
				}					
			}

			return $this->db->where('id', $param2)->update('tbl_footer_authorty', $update_footer_authority);
		}

		//Footer Authority list
		public function get_footer_authority_list($limit = 10, $start = 0){

			$results = array();

			$this->db->select('tbl_footer_authorty.id,tbl_footer_authorty.title,tbl_footer_authorty.priority,tbl_footer_authorty.icon');

			$this->db->limit($limit, $start);
			$this->db->order_by('priority', 'asc');
			$results = $this->db->get('tbl_footer_authorty')->result();

			return $results;
		}

		//Footer Authority Delete
		public function footer_authority_delete($param2){

			$result = $this->db->select('icon')
								->from('tbl_footer_authorty')
								->where('id', $param2)
								->get()
								->row()->icon;


			if(file_exists($result)){
				unlink($result);
			}
			
			return $this->db->where('id', $param2)->delete('tbl_footer_authorty');
		}

		//Online POll Updd
		public function online_poll_update($update_online_poll, $param2){

			return $this->db->where('id', $param2)->update('tbl_online_poll', $update_online_poll);
		}

		//Online Poll Delete
		public function online_poll_Delete($param2){

			return $this->db->where('id', $param2)->delete('tbl_online_poll');
		}

		//Poll Voting Update
		public function poll_voting_update($update_poll_voting, $param2){

			return $this->db->where('id', $param2)->update('tbl_poll_voting', $update_poll_voting);
		}

		//Poll Voting Delte
		public function poll_voting_Delete($param2){

			return $this->db->where('id', $param2)->delete('tbl_poll_voting');
		}

		//Poll Options Update
		public function poll_options_update($update_poll_options, $param2){

			return $this->db->where('id', $param2)->update('tbl_poll_options', $update_poll_options);
		}

		//Poll Options list
		public function get_poll_options_list($limit = 10, $start = 0){

			$result = array();

			$this->db->select('tbl_poll_options.*,tbl_online_poll.poll_title')
					->join('tbl_online_poll','tbl_online_poll.id = tbl_poll_options.poll_id', 'left')
					 ->limit($limit, $start)
					 ->order_by('id', 'desc');
			$result = $this->db->get('tbl_poll_options')->result();
			return $result;
			
		}

		//Poll Option Delete
		public function poll_opitons_delete($param2){

			return $this->db->where('id', $param2)->delete('tbl_poll_options');
		}

		//Page Settings Update
		public function update_page_settings($update_page_settings, $param2){

			if(isset($update_page_settings['photo']) && file_exists($update_page_settings['photo'])){

				$result = $this->db->select('photo')
									->from('tbl_page_setting')
									->where('id', $param2)
									->get()
									->row()->photo;
				if(file_exists($result)){
					unlink($result);
				}					
			}

			return $this->db->where('id', $param2)->update('tbl_page_setting', $update_page_settings);
		}

		//Page Settings list
		public function get_page_settings_list($limit = 10, $start = 0){

			$result = array();

			$this->db->select('id,title,subtitle,photo')
					  ->limit($limit, $start)
					  ->order_by('id','desc');	
					  
			$result = $this->db->get('tbl_page_setting')->result();	
			return $result;	  
		}

		//Page Settings Delete
		public function page_settings_delete($param2){

			$result = $this->db->select('photo')
								->from('tbl_page_setting')
								->where('id', $param2)
								->get()
								->row()->photo;
				
				if(file_exists($result)){
					unlink($result);
				}				

				return $this->db->where('id', $param2)->delete('tbl_page_setting');				
		}

	}

	
	
	
?>

