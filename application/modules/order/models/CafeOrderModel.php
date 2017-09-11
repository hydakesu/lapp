<?php
// コンポーネントをロードする
require_once SYSTEM_DIR . '/modules/common/AppModel.php';

class CafeOrderModel extends AppModel
{
	public function getOrgsArray($key = "", $limit = 0, $offset= 0, $sortdatafield = "", $sortorder = "")
	{
		if(empty($key)){
			$sql =  " select group_id       " .
					"      , group_nm_local " .
					"      , group_nm_enus  " .
					"      , to_char(expire_date      , 'yyyy-mm-dd') as expire_date      ".
					"      , to_char(register_datetime, 'yyyy-mm-dd') as register_datetime".
					"      , register_user_id ".
					"      , to_char(update_datetime  , 'yyyy-mm-dd') as update_datetime  ".
					"      , update_user_id   ".
					"  from  uac_group        ";
		}else{
			$sql =  " select group_id       " .
					"      , group_nm_local " .
					"      , group_nm_enus  " .
					"      , to_char(expire_date      , 'yyyy-mm-dd') as expire_date      ".
					"      , to_char(register_datetime, 'yyyy-mm-dd') as register_datetime".
					"      , register_user_id ".
					"      , to_char(update_datetime  , 'yyyy-mm-dd') as update_datetime  ".
					"      , update_user_id   ".
					"  from  uac_group        ".
					" where  group_id like   '". $key . "%'";
		}
		
		if((empty($sortdatafield) || !isset($sortdatafield)) && (empty($sortorder) || !isset($sortorder))){
			$sql = $sql . " order by group_id";
		}else{
			$sql = $sql . " order by  " . $sortdatafield . " " . $sortorder;
		}
		
		if(isset($limit) && $limit > 0){
			$sql = $sql . " limit  " . $limit;
		}
		
		if(isset($offset) && $offset> 0){
			$sql = $sql . " offset " . $offset;
		}
		
		$results = $this->getDb()->fetchAll($sql);
		
		return $results;
	}
	
	public function getOrgsCount($key = "")
	{
		if(empty($key)){
			$sql = "select count(*) as count from uac_group ";
		}else{
			$sql = "select count(*) as count from uac_group where group_id like '" . $key . "%' ";
		}
		
		$results = $this->getDb()->fetchOne($sql);
		
		return $results;
	}

}