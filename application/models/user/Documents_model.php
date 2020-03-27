<?PHP
require_once __DIR__ . "/constants.php";

class Documents_model  extends BaseMySQL_model
{


	public function __construct()
	{
		parent::__construct(TABLE_KYC);

	}

	public function do_upload($uId, $type, $file, $orig_name)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
//        print_r($config['file_name']);
		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, TRUE);
		}

		$this->load->library('upload', $config);
//        $this->upload->initialize($config);

		if (!$this->upload->do_upload($type)) {
			$error = array('error' => $this->upload->display_errors());
			return $error;
		} else {
			$data = $this->upload->data();
			return $config['upload_path'] . $data['file_name'];
		}
	}
}
	?>
