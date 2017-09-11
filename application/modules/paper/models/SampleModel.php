<?php
// コンポーネントをロードする
require_once SYSTEM_DIR . '/modules/common/AppModel.php';

class SampleModel extends AppModel
{
	public function saveDetail($paramerters)
	{
		$sql = "insert into sample VALUES ('" . $paramerters["uuid"]       . "'," . 
								   "'" . $paramerters["sequenceId"] . "'," .
								         $paramerters["pointx"]     . ","  . 
								         $paramerters["pointy"]     . ","  . 
								         $paramerters["sizex"]      . ","  . 
								         $paramerters["sizey"]      . ","  . 
								   "'" . $paramerters["biaoqian"]   . "'," . 
								   "'" . $paramerters["content"]    . "' " .
		")";
		
		$results = $this->getDb()->query($sql);
		
		return $results;
	}
	
	public function getDetail($uuid)
	{
		$sql = "select * from sample where uuid = '" . $uuid. "'order by uuid, sequenceid";
		
		$results = $this->getDb()->fetchAll($sql);
		
		return $results;
	}
	
	public function delDetail($paramerters)
	{
		$sql = "delete from sample where uuid = '" . $paramerters["uuid"]. "' and sequenceid = '" . $paramerters["sequenceId"]. "'";
		
		$results = $this->getDb()->query($sql);
		
		return $results;
	}
	
	public function updateDetail($paramerters)
	{
		$sql = "update sample 
                   set pointx = " . $paramerters["pointx"] . "
                     , pointy = " . $paramerters["pointy"] . "
                     , sizex  = " . $paramerters["sizex"]  . "
                     , sizey  = " . $paramerters["sizey"]  . "
                     , biaoqian  = '" . $paramerters["biaoqian"] . "'
                     , content   = '" . $paramerters["content"]  . "' 
                where uuid       = '" . $paramerters["uuid"]     . "' 
                  and sequenceid = '" . $paramerters["sequenceId"]. "'";
		
		$results = $this->getDb()->query($sql);
		
		return $results;
	}
}