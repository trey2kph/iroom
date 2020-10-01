<?php

class apc {
	
	/***************** DATABASE RELATED FUNCTIONS ******************/
	
	public function db_connect() //connect to database
	{
			$result = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);	 //define in includes/config.php
			if(!$result) return false;
			else return $result;
	}
	private function db_result_to_array($result, $type) //Transform query results into array
	{
			if(!$result) return false;
			$res_array = array();
			for($count = 0; $row = $result->fetch_assoc(); $count++)
			{
				$res_array[$count] = $row;
				
				if ($type == 1) {						
					$category = $this->get_category_slug($row["article_id"]);
					$res_array[$count]['channels_slug'] = $category[0]["channels_slug"];
					$res_array[$count]['channels_name'] = $category[0]["channels_name"];			
					$res_array[$count]['article_title_id'] = urldecode($row['article_title_id']);
					$res_array[$count]['article_title'] = strip_tags($this->cleanpostname($row['article_title'], true), '<b><p><strong><i><em><font>');	
					$res_array[$count]['moodmax'] = $this->maxmood($row["article_id"]);						
				} elseif ($type == 4) {						
					$article = $this->get_article_by_id($row["article_id"]);
					$res_array[$count]['article_id'] = $article[0]["article_id"];
					$res_array[$count]['article_title'] = strip_tags($this->cleanpostname($article[0]['article_title'], true), '<b><p><strong><i><em><font>');	
					$res_array[$count]['article_title_id'] = urldecode($article[0]['article_title_id']);
					$res_array[$count]['article_blurb'] = $article[0]['article_blurb'];
					$res_array[$count]['article_date_published'] = $article[0]['article_date_published'];
					$res_array[$count]['article_thumb_image'] = $article[0]['article_thumb_image'];
					$res_array[$count]['article_image'] = $article[0]['article_image'];
					$category = $this->get_category_slug($row["article_id"]);
					$res_array[$count]['channels_slug'] = $category[0]["channels_slug"];
					$res_array[$count]['channels_name'] = $category[0]["channels_name"];			
				}elseif ($type == 8) {			
					$moodinfo = $this->get_moodname($row["mood_id"]);
					$res_array[$count]['mood_name'] = $moodinfo[0]["mood_name"];			
				}	
								
			}
			return $res_array;
	}
	private function db_result_to_artarray($result, $type) //Transform query results into array
	{
			if(!$result) return false;
			$res_array = array();
			for($count = 0; $row = $result->fetch_assoc(); $count++)
			{	
				if ($type == 1) {						
					$res_array[$row["article_id"]] = $row;
				
					$category = $this->get_category_slug($row["article_id"]);
					$res_array[$row["article_id"]]['channels_slug'] = $category[0]["channels_slug"];
					$res_array[$row["article_id"]]['channels_name'] = $category[0]["channels_name"];			
					$res_array[$row["article_id"]]['article_title_id'] = urldecode($row['article_title_id']);
					$res_array[$row["article_id"]]['article_title'] = strip_tags($this->cleanpostname($row['article_title'], true), '<b><p><strong><i><em><font>');	
					$res_array[$row["article_id"]]['moodmax'] = $this->maxmood($row["article_id"]);						
				} elseif ($type == 4) {					
					$res_array[$row["article_id"]] = $row;
				
					$article = $this->get_article_by_id($row["article_id"]);
					$res_array[$row["article_id"]]['article_id'] = $article[0]["article_id"];
					$res_array[$row["article_id"]]['article_title'] = strip_tags($this->cleanpostname($article[0]['article_title'], true), '<b><p><strong><i><em><font>');	
					$res_array[$row["article_id"]]['article_title_id'] = urldecode($article[0]['article_title_id']);
					$res_array[$row["article_id"]]['article_blurb'] = $article[0]['article_blurb'];
					$res_array[$row["article_id"]]['article_date_published'] = $article[0]['article_date_published'];
					$res_array[$row["article_id"]]['article_image'] = $article[0]['article_image'];
					$res_array[$row["article_id"]]['article_thumb_image'] = $article[0]['article_thumb_image'];
					$category = $this->get_category_slug($row["article_id"]);
					$res_array[$row["article_id"]]['channels_slug'] = $category[0]["channels_slug"];
					$res_array[$row["article_id"]]['channels_name'] = $category[0]["channels_name"];			
				} elseif ($type == 8) {			
					$res_array[$row["article_id"]] = $row;
				
					$moodinfo = $this->get_moodname($row["mood_id"]);
					$res_array[$row["article_id"]]['mood_name'] = $moodinfo[0]["mood_name"];			
				}	
								
			}
			return $res_array;
	}
	private function db_result_to_num($result) //Transform query results into array
	{
			if(!$result) return false;
			$row_cnt = $result->num_rows;
			return $row_cnt;
	}
	
	/*
	TYPES:
	1 - article
	2 - poll
	3 - event
	4 - article by mood
	5 and 6 - event
	7 - directory
	8 - mood
	9 - poll
	*/
	public function get_row($sql, $type) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			if(!$result) return;
			$result = $this->db_result_to_array($result, $type);
			return $result;
	}
	
	public function get_artrow($sql, $type) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			if(!$result) return;
			$result = $this->db_result_to_artarray($result, $type);
			return $result;
	}
	
	public function get_numrow($sql) //Get num rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			if(!$result) return;
			$result = $this->db_result_to_num($result);
			return $result;
	}
	
	public function db_query($sql) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			return $result;
	}
	
	/***************** APC RELATED FUNCTIONS ******************/	
	
	function store_apc($type, $limit = 0) //store array value to APC based on key type
	{
		$date10year = strtotime("-10 year");
		$date6month = strtotime("-6 month");
		$date3month = strtotime("-3 month");
		$date2week = strtotime("-2 weeks");
		$date1week = strtotime("-1 weeks");
		$date1day = strtotime("-1 days");
		$datenow = time();
		
		$blogvar = array(0=>19331,1=>19329,2=>23987,3=>23985,4=>23988,5=>23989);
		
		if ($type == 'flashbox') { $alldata = $this->getflashbox(); $key = 'spotflashbox'; }
		elseif ($type == 'strip1') { $alldata = $this->gettop10forindex(100, $date6month, $date3month, "", 1622, 1); $key = 'spottop1'; }
		elseif ($type == 'strip2') { $alldata = $this->gettop10forindex(100, $date10year, $date6month, "", 1622, 1); $key = 'spottop2'; }
		elseif ($type == 'side1') { $alldata = $this->getpopulararticle(0, $date1week, $datenow, 100); $key = 'spotside1'; }
		elseif ($type == 'side2') { $alldata = $this->getsharearticle(0, $date1week, $datenow, 100); $key = 'spotside2'; }
		elseif ($type == 'all') { $alldata = $this->get_alldata($limit); $key = 'spotarticle_all'; }
		elseif ($type == 'allid') { $alldata = $this->get_allid($limit); $key = 'spotid_all'; }
		elseif ($type == 'feed') { $alldata = $this->get_allfeed($limit); $key = 'spotarticle_allfeed'; }
		elseif ($type == 'blog') { 
			foreach ($blogvar as $id => $value) {
				$artdata = $this->get_artblog($value);
				$alldata[$id] = $artdata[0];
			}					
			$key = 'spot_blog';
		}
		
		if ($alldata) $store = apc_store($key, $alldata);
		
		if ($store) return true;
	}
	
	function store_single_article($id) //store single article data to APC thru article ID
	{
		$artdata = $this->get_artdata($id);

		foreach ($artdata as $id => $value) {
		  $key = 'spotarticle_' . $value['article_id'];
		  apc_store($key, $value);
		}		
	}
	
	function update_single_article($id) //update single article data from APC thru article ID
	{
		apc_delete('spotarticle_'.$id);
		
		$artdata = $this->get_artdata($id);

		foreach ($artdata as $id => $value) {
		  $key = 'spotarticle_' . $value['article_id'];
		  apc_store($key, $value);
		}		
	}
	
	function fetch_apc($type) //get array value from APC based on key type
	{		
		if ($type == 'flashbox') { $key = 'spotflashbox';  }
		elseif ($type == 'strip1') { $key = 'spottop1'; }
		elseif ($type == 'strip2') { $key = 'spottop2'; }
		elseif ($type == 'side1') { $key = 'spotside1'; }
		elseif ($type == 'side2') { $key = 'spotside2'; }
		elseif ($type == 'all') { $key = 'spotarticle_all'; }
		elseif ($type == 'allid') { $key = 'spotid_all'; }
		elseif ($type == 'feed') { $key = 'spotarticle_allfeed'; }
		elseif ($type == 'blog') { $key = 'spot_blog'; }
		
	    $data = apc_fetch($key);		
		
		if ($type == 'strip1' || $type == 'strip2') {
			$key = array_rand($data, 3);			
			foreach($key as $value)	
			{
				$topdata[$value] = $data[$value];
			}		
			return $topdata;
		}
		else { return $data; }
		
		
	}
	
	function fetch_article($id) //get single article data from APC thru article ID
	{
		$key = 'spotarticle_'.$id; 
		$data = apc_fetch($key);
		
		return $data;
	}
	
	function clear_apc($key) //clear array value on APC based on key type
	{	
	 	apc_delete($key);
	}
		
	function inc_view($id) //update single article data's view count from APC thru article ID
	{
		$artdata = $this->getpoparticle($id);			
		$data = $this->fetch_apc('side1');
		
		$newkey = $this->array_searcher($id, $data);
		
		$artdata[$newkey] = $artdata[0];
		unset($artdata[0]);
		
		if ($artdata) {
				
			$data[$newkey] = $artdata[$newkey];		
			$alldata = $data;
			
			$key = 'spotside1';
			apc_store($key, $alldata);		
			
		}
		
	}
	
	function inc_share($id) //update single article data's share count from APC thru article ID
	{
		$artdata = $this->getshaarticle($id);			
		$data = $this->fetch_apc('side2');
		
		$newkey = $this->array_searcher($id, $data);
		
		$artdata[$newkey] = $artdata[0];
		unset($artdata[0]);
		
		if ($artdata) {
				
			$data[$id] = $artdata[$id];		
			$alldata = $data;
			
			$key = 'spotside2';
			apc_store($key, $alldata);		
			
		}
	}	
	
	function inc_comment($id) //update single article data's comment count from APC thru article ID
	{
		$artdata = $this->get_artdata($id);
		
		$data = $this->fetch_apc('all');
		$datafeed = $this->fetch_apc('feed');
		
		if ($artdata) {
				
			$datafeed[$id] = $artdata[$id];		
			$alldatafeed = $datafeed;		
			$data[$id] = $artdata[$id];		
			$alldata = $data;		
			
			$key = 'spotarticle_all';
			apc_store($key, $alldata);		
			$key2 = 'spotarticle_feed';
			apc_store($key2, $alldatafeed);		
			
		}
	}
	
	function update_mood($id) //update single article data's mood from APC thru article ID
	{
		$artdata = $this->get_artdata($id);
		
		$data = $this->fetch_apc('all');
		$datafeed = $this->fetch_apc('feed');
		
		if ($artdata) {
				
			$datafeed[$id] = $artdata[$id];		
			$alldatafeed = $datafeed;		
			$data[$id] = $artdata[$id];		
			$alldata = $data;		
			
			$key = 'spotarticle_all';
			apc_store($key, $alldata);		
			$key2 = 'spotarticle_feed';
			apc_store($key2, $alldatafeed);		
			
		}
	}
	
	/***************** ARRAY RELATED FUNCTIONS ******************/
	
	function array_searcher($needle, $array) //search for key ID based on article ID
	{ 
		foreach ($array as $key => $value) 
		{ 		
			if ($value['article_id'] == $needle) 
			{ 								
				return $key; 
			} 
		}
	}
	
	function dimensionalToArray($paramStringArr=array(), $stringSeparator='id') //to be used on sorting array by view, share and comment count
	{
		$retArr = array();
		if(count($paramStringArr) > 0){
			for($x=0, $max=count($paramStringArr); $x<$max; $x++)
				$retArr[] = $paramStringArr[$x][$stringSeparator];		
		}
		return $retArr;
	}
	
	function filter_alldata($data, $date = 0, $status = 0, $limit = 0, $cat = "", $excat = "", $exclude = "") //filter array data based on published date, status, category, exclude category, exclude ID and limit
	{	
		if ($date != 0) $data = $this->filter_alldata_date($data);
		if ($status != 0) $data = $this->filter_alldata_status($data);
		if ($cat) $data = $this->filter_alldata_by_cat($data, $cat);
		if ($excat) $data = $this->filter_alldata_by_excat($data, $excat);
		if ($exclude) $data = $this->filter_alldata_by_exclude($data, $exclude);
		if ($limit != 0) $data = $this->filter_alldata_limit($data, $limit);
		
		return $data;	
	}
	
	function filter_topdata($data, $date = 0, $status = 0, $limit = 0, $cat = "", $exclude = "") //filter array data with Top 10 category based on published date, status, category, exclude ID and limit
	{	
		$data = $this->filter_alldata_by_top($data);
		if ($date != 0) $data = $this->filter_alldata_date($data);
		if ($status != 0) $data = $this->filter_alldata_status($data);
		if ($cat) $data = $this->filter_alldata_by_cat($data, $cat);
		if ($exclude) $data = $this->filter_alldata_by_exclude($data, $exclude);
		if ($limit != 0) $data = $this->filter_alldata_limit($data, $limit);
		
		return $data;	
	}
	
	function filter_alldata_by_exclude($data, $excludeid) //filter array data based on exclude ID
	{				
		$count = 0;
		foreach($data as $key => $value)
		{
			$matcharr = 0;
			foreach($excludeid as $key1 => $value1)
			{
				if ($value['article_id'] == $value1['article_id']) $matcharr = 1;
			}
			
			if ($matcharr == 0) $return[$count] = $value;
			$count++;
		}
		
		return $return;
	}
	
	function filter_alldata_by_top($data) //filter array data based on Top 10 category
	{
		$count = 0;
		foreach($data as $key => $value)
		{
			if ($value['article_top10'] == 1)
			{
				$return[$count] = $value;
			}
			$count++;
		}
		
		return $return;
	}
	
	function filter_alldata_by_cat($data, $cat) //filter array data based on category
	{
		$count = 0;
		foreach($data as $key => $value)
		{
			if ($value['catid'] == $cat)
			{
				$return[$count] = $value;
			}
			$count++;
		}
		
		return $return;
	}
	
	function filter_alldata_by_excat($data, $excat) //filter array data based on exclude category
	{
		$count = 0;
		foreach($data as $key => $value)
		{
			if ($value['catid'] != $excat)
			{
				$return[$count] = $value;
			}
			$count++;
		}
		
		return $return;
	}
	
	function filter_alldata_status($data) //filter array data based on status
	{
		$count = 0;
		foreach($data as $key => $value)
		{
			if ($value['article_status'] == 1)
			{
				$return[$count] = $value;
			}
			$count++;
		}
		
		return $return;
	}
	
	function filter_alldata_date($data) //filter array data based on published date
	{
		$count = 0;
		foreach($data as $key => $value)
		{
			if ($value['article_date_published'] <= time())
			{
				$return[$count] = $value;
			}
			$count++;
		}
		
		return $return;
	}
	
	function filter_alldata_limit($data, $limit) //filter array data based on number to be posted
	{
		$count = 0;
		foreach($data as $key => $value)
		{
			if ($count < $limit)
			{
				$return[$count] = $value;
			}
			$count++;
		}
		
		return $return;
	}
	
	/***************** QUERY RELATED FUNCTIONS ******************/
	
	function getflashbox() 
	{
		
		$sql = "SELECT object_id AS article_id FROM pagelayout WHERE parent = 47 AND status = 1 ORDER BY ID LIMIT 0, 5";
		
		$result = $this->get_artrow($sql, 4);				
			
		return $result;
	}	
	
	function gettop10forindex($limit, $datefrom, $dateto, $exclude = "", $cat = "", $random = "")
	{
		$sql = "SELECT a.article_id, a.article_title, a.article_title_id, a.article_blurb, a.article_content, a.article_date_published, 
				a.article_image, a.article_thumb_image
				FROM spot_articles a, spot_articles_channels b
				WHERE a.article_status = 1 
				AND a.article_id = b.article_id ";
				if ($datefrom != 0) {
					$sql .= " AND a.article_date_published >= ".$datefrom."
					AND a.article_date_published <= ".$dateto." ";
				}
				
				if(isset($exclude) && !empty($exclude)) {
					if(is_array($exclude)) {
						$sql .= " AND a.article_id NOT IN ( ";
						$csql = 0;
						foreach($exclude as $value2) 
						{
							if ($csql == 0) { $sql .= $value2['article_id']; }
							else { $sql .= ", ".$value2['article_id']; }
							$csql++;
						}
						$sql .= " ) ";
					} 
				}
		
		if(isset($cat) && !empty($cat)) {
			$sql .= " AND b.channels_id = ".$cat;
		}
		else {
			$sql .= "AND b.channels_id IN (1622, 1623, 1624, 1625, 11132, 23755, 23987, 19329, 23985, 23989, 23988, 19331) ";
		}
		$sql .= " AND a.article_date_published <= UNIX_TIMESTAMP()
				
				AND b.type = 1
				AND b.status = 1 ";
				
		if(isset($random) && !empty($random)) {
			$sql .= " ORDER BY RAND() ";
		}
		else {
			$sql .= " ORDER BY a.article_date_published DESC ";
		}
		$sql .= " LIMIT 0, ".$limit;
		
		$result = $this->get_row($sql, 1);				
			
		return $result;
	}
	
	function get_alldata($limit)
	{
		$sql="SELECT a.article_id, a.article_title, a.article_title_id, a.article_blurb, 
			a.article_image, a.article_thumb_image, a.article_date_published, a.article_status, b.channels_id AS catid
			FROM spot_articles a, spot_articles_channels b
			WHERE a.article_id = b.article_id
			AND b.channels_id IN (1622, 1623, 1624, 1625, 11132, 23755, 23987, 19329, 23985, 23989, 23988, 19331) 
			AND b.type = 1
			AND b.status = 1	
			ORDER BY a.article_date_published DESC
			LIMIT 0, ".$limit;
		
		$result = $this->get_artrow($sql, 1);				
			
		return $result;
	}
	
	function get_allfeed($limit)
	{
		$sql="SELECT a.article_id, a.article_title, a.article_title_id, a.article_blurb, a.article_image, a.article_thumb_image, a.article_date_published, a.article_status, b.channels_id AS catid
			FROM spot_articles a, spot_articles_channels b
			WHERE a.article_id = b.article_id
			AND b.channels_id IN (17479) 
			AND b.type = 1
			AND b.status = 1	
			ORDER BY a.article_date_published DESC
			LIMIT 0, ".$limit;
		
		$result = $this->get_artrow($sql, 1);				
			
		return $result;
	}
	
	
	function get_allid($limit)
	{
		$sql="SELECT a.article_id, a.article_top10, a.article_date_published, a.article_status, b.channels_id AS catid
			FROM spot_articles a, spot_articles_channels b
			WHERE a.article_id = b.article_id
			AND b.channels_id IN (1622, 1623, 1624, 1625, 11132, 23755, 23987, 19329, 23985, 23989, 23988, 19331) 
			AND b.type = 1
			AND b.status = 1
			ORDER BY a.article_date_published DESC
			LIMIT 0, ".$limit;
		
		$result = $this->get_artrow($sql, 1);				
			
		return $result;
	}
	
	function get_artdata($id)
	{
		$sql="SELECT a.article_id, a.article_title, a.article_title_id, a.article_blurb, a.article_image, a.article_thumb_image, a.article_date_published, a.article_status
			FROM spot_articles a
			WHERE a.article_id = ".$id."
			AND a.article_status = 1 
			AND a.article_date_published <= NOW()
			LIMIT 0, 1";
		
		$result = $this->get_artrow($sql, 1);				
			
		return $result;
	}
	
	function get_artblog($cat)
	{
		$sql="SELECT a.article_id, a.article_title, a.article_title_id, a.article_blurb, a.article_image, a.article_thumb_image, a.article_date_published, b.channels_id AS catid
			FROM spot_articles a, spot_articles_channels b
			WHERE a.article_id = b.article_id
			AND a.article_status = 1 
			AND a.article_date_published <= UNIX_TIMESTAMP()
			AND b.channels_id = '".$cat."'
			AND b.type = 1
			AND b.status = 1
			ORDER BY a.article_date_published DESC
			LIMIT 0, 1";
		
		$result = $this->get_row($sql, 1);				
			
		return $result;
	}
	
	function get_artid($id)
	{
		$sql="SELECT a.article_id
			FROM spot_articles a
			WHERE a.article_id = ".$id."
			AND a.article_status = 1 
			AND a.article_date_published <= NOW()
			LIMIT 0, 1";
		
		$result = $this->get_row($sql, 1);				
			
		return $result;
	}
	
	function get_article_by_id($id)
	{
		$sql = "SELECT article_id, article_title, article_title_id, article_blurb, article_date_published, 
				article_image, article_thumb_image
				FROM spot_articles
				WHERE article_id = ".$id." 
				AND article_status = 1 
				AND article_date_published <= NOW()
				LIMIT 0, 1";
		
		$result = $this->get_row($sql, 1);				
			
		return $result;
	}
	
	function getpopulararticle($category_id, $datefrom, $dateto, $limit)
	{		
		$sql="SELECT a.article_id, a.article_title, a.article_title_id, a.article_image, a.article_thumb_image, a.article_date_published,
				a.article_views AS view_count
				FROM spot_articles a, spot_articles_channels b
				WHERE a.article_id = b.article_id
				AND a.article_date_published >= '".$datefrom."'
				AND a.article_date_published <= '".$dateto."'
				AND a.article_status = 1
				AND b.type = 1
				AND b.status = 1";
														
				if(isset($category_id) && !empty($category_id) && $category_id != 0)
				{
					if(is_array($category_id)) {$sql .= " AND b.channels_id IN ( ";
						$catsql = 0;
						foreach($category_id as $valuecat) 
						{
							if ($catsql == 0) { $sql .= $valuecat; }
							else { $sql .= ", ".$valuecat; }
							$catsql++;
						}
						$sql .= " ) ";
					}
					else
					{
						$sql .= " AND b.channels_id = ".$category_id;					
					}
				}
				else
				{
					$sql .= " AND b.channels_id IN (1622, 1623, 1624, 1625, 11132, 23755, 23987, 19329, 23985, 23989, 23988, 19331) "	;
				}
		$sql .= " LIMIT 0, ".$limit;

		$result = $this->get_row($sql, 1);				
		
		return $result;
	}
	
	function getpoparticle($artid)
	{		
		$sql="SELECT a.article_id, a.article_title, a.article_thumbnail, a.article_title_id, a.article_image, a.article_large_image, a.article_image, a.article_thumb_image, a.article_date_published, 
				a.article_views AS view_count
				FROM spot_articles a
				WHERE a.article_id = ".$artid."
				LIMIT 0, 1";

		$result = $this->get_row($sql, 1);				
		
		return $result;
	}
	
	function getsharearticle($category_id, $datefrom, $dateto, $limit)
	{		
		$sql="SELECT a.article_id, a.article_title, a.article_title_id, a.article_image, a.article_thumb_image, a.article_date_published, a.article_share
				FROM spot_articles a, spot_articles_channels b
				WHERE a.article_id = b.article_id
				AND a.article_date_published >= ".$datefrom."
				AND a.article_date_published <= ".$dateto."
				AND a.article_status = 1
				AND a.article_share != 0
				AND b.type = 1
				AND b.status = 1";
				
				if(isset($category_id) && !empty($category_id) && $category_id != 0)
				{
					if(is_array($category_id)) {$sql .= " AND b.channels_id IN ( ";
						$catsql = 0;
						foreach($category_id as $valuecat)
						{
							if ($catsql == 0) { $sql .= $valuecat; }
							else { $sql .= ", ".$valuecat; }
							$catsql++;
						}
						$sql .= " ) ";
					}
					else
					{
						$sql .= " AND b.channels_id = ".$category_id;					
					}
				}
				else
				{
					$sql .= " AND b.channels_id IN (1622, 1623, 1624, 1625, 11132, 23755, 23987, 19329, 23985, 23989, 23988, 19331) "	;
				}
		$sql .= " LIMIT 0, ".$limit;
		
		var_dump($sql);

		$result = $this->get_row($sql, 1);				
		
		return $result;
	}
	
	function getshaarticle($artid)
	{		
		$sql="SELECT a.article_id, a.article_title, a.article_title_id, a.article_image, 
				a.article_thumb_image, a.article_date_published, a.article_share
				FROM spot_articles a
				WHERE a.article_id = ".$artid."
				AND a.article_share != 0
				LIMIT 0, 1";

		$result = $this->get_row($sql, 1);				
		
		return $result;
	}
	
	function get_category_slug($id)
	{		
		$sql = "SELECT spot_channels.*
						FROM spot_channels
							LEFT JOIN spot_articles_channels ON (spot_channels.channels_id = spot_articles_channels.channels_id)
						WHERE spot_articles_channels.type = 1
							AND spot_articles_channels.article_id = ".$id."
							AND spot_articles_channels.status = 1 
							AND spot_articles_channels.channels_id <> 1626
							AND spot_channels.channels_parent = 0
						GROUP BY spot_channels.channels_id
						ORDER BY spot_channels.channels_name ASC
						";
						
		$result = $this->get_row($sql, 0);				
		
		return $result;
	}

	function get_comment($media_type, $id)
	{
		$sql = "SELECT COUNT(comment_id) AS total_comment FROM spot_comment.spot_comments WHERE type_id=".$media_type." AND post_id = ".$id." AND comment_status = 1";
		
		$result = $this->get_row($sql, 0);		
		return $result[0]["total_comment"];
	}
	
	function get_moodname($mood_id){
		
		$sql = "SELECT mood_name FROM moods
			 WHERE mood_id = ".$mood_id."
			 AND status = 1
			 LIMIT 1";
			 
		$result = $this->get_row($sql, 0);		
		return $result;
	}
	
	function maxmood($article_id, $mood_id = "") {
		
		$sql = "SELECT COUNT(mood_id) AS moodcount, mood_id FROM mood_article
			 WHERE article_id = ".$article_id;
		if ($mood_id) $sql .= " AND mood_id = ".$mood_id;
		$sql .= " GROUP BY mood_id ORDER BY moodcount DESC LIMIT 1";
			 
		$result = $this->get_row($sql, 8);		
		return $result[0]['mood_name'];
	}
		
	/***************** MISCELLEANNOUS *****************/
	
	function pagination($section, $record, $limit, $range = 9){
	  // $paged - number of the current page
	  global $paged;
		$web_root = ROOT;
		
		$pagetxt = "";
		
	  // How much pages do we have?
		$paged = $_GET['page'] ? $_GET['page'] : "1";
	
		$max_num_pages = ceil($record/$limit);
	
		if (!$max_page) {
			$max_page = $max_num_pages;
		}

	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
		if(!$paged){
		  $paged = 1;
		}
		
		// On the first page, don't put the First page link
		if($paged != 1){
		  $pagetxt .= "<a href='".$web_root."/".$section."/page/1' class = 'roboto blacktext mediumtext2 nodecor'><i class='icon-double-angle-left'></i>&nbsp;&nbsp;&nbsp;</a>";
		  $prev_var = $_GET['page'] ? $_GET['page'] - 1 : "0"; //previous page_num
		  $pagetxt .= "<a href='".$web_root."/".$section."/page/".$prev_var."' class = 'roboto blacktext mediumtext2 nodecor'>Previous&nbsp;&nbsp;&nbsp;</a>";
		}
		
		// We need the sliding effect only if there are more pages than is the sliding range
		if($max_page > $range){
		  // When closer to the beginning
		  if($paged < $range){
				for($i = 1; $i <= ($range + 1); $i++){
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext mediumtext2'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext mediumtext2'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		  // When closer to the end
		  elseif($paged >= ($max_page - ceil(($range/2)))){
				for($i = $max_page - $range; $i <= $max_page; $i++){
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext mediumtext2'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext mediumtext2'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		  // Somewhere in the middle
		  elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))) {
				for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++) {
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext mediumtext2'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext mediumtext2'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		}
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
				$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
				if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext mediumtext2'>".$i."</div>";
				else $pagetxt .= "<div class = 'pagelink blacktext mediumtext2'>".$i."</div>";				
				$pagetxt .= "</a>";
		  }
		}
	
		
		// On the last page, don't put the Last page link
		if($paged != $max_page){
			$next_var= $_GET['page'] ? $_GET['page'] + 1 : "2"; //next page_num
			$pagetxt .= "<a href='".$web_root."/".$section."/page/".$next_var."' class = 'roboto blacktext mediumtext2 nodecor'>&nbsp;&nbsp;&nbsp;Next</a>";
			$pagetxt .= "<a href='".$web_root."/".$section."/page/".$max_page."' class = 'roboto blacktext mediumtext2 nodecor'>&nbsp;&nbsp;&nbsp;<i class='icon-double-angle-right'></i></a>";
		}
	  }
		
		return $pagetxt;
	}
	
	function cleanuserinput($input)
	{
		if (get_magic_quotes_gpc()) {
			$clean = mysqli_real_escape_string(stripslashes($input));
		}
		else
		{
			$clean = mysqli_real_escape_string($input);
		}
		return $clean;
	}
	
	function cleanpostvar($getvar)
	{		
		$conn = $this->db_connect();
		$str = $conn->real_escape_string($getvar);
		return $str;
	}

	function cleanpostname($input, $reverse=false)
	{

		if($reverse==true) {
			$str = $input;		
			$str = str_replace("ï¿½", "&rsquo;", $str);
			$str = str_replace("ÃƒÂ©", "&eacute;", $str);
			$str = str_replace("â€¦ ï¿½", "&nbsp;", $str);
			$str = str_replace("â€¦", "&nbsp;", $str);
			$str = str_replace("&amp;", "&", $str);
			$str = str_replace("&quot;", "\"", $str);
			$str = str_replace("&rsquo;", "'", $str);
			$str = str_replace("ï¿½", "&ntilde;", $str);
			$str = str_replace("ï¿½", "&eacute;", $str);			
			$str = str_replace("ï¿½", "&Eacute;", $str);			
			$str = str_replace("ï¿½", "&hellip;", $str);
			$str = str_replace("ï¿½", "&nbsp;", $str);
			$str = str_replace("Ã©", "&eacute;", $str);				
			$str = str_replace("Ã±", "&ntilde;", $str);			
			$str = str_replace("Ã'", "&Ntilde;", $str);			
			$str = str_replace("ï¿½", "&Ntilde;", $str);
			$str = str_replace("&nbsp;", " ", $str);
			$str = str_replace("â€™", "'", $str);			
			$str = stripslashes($str);
		} else {
			$str = stripslashes($input);
			$str = str_replace("&amp;", "&", $str);
			$str = str_replace("&quot;", "\"", $str);
			$str = str_replace("&rsquo;", "'", $str);
			$str = str_replace(" ", "-", $str);
			$str = str_replace("&ntilde;", "n", $str);
			$str = str_replace("&eacute;", "ï¿½", $str);			
			$str = str_replace("&hellip;", "", $str);						
			$str = stripslashes(urldecode(html_entity_decode($str)));
			$str = preg_replace("/[^a-zA-Z0-9-]/", "", urldecode($str));
		}

		return $str;
	}
	
	function get_logs($artid)
	{		
		$sql = "SELECT a.log_content, a.log_date, b.user_firstname, b. user_lastname
			 FROM logs a, users b
			 WHERE b.ID = a.user_id
			 AND a.object_id = $artid
			 AND a.log_status = 1
			 AND a.log_deleted = 0";
		$record = mysqli_query($con, $sql);
		while($row = mysqli_fetch_assoc($record)) {
			$result[] = $row;
		
		}
		mysqli_free_result($record);
		return $result;
	}
	
	function activate_directory_tab($link,$tab)
	{
		if($link == $tab)
		{
			return 'class="dir_link current"';
		}else{
			return 'class="dir_link"';
		}	
	}
	
	function truncate($string, $length)
	{
		if (strlen($string) <= $length) {
			$string = $string; //do nothing
			}
		else {
			$string = wordwrap($string, $length);
			$string = substr($string, 0, strpos($string, "\n"));
			$string .= '...';
		}
		return $string;
	}
	
	function filter_bad_comments($comment, $username=false)
	{
	
		
		if ($username == false)
		{
			$replace_with = "***THIS COMMENT HAS BEEN DELETED DUE TO VIOLATION OF SPOT.PH'S TERMS AND CONDITIONS.***";
		}else{
			$replace_with = "***";
		}

		$badwords = array( "pokpok", " kupal ", " slut\."," kups ", "fucker"," slut ", " pucha ", " tae ", "bullshit", "shit", " shit\.", " gago ", " puta ", " tangina ", " tonto ", " tang ", " asshole ", "fuck", "pekpek", " titi ", " etits ", " tits ", " penis ", " vagina ", "pudayday", " puday ", " kepyas ", "kepkep", " dede ", "tarantado", "bitch", " hosto ", " Ass ", "Ass wipe", "Biatch", " Bitches ", "Biatches", "Beyotch", "Bulbol", "Bolbol",  " Boobs ", " Cunt ", "Callboy", "Callgirl", " Clit ", " Douche bag ", "Dumb ass", " Dodo ", " Dipshit ", " Dung face ", " Echas ", " Fag ", " Hoe ", " Hooker ", "Jakol", "Jackol", " Kunt ", "Kantot", "Putang ina", " Pussy ", " Prat ", " Prick ", " Satan ", " Shit ", " Ulol ", " puke ", " puki ", "kakantutin", "kakantuten", "makantot", " Ass "," Echas "," Tits ","Asshole","Fuck","Tang ina"," Ass wipe "," Fag ","Tarantado"," Bitch "," Gago ","Biatch"," Ulol "," Bitches "," Ulul "," Biatches "," Gagi "," Utong ","Beyotch"," Hoe ","Beeyotch"," Hooker ","Bulbol","Haliparot"," Bolbol "," Jakol "," Boobs "," Jackol ","Bullshit"," Kunt ","Kantot"," Cunt "," Nigger ","Pakshit","Pokpok","Putang ina","Callboy"," Puta ","Callgirl"," Puerta "," Clit "," Pwerta ","Chimi a a"," Pussy ","Douche bag"," Prat "," Prick ","Dumb ass"," Satan "," Dodo "," Doofus "," Shit ","Dipshit"," Dung face "," ebs ","kanguso","kapangilya","p0kp0k","p0t@"," fcuk "," pwet "," pwit ","haliparot","lawlaw", "pokpok", "Pokpok", "showbizjuice", " Pwe ", "Pweh", " pwe ", "pwe\!", "pweh", "fuck ", " fuck", "Fuck ", " Fuck", " fuck ", " Fuck ", "fuck", "Fuck", " Faggot ", " faggot ", "Faggot ", "faggot ", " Faggot", " faggot", " echusera ", " Echusera ", " Ngoyngoy ", " ngoyngoy ", "Ngoyngoy ", "ngoyngoy ", " Ngoyngoy", " ngoyngoy", "Ngoyngoy", "ngoyngoy", "pwe ", "pwe.", " che ", " bitch\.", "crap");	
	
		$bw_exp = "";
		$badword_match = 0;
		foreach ($badwords as $badwords_exp) {
		//echo $value;
		$bw_exp="/" . $badwords_exp ."/i";
		
			if (preg_match($bw_exp, $comment)) {
				$badword_match = $badword_match + 1;
			}
		}	
			
		if($badword_match > 0)
		{
			return $replace_with;
		}else{
			return $comment;
		}
	
	}

}
?>