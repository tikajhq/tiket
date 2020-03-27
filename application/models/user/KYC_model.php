<?PHP
require_once __DIR__ . "/constants.php";
require_once __DIR__ . "/Documents_model.php";
class KYC_model extends Documents_model
{


	public function __construct()
	{
		parent::__construct(TABLE_KYC);
	}

	public function getKYCDocuments($uid)
	{
		$res = array();
		$doc_res = $this->db->get_where(TABLE_KYC, array('uid' => $uid))->result_array();
		foreach ($doc_res as $doc)
			$res[$doc['type']] = $doc;

		return $res;
	}

	public function getPendingKYCApprovals()
	{
		$query = $this->db->query("SELECT  users.*, count(kyc.type) as not_verified, GROUP_CONCAT(kyc.type) as types from kyc LEFT JOIN users ON users.id = kyc.uid WHERE kyc.status=0  GROUP BY uid;");
		return $query->result_array();
	}

	public function getApprovedKYC()
	{
//		$query = $this->db->query("SELECT  users.*, count(kyc.type) as verified, GROUP_CONCAT(kyc.type) as types from kyc LEFT JOIN users ON users.id = kyc.uid WHERE kyc.status=1  GROUP BY uid;");

		// since only KYCs which are fully approved are required, summing all status and only sum of 4 is selected as fully approved
		$query = $this->db->query("SELECT * FROM (SELECT users.*, count(kyc.type) as verified, GROUP_CONCAT(kyc.type) as types, SUM(kyc.status) as status_sum from kyc LEFT JOIN users ON users.id = kyc.uid GROUP BY uid) AS R WHERE R.status_sum >= ".CLIENT_MINIMUM_KYC_REQUIRED);
		return $query->result_array();
	}

	public function approveKYCDocuments($uid, $docs)
	{
		$approve_doc = array();
		foreach($docs as $doc_type=>$status)
		{
			if($status == 'on')
				array_push($approve_doc, $doc_type);
		}

		return $this->db->where('uid', $uid)->where_in('type', $approve_doc)->update(TABLE_KYC, array('status' => 1));
	}


	public function uploadKYC($data, $files, $post){
		$res = array();

		// check aadhar duplicate
		if(isset($_POST['aadhar_front_primary_aadhar_no'])){
			$dup_check = $this->db->get_where(TABLE_KYC, array('type'=>'aadhar_front', 'title' => $_POST['aadhar_front_primary_aadhar_no']))->result_array();
			if(count($dup_check) && $dup_check[0]['uid']!= $data['uid']){
				return -1;
			}
		}


		$doc_res = $this->db->get_where(TABLE_KYC, array('uid' => $data['uid']))->result_array();
		foreach ($doc_res as $doc)
			$res[$doc['type']] = $doc;
		foreach(KYC_DOCUMENTS as $kyc_doc => $details){
			$update = array();
			$name = $kyc_doc;
			if(isset($files[$kyc_doc]) && $files[$kyc_doc]['tmp_name'] ) {

				$file = $files[$kyc_doc];
				if ($file['tmp_name']) {
					$file_path = $this->do_upload($data['uid'], $name, $file['tmp_name'], $file['name']);

				} else {
					$file_path = null;
				}
				$path = explode('./', $file_path);
				if (count($path) > 1)
					$path = $path[1];
				else
					$path = $path[0];

				$update = array("path" => $path);
			}

			if(isset($post[$details['primary']]))
				$update['title'] = $post[$details['primary']];
			// if doc already exists in db, update the path


			if(isset($res['meta']))
				$meta= json_decode($res['meta']);
			else
				$meta = array();


			foreach($details['fields'] as $field)
			{
				if(isset($post[$field]))
					$meta[$field] = $post[$field];
			}

			$update['meta'] = json_encode($meta);

			if(isset($res[$name]) && !empty($update))
				$this->db->where(array("uid"=> $data['uid'], "type" => $name))->update(TABLE_KYC, $update);
			else if(!empty($update))
				$this->db->insert(TABLE_KYC, array_merge($update, array("uid" => $data['uid'], "type" => $name)));


		}
		return;
	}


	// being used in loan module, usage must be replaced by new method - FYA @udit
	public function uploadKYCOld($data, $files, $post){
		$res = array();
		$doc_res = $this->db->get_where(TABLE_KYC, array('uid' => $data['uid']))->result_array();
		foreach ($doc_res as $doc)
			$res[$doc['type']] = $doc;
		foreach(CLIENT_KYC_DOCUMENTS as $kyc_doc => $title){
			$update = array();
			$name = $kyc_doc;
			if(isset($files[$kyc_doc]) && $files[$kyc_doc]['tmp_name'] ) {
				$file = $files[$kyc_doc];
				if ($file['tmp_name']) {
					$file_path = $this->do_upload($data['uid'], $name, $file['tmp_name'], $file['name']);
				} else {
					$file_path = null;
				}
				$path = explode('./', $file_path);
				if (count($path) > 1)
					$path = $path[1];
				else
					$path = $path[0];

				$update = array("path" => $path);

				if(trim($path) != '')
				{
					$update['status'] = 1;
				}
				else
				{
					$update['status'] = 0;
				}
			}

			if(isset($post[$kyc_doc.'_txt']))
				$update['title'] = $post[$name.'_txt'];
			// if doc already exists in db, update the path
			// Status as approved


			if(isset($res[$name]) && !empty($update))
				$this->db->where(array("uid"=> $data['uid'], "type" => $name))->update(TABLE_KYC, $update);
			else if(!empty($update))
				$this->db->insert(TABLE_KYC, array_merge($update, array("uid" => $data['uid'], "type" => $name)));

		}

		return;
	}




	public function makeDatatableQuery($table, $context, $db, $arguments = null)
	{
		// kyc.status=0
		$db->join('users as u', 'u.id = '.TABLE_KYC.'.uid', 'left');
		$db->group_by(TABLE_KYC.'.uid');
		return array(
			'columns' => array(
				'not_verified'=>'count('.TABLE_KYC.'.type)',
				'types'=>'GROUP_CONCAT(kyc.type)',
				'userid' => 'u.id',
				'username' => 'u.name',
				
			),
		);
	}



}
?>
