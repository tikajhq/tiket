<?php

class common_model extends CI_Model
{

    //-------------------File Upload-----------------//
    function member_image()
    {
        $config['upload_path'] = "assets/img/";
        $config['allowed_types'] = "gif|jpg|jpeg|png|pdf|doc|docx|xlsx|xml|zip|txt";
        $config['max_size'] = "5000";
        $config['max_width'] = "5000";
        $config['max_height'] = "5000";
        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $finfo = $this->upload->data();
        $fileupload = ($finfo['raw_name'] . $finfo['file_ext']);
        return $fileupload;
    }

    //-------------------File Upload-----------------//
    //-------------------Form Status-----------------//
    //----------------------Get member name--------------------------//
    function get_member_name($id = null)
    {
        $this->db->where('associate_code', trim($id));
        $this->db->or_where('or_m_member_id', trim($id));
        $query = $this->db->get('m09_member_detail');
        $row = $query->row();
        if ($query->num_rows() == 1)
            return trim($row->or_m_name);
        else
            return "-1";  // RETURN ARRAY WITH ERROR
    }


    function get_member_id($searchPhrase)
    {
        $this->db->select('or_m_member_id, or_m_name')->like('or_m_name', $searchPhrase)->limit(10);
        $query = $this->db->get('m09_member_detail');
        $result = $query->result_array();
        return $result;
    }

    //----------------------Get member name--------------------------//

    /* -------------------- Get Cities --------------------  */
    function get_city($id = '')
    {
        $state = $this->input->post('ddstate');
        $data = [
            'proc' => 5,
            'loc_id' => 0,
            'loc_name' => $id,
            'parent_id' => $state,
            'status' => 1
        ];
        $query = " CALL SP_STATES(?" . str_repeat(",?", count($data) - 1) . ") ";
        $datas = $this->db->query($query, $data);
        mysqli_next_result($this->db->conn_id);
        $json = json_encode($datas->result());
        return $json;
    }

    /* -------------------- Get Cities --------------------  */

    //---------------------Get Branch Address-------------------//
    function get_branchaddress()
    {
        $state = $this->input->post('ddbranchcode');
        $datas = $this->db->query("select * from view_users where or_m_reg_id=" . $state . "");
        $json = json_encode($datas->result());
        return $json;
    }

    //---------------------Get Branch Address-------------------//
    //---------------------Check Mobile No.-------------------//
    function check_mobile($mobile = '')
    {
        if ($mobile != "") {
            $this->db->where('or_m_mobile_no', $mobile);
            $data['mob'] = $this->db->get('m09_member_detail');
            if ($data['mob']->num_rows() > 0) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    //---------------------Check Mobile No.-------------------//
    //---------------------Check Pancard No.-------------------//
    function check_pancard($pancard = '')
    {
        if ($pancard != "") {
            $this->db->where('or_m_b_pancard', $pancard);
            $data['mob'] = $this->db->get('m10_member_bank');
            if ($data['mob']->num_rows() > 0) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    //---------------------Check Pancard No.-------------------//
    //---------------------Check Associate ID.-------------------//
    function check_associate_id($aff_id = '', $login = '')
    {
//        if ($aff_id != '' || $aff_id != 0)
//            $query = $this->db->get_where('m09_member_detail', array('or_m_member_id' => $login, 'or_m_status' => 1, 'or_m_aff_id' => $aff_id));
//        else
        $query = $this->db->get_where('m09_member_detail', ['or_m_member_id' => $login]);

        $row = $query->row();

        if ($query->num_rows() > 0) {
            return $row->or_m_reg_id;
        } else {
            return 0;
        }
    }

    //---------------------Check Associate ID.-------------------//

    function view_edit_member_registration()
    {
        $data['serial_form'] = [];
        $data['pin'] = [];
        $data['publish'] = [];
        $data['package'] = [];
        $data['serial_form'] = [];


        $data['bank'] = $this->db->query("select * from m13_bank where m_bank_status=1");

        $data['designation'] = $this->db->query("select * from m02_designation where m_des_pat_id=2");

        //$data['pin']=$this->db->query("select * from m16_pin_detail");

        $data['proof'] = $this->db->query("SELECT * FROM m40_proof WHERE m_proof_status=1");

        $member_id = $this->uri->segment(3);

        //	$data['serial_form']=$this->db->query("select * from tr09_stock_details where tr_st_det_memid=$member_id");

        $data['detail'] = $this->db->query("select * from m09_member_detail");

        //$data['publish']=$this->db->query("select * from tr16_afterpublish_detail where or_m_reg_id=$member_id");

        $condition = "`m09_member_detail`.`or_m_reg_id`='$member_id'";

        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $data['update'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    //---------------------Select Plan Detail.-------------------//
    function plan1()
    {
        $qry = "`p_plan_id`=" . $this->input->post('ddplan') . "";
        $datas = [
            'proc' => 2, 'plan_id' => '',
            'mst_pl_id' => '', 'plan_code' => '',
            'plan_name' => '',
            'plan_deposit_term' => '',
            'plan_maturity_term' => '',
            'plan_unit' => '',
            'plan_intrst_r_gen' => '',
            'plan_intrst_r_spcl' => '',
            'plan_onetime' => '',
            'plan_daily' => '',
            'plan_weekly' => '',
            'plan_monthly' => '',
            'plan_quaterly' => '',
            'plan_halfyearly' => '',
            'plan_yearly' => '',
            'plan_pre_maturerate' => '',
            'plan_prematureterm' => '',
            'plan_spot' => '',
            'plan_entry_type' => '',
            'plan_status' => '',
            'querey' => $qry
        ];

        $query = " CALL SP_MAIN_PLANS(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        $json = json_encode($data->result());
        return $json;
    }

    function plan($qry = 1)
    {
        $datas = [
            'proc' => 2,
            'plan_id' => '',
            'mst_pl_id' => '',
            'plan_code' => '',
            'plan_name' => '',
            'plan_deposit_term' => '',
            'plan_maturity_term' => '',
            'plan_unit' => '',
            'plan_intrst_r_gen' => '',
            'plan_intrst_r_spcl' => '',
            'plan_onetime' => '',
            'plan_daily' => '',
            'plan_weekly' => '',
            'plan_monthly' => '',
            'plan_quaterly' => '',
            'plan_halfyearly' => '',
            'plan_yearly' => '',
            'plan_pre_maturerate' => '',
            'plan_prematureterm' => '',
            'plan_spot' => '',
            'plan_entry_type' => '',
            'plan_status' => '',
            'querey' => $qry
        ];

        $query = " CALL SP_MAIN_PLANS(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function plan_detail($plan_type = '')
    {
        $condition = "";
        $id = "";
        $mem_id = "";

        $data['sub_plan'] = $this->common_model->plan("`p01_plan_type`.`p_plantype_id`='$plan_type' and `p02_plan`.`p_plan_status` = 1");
        // free_db_resource;

        if ($this->uri->segment(3) != "") {
            $mem_id = $this->uri->segment(3);
            $id = $this->mastermodel->get_associdfrom_mem($mem_id);
            $data['id'] = $this->mastermodel->get_associdfrom_mem($mem_id);
            $condition = "`m09_member_detail`.`or_m_reg_id`='$id'";
            $datas = [
                'querey' => $condition,
                'proc' => 1
            ];
            $query = "CALL sp_report_mem_detail(?,?)";
            $data['mem_info'] = $this->db->query($query, $datas);

            mysqli_next_result($this->db->conn_id);
        }
        return $data;
    }

    function plan_booking_report($brancid = '')
    {
        $id = $condition = '';
        $data['type'] = $this->db->get('p01_plan_type');
        $data['or_m_name'] = $this->db->get("view_users");
        if ($this->input->post('txtfromdate') != '' && $this->input->post('txtfromdate') != '0' && $this->input->post('txttodate') != '' && $this->input->post('txttodate') != '0') {
            $condition = $condition . "DATE_FORMAT(`m18_plan_booking`.`plan_book_date`,'%Y-%m-%d') BETWEEN DATE_FORMAT('" . $this->input->post('txtfromdate') . "','%Y-%m-%d') and  DATE_FORMAT('" . $this->input->post('txttodate') . " ','%Y-%m-%d') AND ";
        }

        if ($this->input->post('txtassociateid') != '' && $this->input->post('txtassociateid') != '0') {
            $condition = $condition . " `m09_member_detail_1`.`associate_code`= '" . $this->input->post('txtassociateid') . "' and";
        }

        if ($this->input->post('txtcustomerid') != '' && $this->input->post('txtcustomerid') != '0') {
            $condition = $condition . " `m09_member_detail`.`customer_code`= '" . $this->input->post('txtcustomerid') . "' and";
        }

        if ($brancid != '' && $brancid != '-1') {
            $condition = $condition . " `m09_member_detail`.`or_m_aff_id`= '" . $brancid . " ' and";
        }
        if ($this->input->post('txtbookingid') != '' && $this->input->post('txtbookingid') != '-1') {
            $condition = $condition . " `m18_plan_booking`.`plan_contract_id`= '" . $this->input->post('txtbookingid') . " ' and";
        }
        if ($this->input->post('ddtype') != '' && $this->input->post('ddtype') != '-1') {
            $condition = $condition . " `m18_plan_booking`.`plan_type`= '" . $this->input->post('ddtype') . " ' and";
        }

        $u_type = $this->get_session('user_type');
        $profile_id = $this->get_session('profile_id');
        $affid = $this->get_session('affid');
        $cnd = '';
        if ($u_type != 1) {
            if ($u_type == 3)
                $cnd = " and m18_plan_booking.branch_id = $affid and m18_plan_booking.member_id = $profile_id";
            else
                $cnd = " and  m18_plan_booking.branch_id = $affid ";
        }


        $condition = $condition . " `m18_plan_booking`.`plan_status`=1 $cnd";

        $clsdt = [
            'proc' => 1,
            'querey' => $condition
        ];
        $query = "CALL sp_all_planbook(?,?)";
        $data['maturity'] = $this->db->query($query, $clsdt);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    //---------------------Count Installment .-------------------//
    function date_ins()
    {
        $ddmode = $this->input->post("ddmode");
        $terms = $this->input->post("terms");
        $cr_date = $this->input->post("dates");
        if ($ddmode != 7) {
            $query = $this->db->query("SELECT get_installment_dates('$cr_date',0,'$ddmode') as ins");
            $rowss = $query->row();
            return $rowss->ins;
        } else {
            $query = $this->db->query("SELECT get_installment_dates('$cr_date','$terms','$ddmode') as ins");
            $rowss = $query->row();
            return $rowss->ins;
        }
    }

    //Get member details
    function get_member_name1($id = '')
    {
        $query = $this->db->get_where('m09_member_detail', ['or_m_member_id' => trim($id), 'or_m_status' => 1, 'user_type' => 4]);
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $json = json_encode($query->result());
            return $json;
        } else {
            return 0;
        }
    }


    //-------------------------------------Get member details ---------------------//
    function get_associate_name($id = '')
    {
        $this->db->where('or_m_member_id', trim($id));
        $this->db->or_where('associate_code', trim($id));
        $query = $this->db->get_where('view_member');
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $json = json_encode($query->result());
            return $json;
        }
    }

    //-------------------------------------Get details from member---------------------//
    function get_details_from_mem($mem_id = '')
    {
        $id = $this->mastermodel->get_associdfrom_mem($mem_id);
        $condition = "`m09_member_detail`.`or_m_reg_id`='$id'";
        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $data['mem_info'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        $json = json_encode($data['mem_info']->result());
        return $json;
    }

    //---------------------------Get member branch details --------------------------//
    function get_assoc_branch($id = '')
    {
        $query = $this->db->get_where('view_users', ['or_m_reg_id' => trim($id)]);
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $json = json_encode($query->result());
            return $json;
        }
    }

    //---------------------------Saving Account details --------------------------//
    function get_saving_detail($userid = '')
    {
        $data = $this->db->query("SELECT Get_saving_detail('" . $userid . "') as idss")->row();
        return $data->idss;
    }

    function get_saving_account($userid = '')
    {
        $data = $this->db->query("SELECT * FROM `m18_plan_booking` WHERE `m18_plan_booking`.`plan_type`=4 AND `m18_plan_booking`.`customer_id`=(SELECT `m09_member_detail`.`or_m_reg_id` FROM `m09_member_detail` WHERE `m09_member_detail`.`or_m_member_id`='" . $userid . "')");
        $json = json_encode($data->result());
        return $json;
    }

    function check_account_bal($plan_book_id = '')
    {
        $data = $this->db->query("SELECT get_saving_balance(1,'$plan_book_id') as Account_bal")->row();
        if ($data->Account_bal >= 10) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_savingaccount_bal()
    {
        $plan_book_id = $this->input->post('account_num');
        $data = $this->db->query("SELECT get_saving_balance(1,'$plan_book_id') as Account_bal")->row();
        if ($data->Account_bal >= $this->input->post('amount')) {
            return 1;
        } else {
            return 0;
        }
    }

    //---------------------------Saving Account details --------------------------//
    //---------------------------Get Plan Book Id --------------------------//
    function get_plan_book_id()
    {
        $contract_id = $this->input->post('txtcontract_id');
        $this->db->select('plan_book_id');
        $this->db->where('plan_contract_id', $contract_id);
        $query = $this->db->get('m18_plan_booking');
        if ($query->num_rows() == 1) {
            $rowss = $query->row();
            return $rowss->plan_book_id;
        } else {
            return 0;
        }
    }


    public function total_booked_plan()
    {
        $rows = $this->db->query("SELECT COUNT(t1.plan_type)as tt,t2.p_symble FROM `m18_plan_booking` AS t1 LEFT JOIN `p01_plan_type` AS t2 ON(t2.p_plantype_id = t1.plan_type) GROUP BY t1.plan_type")->result();

        if (empty($rows)) {
            return json_encode([]);
        }


        foreach ($rows as $r) {
            $d[$r->p_symble] = $r->tt;
        }

        return json_encode($d);
    }


    public function count_plans($type, $alies)
    {

        $id = $this->session->userdata('user_type');
        $affid = $this->session->userdata('affid');
        $cnd = '';

        //print_r($this->session->userdata);

        if ($id != 1) {

            if ($id == 3) {
                $cnd = " and branch_id = " . $this->session->userdata('affid') . " and member_id = " . $this->session->userdata('profile_id');
            } else
                $cnd = " and branch_id = " . $this->session->userdata('profile_id');

        }


        return $this->db->query("SELECT COUNT(plan_book_id) as $alies FROM `m18_plan_booking` WHERE plan_type = $type $cnd")->row();

    }

    public function count_member_type($type)
    {
        $id = $this->session->userdata('user_type');
        $cnd = '';

        if ($id != 1) {

            if ($id == 3) {
                $cnd = " and or_m_aff_id = " . $this->session->userdata('affid') . " and member_id = " . $this->session->userdata('profile_id');
            } else
                $cnd = " and or_m_aff_id = " . $this->session->userdata('profile_id');

        }

        return $this->db->query("SELECT COUNT(or_login_id) FROM `view_users` WHERE or_user_type = $type $cnd")->row();

    }


    //------------------------------------------ Master Index ----------------------------------------//
    function index()
    {
        //$this->db->query('DROP TABLE IF EXISTS temp_total_renuals');
        $data['fd'] = $this->count_plans(1, 'fd');

        // echo $this->db->last_query();die;

        $data['rd'] = $this->count_plans(2, 'rd');


        $data['mis'] = $this->count_plans(3, 'mis');

        $data['dc'] = $this->count_plans(7, 'dc');


        $data['svg'] = $this->count_plans(4, 'svg');


        $data['agent'] = $this->count_member_type(5);;

        $data['customer'] = $this->count_member_type(4);;


        $data['branch'] = $this->count_member_type(2);;


        $data['branch_emp'] = $this->count_member_type(3);;


        $data['members'] = $this->count_member_type(4);;


//        $data['total_deposit'] = $this->db->query("SELECT get_plan_user(8,0,'0') as total_deposit")->row();
//
//
//        $data['total_withdrawal'] = $this->db->query("SELECT get_plan_user(9,0,'0') as total_withdrawal")->row();


        $data['renewal'] = $this->collect_total_renewal();

        $data['user'] = $this->db->query("SELECT COUNT(`or_m_reg_id`) AS users, SUM(`or_m_no_of_share`) AS shares FROM `m09_member_detail`")->row();
        return $data;
    }

    public function collect_total_renewal()
    {
        //$this->db->query(" CALL sp_total_today_renual('" . CURRENT_DATE . "','" . CURRENT_DATE . "',1);");

//         $row = $this->db->query("SELECT (SELECT (CONCAT(SUM(plan_amounts) ,',', (IFNULL((
// SELECT SUM(m_amount) FROM `tr10_project_payment`  WHERE  m_pay_date = CURRENT_DATE AND m_project_id = project_id ),0)))) FROM temp_total_renuals WHERE plan_type = 'DC' ) AS dc_amount, (SELECT (concat(SUM(plan_amounts),',',(IFNULL((
// SELECT SUM(m_amount) FROM `tr10_project_payment`  WHERE  m_pay_date = CURRENT_DATE AND m_project_id = project_id ),0)))) FROM temp_total_renuals WHERE plan_type = 'RD') AS rd_amount;
//")->row_array();

        $row = 0;
        if (!empty($row)) {
            return $row;
        } else {
            return ['dc_amount' => '0.00', 'rd_amount' => '0.00'];
        }
    }

    /* -------------------------- Agent Commision Entry---------------------- */

    function view_agent_commision_entry()
    {
        $data['agent_commision_entry'] = $this->db->get('agent_commision_entry');
        $data['rank_master'] = $this->db->get('rank_master');
        $data['plan_type_master'] = $this->db->get('plan_type_master');
        $data['sub_plan_type_master'] = $this->db->get('sub_plan_type_master');
        $data['plan_master'] = $this->db->get('plan_master');
        return $data;
    }

    /* --------------------- Select State by id --------------------- */

    function select_state($id = '')
    {
        $datas = [
            'proc' => 2,
            'loc_id' => $id,
            'loc_name' => '',
            'parent_id' => 1,
            'status' => 0
        ];
        $query = " CALL SP_STATES(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data['resul'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    /* --------------------- Select Rank by id --------------------- */

    function select_rank_master($id = '')
    {
        $datas = [
            'proc' => 2,
            'des_id' => $id,
            'des_name' => '',
            'des_pat_id' => '',
            'des_user_id' => '',
            'des_orid' => '',
            'des_status' => '',
            'des_show_to_client' => ''
        ];
        $query = " CALL SP_RANK(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data['resul'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function select_penality_master()
    {
        $id = $this->uri->segment(3);
        $data['penality'] = $this->penality();
        $datas = [
            'proc' => 2,
            'fine_id' => $id,
            'fine_installment_name' => '',
            'fine_installment_type' => '',
            'fine' => '',
            'fine_status' => 1
        ];
        $query = " CALL SP_FINE(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data['resul'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function penality()
    {
        return $this->db->get('p06_fine');
    }

    /* -------------------- Start Branch Functions --------------------  */

    function view_branch_master()
    {

        $datas = [
            'proc' => 1,
            'aff_id' => "0",
            'aff_code' => "0",
            'or_m_name' => "0",
            'aff_address' => "0",
            'aff_conatct_person' => '0',
            'aff_contact_no' => '0',
            'aff_email' => '0',
            'aff_password' => '0',
            'aff_state' => '0',
            'aff_city' => '0',
            'aff_entry_date' => CURRENT_DATE,
            'aff_status' => '0'
        ];
        $query = " CALL SP_BRANCH(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data['resul'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function select_branch_master()
    {
        $id = $this->uri->segment(3);
        $datas = [
            'proc' => 3,
            'aff_id' => $id,
            'aff_code' => '',
            'or_m_name' => '',
            'aff_address' => '',
            'aff_conatct_person' => '',
            'aff_contact_no' => '',
            'aff_email' => '',
            'aff_password' => '',
            'aff_state' => '',
            'aff_city' => '',
            'aff_entry_date' => '',
            'aff_status' => ''
        ];
        $query = " CALL SP_BRANCH(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data['branch'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    /* -------------------- Start Branch User Functions --------------------  */

    function view_create_user()
    {

        $data['designation'] = $this->db->query("select * from m02_designation where m_des_pat_id=-1");
        $datas = [
            'proc' => 2,
            'br_user_id' => '0',
            'br_id' => '0',
            'br_desig' => '0',
            'br_user' => '0',
            'br_username' => '0',
            'br_password' => '0',
            'br_address' => '0',
            'br_mobile' => '0',
            'br_status' => '0'
        ];
        $query = "CALL SP_BRANCHUSER(?" . str_repeat(",?", count($datas) - 1) . ")";
        $data['branchuser'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function select_create_user()
    {
        $id = $this->uri->segment(3);

        $data['designation'] = $this->db->query("select * from m02_designation where m_des_pat_id=2");
        $datas = [
            'proc' => 3,
            'br_user_id' => $id,
            'br_id' => '0',
            'br_desig' => '0',
            'br_user' => '0',
            'br_username' => '0',
            'br_password' => '0',
            'br_address' => '0',
            'br_mobile' => '0',
            'br_status' => '0'
        ];
        $query = "CALL SP_BRANCHUSER(?" . str_repeat(",?", count($datas) - 1) . ")";
        $data['update'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    /* -------------------- End Branch User Functions --------------------  */

    /* --------------------- Start Vendor----------------------------------  */

    function view_create_vendor()
    {
        $data['vendor_code'] = $this->vendor_code();
        $data = [
            'proc' => 2,
            'ven_id' => '0',
            'ven_code' => '0',
            'ven_name' => '0',
            'ven_mobile' => '0',
            'ven_email' => '0',
            'ven_state' => '0',
            'ven_city' => '0',
            'ven_address' => '0',
            'ven_join_date' => '0',
            'ven_status' => ''
        ];

        $query = "CALL SP_VENDOR(?" . str_repeat(",?", count($data) - 1) . ")";
        $data['vendor'] = $this->db->query($query, $data);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function select_create_vendor()
    {
        $id = $this->uri->segment(3);
        $data1 = [
            'proc' => 3,
            'ven_id' => $id,
            'ven_code' => '0',
            'ven_name' => '0',
            'ven_mobile' => '0',
            'ven_email' => '0',
            'ven_state' => '0',
            'ven_city' => '0',
            'ven_address' => '0',
            'ven_join_date' => '0',
            'ven_status' => '0'
        ];
        $query = "CALL SP_VENDOR(?" . str_repeat(",?", count($data1) - 1) . ")";
        $data['update'] = $this->db->query($query, $data1);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function select_plan_master()
    {
        $id = $this->uri->segment(3);
        $this->db->where('plan_master_id', $id);
        $data['update'] = $this->db->get('plan_master');
        $data['plan_type_master'] = $this->db->get('plan_type_master');
        $data['sub_plan_type_master'] = $this->db->get('sub_plan_type_master');
        $data['plan_master'] = $this->db->get('plan_master');
        return $data;
    }

    //---------------------------------------------------------------------------------//
    //----------------------- Start Memebr Controller ----------------------------------//
    //---------------------------------------------------------------------------------//
    function view_member_registration()
    {

        $data['count'] = $this->db->query("SELECT COUNT(*) as no_mem FROM `m09_member_detail`");
        $data['bank'] = $this->db->query("select * from m13_bank where m_bank_status=1");
        $data['proof'] = $this->db->query("SELECT * FROM m40_proof WHERE m_proof_status=1");
        $data['form_number'] = $this->db->query("SELECT or_m_reg_id FROM m09_member_detail")->num_rows();
        return $data;
    }

    function get_parent_detail()
    {
        $i = "";
        $lrt = 0;
        $rrt = 0;
        $t = 0;
        $id1 = $this->input->post('txtintuserid');
        $i = $this->mastermodel->get_associdfrom_mem($id1);
        if ($i != "") {
            $id = $i;
            $jleg = $this->input->post('leg');
            if ($jleg == "L") {
                return trim($this->mastermodel->fetchl($id));
            }
            if ($jleg == "R") {
                return trim($this->mastermodel->fetchr($id));
            }
        } else {
            return "This ID is not registered";
        }
    }

    function get_pins($pack = '', $intro = '')
    {
        $this->db->where('m_pin_status', 1);
        $this->db->where('m_pack_id', $pack);
        $this->db->where('m_pin_assigned_to', $intro);
        $data['pins'] = $this->db->get('m16_pin_detail');
        $json = json_encode($data['pins']->result());
        return $json;
    }

    function get_pin_amount($ddpackage = '')
    {
        $this->db->where('m_pack_id', $ddpackage);
        $data['pin_amount'] = $this->db->get('m15_package');
        $json = json_encode($data['pin_amount']->result());
        return $json;
    }

    function get_customer_name($id = '')
    {
        $query = $this->db->get_where('m09_member_detail', ['customer_code' => trim($id)]);
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $json = json_encode($query->result());
            return $json;
        }
    }

    function view_all_members($branch = '0', $fx)
    {
        if ($branch > 0)
            $this->db->where('or_m_reg_id', $branch);

        $data['aff'] = $this->db->get('view_users');
        $condition = '';

        if (!empty($this->input->post('txtfromjoiningdate')) && !empty($this->input->post('txtfromjoiningdate')) && !empty($this->input->post('txttojoiningdate')) && !empty($this->input->post('txttojoiningdate'))) {
            $date1 = date_create($this->input->post('txttojoiningdate'));
            $condition = $condition = $condition . "DATE_FORMAT(`m09_member_detail`.`or_m_regdate`,'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($this->input->post('txtfromjoiningdate'))) . "' and  '" . date_format($date1, 'Y-m-d') . "' AND ";
        }

        if (!empty($this->input->post('txtcustomerid')) && !empty($this->input->post('txtcustomerid'))) {
            $condition = $condition . " `m09_member_detail`.`or_m_member_id`= '" . $this->input->post('txtcustomerid') . " ' and";
        }

        if (!empty($this->input->post('txtcustomername')) && !empty($this->input->post('txtcustomername'))) {
            $condition = $condition . " `m09_member_detail`.`or_m_name`= '" . $this->input->post('txtcustomername') . "' and";
        }

        if (!empty($this->input->post('txtmobileno')) && !empty($this->input->post('txtmobileno'))) {
            $condition = $condition . " `m09_member_detail`.`or_m_mobile_no`= '" . $this->input->post('txtmobileno') . "' and";
        }

        if (!empty($branch)) {
            $condition = $condition . " `m09_member_detail`.`or_m_aff_id`= '" . $branch . " ' and";
        }

        $condition = $condition . " `m09_member_detail`.`or_m_status`=1 and tr01_login.or_user_type = 4 " . $fx;

        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];


        $query = "CALL sp_report_mem_detail(?,?)";
        $data['data'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);


        return $data;
    }

    public function view_edit_customer_detail($member_id = '')
    {

        $data['bank'] = $this->db->query("select * from m13_bank where m_bank_status=1");
        $data['designation'] = $this->db->query("select * from m02_designation where m_des_pat_id=2");
        $condition = "`m09_member_detail`.`or_m_reg_id`='$member_id'";
        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $data['update'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function get_tree()
    {
        $reg_id = 1;
        if ($this->input->post('search_id') != '' || $this->input->post('search_id') != '0') {
            $this->db->where('or_m_member_id', trim($this->input->post('search_id')));
            $data['rec'] = $this->db->get('m09_member_detail');
            foreach ($data['rec']->result() as $row) {
                $reg_id = $row->or_m_reg_id;
                break;
            }
        }
        return $reg_id;
    }

    function associate_direct_referal()
    {
        $data['info'] = $this->db->query("CALL sp_direct_referal(-1)");
        $data['uid'] = "";
        $data['uid1'] = "";
        $data['e'] = $this->uri->segment(3);
        return $data;
    }

    function search_associate_direct()
    {
        $team = -1;
        $id = $this->mastermodel->get_uid($this->input->post('distributor_id'));
        if ($id == "" || $id == 0) {
            $id = -1;
        }
        $data['uid'] = $this->input->post('distributor_id');
        $data['uid1'] = $id;
        $data['e'] = $this->uri->segment(3);
        $data['info'] = $this->db->query("CALL sp_direct_referal(" . $id . ")");
        return $data;
    }

    function search_associate_downline()
    {
        $team = -1;
        $id = $this->mastermodel->get_uid($this->input->post('distributor_id'));
        if ($id == "" || $id == 0) {
            $id = -1;
        }
        $data['uid'] = $this->input->post('distributor_id');
        $data['uid1'] = $id;
        $data['e'] = $this->uri->segment(3);
        $p = "L";
        $p1 = "R";
        $lyt = "";
        $ryt = "";
        if ($this->input->post('ddposition') == 'L' || $this->input->post('ddposition') == "1") {
            $lyt = $id . $this->mastermodel->fetchleft($id, $p, 2);
            // free_db_resource;
        }
        if ($this->input->post('ddposition') == 'R' || $this->input->post('ddposition') == "1") {
            $ryt = $id . $this->mastermodel->fetchright($id, $p1, 2);
            // free_db_resource;
        }
        $UID = $lyt . $ryt;
        $query = "SELECT
			`m09_member_detail`.`or_m_member_id`         AS `Login_Id`,
			`m09_member_detail`.`or_m_name`      AS `Associate_Name`,
			`m09_member_detail`.`or_m_regdate`   AS `Joining_Date`,
			`m01_location_1`.`m_loc_name`      AS `City`,
			`m01_location`.`m_loc_name`      AS `State`,
			`m09_member_detail_2`.`or_m_member_id`         AS `Upliner_Id`,
			(CASE WHEN (`m09_member_detail`.`or_m_position`='L' )THEN 'LEFT'  WHEN (`m09_member_detail`.`or_m_position`='R' )THEN 'RIGHT' ELSE `m09_member_detail`.`or_m_position` END)    AS `Position`
			FROM ((((((`m09_member_detail`
			LEFT JOIN `tr01_login`
			ON (((`m09_member_detail`.`or_m_reg_id` = `tr01_login`.`or_user_id`)
			AND (`m09_member_detail`.`or_m_member_id` = `tr01_login`.`or_login_id`))))
			LEFT JOIN `m01_location`
			ON ((`m09_member_detail`.`or_m_state` = `m01_location`.`m_loc_id`)))
			LEFT JOIN `m01_location` `m01_location_1`
			ON ((`m09_member_detail`.`or_m_city` = `m01_location_1`.`m_loc_id`)))
			LEFT JOIN `m09_member_detail` `m09_member_detail_1`
			ON ((`m09_member_detail`.`or_m_intr_id` = `m09_member_detail_1`.`or_m_reg_id`)))
			LEFT JOIN `m09_member_detail` `m09_member_detail_2`
			ON ((`m09_member_detail`.`or_m_upliner_id` = `m09_member_detail_2`.`or_m_reg_id`)))
			LEFT JOIN `m16_pin_detail`
			ON ((`m09_member_detail`.`m_pin_id` = `m16_pin_detail`.`m_pin_id`))
			LEFT JOIN `m10_member_bank`
			ON ((`m09_member_detail`.`or_m_reg_id` = `m10_member_bank`.`or_m_id`))
			LEFT JOIN `m13_bank`
			ON ((`m13_bank`.`m_bank_id` = `m10_member_bank`.`or_m_b_name`)))
			WHERE `m09_member_detail`.`or_m_reg_id` IN ($UID) ORDER BY `m09_member_detail`.`or_m_reg_id` ASC";

        $data['info'] = $this->db->query($query);
        return $data;
    }

    function upload_image()
    {
        if ($this->uri->segment(3) != "") {
            $this->db->where('or_m_member_id', $this->uri->segment(3));
            $data['image'] = $this->db->get('m09_member_detail');
            $rows = $data['image']->row();
            $image = $rows->or_m_idproof;
            if ($image == "") {
                $config['upload_path'] = "application/libraries/signature";
                $config['allowed_types'] = "gif|jpg|jpeg|png|pdf|doc|docx|xlsx|xml|zip|txt";
                $config['max_size'] = "5000";
                $config['max_width'] = "5000";
                $config['max_height'] = "5000";
                $this->load->library('upload', $config);
                $this->upload->do_upload();
                $finfo = $this->upload->data();
                $fileupload = ($finfo['raw_name'] . $finfo['file_ext']);
                return $fileupload;
            } else {
                unlink("application/libraries/signature/" . $image);
                $config['upload_path'] = "application/libraries/signature";
                $config['allowed_types'] = "gif|jpg|jpeg|png|pdf|doc|docx|xlsx|xml|zip|txt";
                $config['max_size'] = "5000";
                $config['max_width'] = "5000";
                $config['max_height'] = "5000";
                $this->load->library('upload', $config);
                $this->upload->do_upload();
                $finfo = $this->upload->data();
                $fileupload = ($finfo['raw_name'] . $finfo['file_ext']);
                return $fileupload;
            }
        }
    }

    function update_edit_registration()
    {
        $datas = [
            'or_m_category' => 1,
            'or_m_member_id' => $this->input->post('txtassociate'),
            'or_m_designation' => '00',
            'or_m_name' => $this->input->post('txtmemname'),
            'or_m_dob' => date('Y-m-d', strtotime($this->input->post('txtdob'))),
            'or_m_gurdian_name' => $this->input->post('txtfathername'),
            'or_member_joining_date' => CURRENT_DATE,
            'or_m_gender' => $this->input->post('ddgender'),
            'or_m_email' => $this->input->post('txtemail'),
            'or_m_landline_no' => '',
            'or_m_mobile_no' => $this->input->post('txtmobile'),
            'or_m_address' => $this->input->post('txtaddress'),
            'or_m_pincode' => $this->input->post('txtpincode'),
            'or_m_country' => 1,
            'or_m_state' => $this->input->post('ddstate'),
            'or_m_memberimage' => $this->input->post('member_image'),
            'signimage' => $this->input->post('hdproof'),
            'or_m_city' => $this->input->post('ddcity'),
            'or_m_status' => 1,
            'm_intr_id' => $this->mastermodel->get_associdfrom_mem($this->input->post("txtintroducer_id")),
            'or_m_intr_name' => $this->input->post('txtintroducer_name'),
            'or_m_aff_id' => $this->input->post('ddbranch'),
            'or_m_upliner_id' => $this->mastermodel->get_associdfrom_mem($this->input->post("txtintroducer_id")),
            'or_m_position' => 'L',
            'm_pin_id' => $this->input->post('ddpin'),
            'or_m_idproof' => $this->input->post('ddidproof'),
            'or_m_idproof_no' => $this->input->post('txtidproofnum'),
            'or_m_add_proof' => $this->input->post('txtaddproof'),
            'or_m_add_proof_no' => $this->input->post('txtaddrproofnum'),
            'or_m_regdate' => CURRENT_DATE,
            'or_m_n_name' => $this->input->post('txtnomineename'),
            'or_m_n_parent_name' => '',
            'or_m_n_address' => $this->input->post('txtnomineadd'),
            'or_m_n_dob' => date('Y-m-d', strtotime($this->input->post('txtnomineeage'))),
            'or_m_n_gender' => '',
            'or_m_n_relation' => $this->input->post('txtnominerelation'),
            'or_m_n_status' => 1,
            'or_m_n_state' => '',
            'or_m_n_city' => '',
            'or_m_b_ifscode' => $this->input->post('txtifsc'),
            'or_m_b_cbsacno' => $this->input->post('txtaccountno'),
            'or_m_b_name' => $this->input->post('ddbank'),
            'or_m_b_branch' => $this->input->post('txtbankbranchname'),
            'or_m_b_pancard' => $this->input->post('txtpan'),
            'or_login_pwd' => random_string('numeric', 7),
            'or_pin_pwd' => random_string('numeric', 7),
            'or_m_pd_mode' => $this->input->post('ddpayment_mode'),
            'txtpinamount' => $this->input->post('txtpinamount'),
            'or_m_pd_paydate' => $this->input->post('txtchequedate'),
            'or_m_pd_dd_no' => $this->input->post('txtcheque'),
            'or_m_pd_bankname' => $this->input->post('ddcheque_bank'),
            'or_m_pd_branchname' => $this->input->post('ddcheque_bank'),
            'paymentAmount' => $this->input->post('paymentAmount'),
            'paymentStatus' => $this->input->post('paymentStatus'),
            'paymentNaration' => $this->input->post('paymentNaration'),
            'or_m_pd_accno' => $this->input->post('txtaccount'),
            'or_m_pd_voucher' => $this->input->post('txtvoucherno'),
            'or_m_pd_status' => 1,
            'form_serial' => $this->input->post('txtform'),
            'or_m_no_of_share' => $this->input->post('txtshares'),
            'or_m_alter_share_prc' => $this->input->post('altertxtsharesprc'),
            'm_acc_id' => 3,
            'm_trans_id' => '',
            'm_pay_id' => '0',
            'm_acc_credit' => $this->input->post('txtpinamount'),
            'm_acc_debit' => '0.00',
            'm_acc_desc' => 'Income head credited',
            'm_acc_from_bal' => '0.00',
            'm_acc_curr_bal' => '0.00',
            'm_acc_date' => CURRENT_DATE,
            'saving_acc_id' => '',
            'proc' => 2,
            'member_id' => $this->session->userdata('member_id')
        ];
        $query = "CALL sp_add_member(?" . str_repeat(",?", count($datas) - 1) . ",@msg)";
        $this->db->query($query, $datas);
        mysqli_more_results($this->db->conn_id);
        return "true";
    }

    function view_activate_member($status = 0, $fx)
    {
        $condition = "`m09_member_detail`.`or_m_status`=" . $status . $fx;
        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $data['data'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function activate_member($id = '', $status = 1)
    {
        $ids = explode(',', $id);
        for ($i = 0; $i < count($ids); $i++) {
            $data = [
                'proc' => 1,
                'reg_id' => $ids[$i],
                'statuss' => $status
            ];
            $query = "call sp_deactive_member(?,?,?)";
            $this->db->query($query, $data);
            mysqli_next_result($this->db->conn_id);
        }
    }

    function bond_member()
    {
        $record = [
            'proc' => 1,
            'querey' => "`m09_member_detail`.`or_m_reg_id`!=0 ORDER BY `m09_member_detail`.`or_m_reg_id` DESC"
        ];
        $query = " CALL sp_customer_plan_booking(?" . str_repeat(",?", count($record) - 1) . ") ";
        $data['rid'] = $this->db->query($query, $record);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function approve_bond()
    {
        $record = [
            'tr_user_id' => $this->uri->segment(3),
            'plan_no' => $this->uri->segment(4)
        ];
        $query = " CALL insert_bond_into_table(?" . str_repeat(",?", count($record) - 1) . ") ";
        $this->db->query($query, $record);
        mysqli_next_result($this->db->conn_id);
    }

    function deactivate_bond()
    {
        $record = [
            'tr_status' => $this->uri->segment(4)
        ];
        $this->db->where('tr_user_id', $this->uri->segment(3));
        $this->db->where('tr_plan_no', $this->uri->segment(4));
        $this->db->update('tr17_bond_details', $record);
    }

    function get_user_nominee($id = '')
    {
        $query = $this->db->get_where('m09_member_detail', ['or_m_member_id' => trim($id)]);
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $query1 = $this->db->get_where('m11_member_nominee', ['or_m_id' => trim($row->or_m_reg_id)]);
            $json = json_encode($query1->result());
            return $json;
        }
    }

    function view_i_card($member_regid = 0)
    {
        $record = [
            'proc' => 1,
            'querey' => "`m09_member_detail`.`or_m_reg_id`  = '$member_regid'"
        ];
        $query = " CALL sp_associate(?,?) ";
        $data['rec'] = $this->db->query($query, $record);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    //---------------------------------------------------------------------------------//
    //----------------------- End  Memebr Controller ----------------------------------//
    //---------------------------------------------------------------------------------//

    function view_proof($type = '', $id = 0)
    {
        return $this->db->query("SELECT * FROM m40_proof WHERE (CASE WHEN '" . $type . "'!='' THEN (m_proof_type='" . $type . "') ELSE 1 END) AND (CASE WHEN '" . $id . "'!=0 THEN (m_proof_id=" . $id . ") ELSE 1 END)");
    }

    function valid_date($paydate = '')
    {
        $rows = $this->db->query("SELECT DATEDIFF(CURDATE(),'$paydate') AS diffrence")->row();
        if ($rows->diffrence >= 0) {
            if ($rows->diffrence <= 5) {
                $txtpaymentdate = 1;
            } else {
                $txtpaymentdate = 0;
            }
        } else {
            $txtpaymentdate = 0;
        }
        return $txtpaymentdate;
    }

    //---------------------------------------------------------------------------------//
    //----------------------- Start  Agent Controller ----------------------------------//
    //---------------------------------------------------------------------------------//
    function get_member_rank()
    {
        $memid = $this->mastermodel->get_associd($this->input->post('agent'));
        $query = $this->db->query("SELECT or_m_designation FROM m09_member_detail WHERE or_m_reg_id=" . $memid . " ");


        if ($query->num_rows() > 0) {
            $row = $query->row();
            $val = $row->or_m_designation;


            if ($val == 0) {
                $query2 = $this->db->query("SELECT * FROM m02_designation");
            } else {
                $query2 = $this->db->query("SELECT * FROM m02_designation WHERE m_des_id<$val");
            }
            if ($query2->num_rows() > 0) {
                $json = json_encode($query2->result());
                return $json;
            }
        }
    }

    function view_agent_registration()
    {
        $data['plans'] = $this->db->get_where('p01_plan_type', ['p_plantype_status' => 1]);
        $datas = [
            'proc' => 2,
            'plantype_id' => '',
            'planname' => '',
            'plan_type' => '',
            'plan_isinstall' => '',
            'plan_code' => '',
            'plantype_status' => ''
        ];

        $query = " CALL SP_PLANS(?" . str_repeat(",?", count($datas) - 1) . ") ";
        $data['resul'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_search_agent($branch = '')
    {
        $condition = "";

        $data['closing_date'] = $this->db->query("SELECT MAX(tr_closing_fromdate) AS from_date FROM tr16_closing_date")->row()->from_date;
        if ($this->input->post('txtfromjoiningdate') != '' && $this->input->post('txtfromjoiningdate') != '0' && $this->input->post('txttojoiningdate') != '' && $this->input->post('txttojoiningdate') != '0') {
            $condition = $condition . "DATE_FORMAT(`m09_member_detail`.`associate_date`,'%Y-%m-%d') BETWEEN DATE_FORMAT('" . date('Y-m-d', strtotime($this->input->post('txtfromjoiningdate'))) . "','%Y-%m-%d') and  DATE_FORMAT('" . date('Y-m-d', strtotime($this->input->post('txttojoiningdate'))) . "','%Y-%m-%d') AND ";
        }

        if ($this->input->post('txtagentid') != '' && $this->input->post('txtagentid') != '0') {
            $condition = $condition . " `m09_member_detail`.`associate_code`= '" . $this->input->post('txtagentid') . " ' and";
        }

        if ($this->input->post('txtcustomername') != '' && $this->input->post('txtcustomername') != '0') {
            $condition = $condition . " `m09_member_detail`.`or_m_name`= '" . $this->input->post('txtcustomername') . "' and";
        }

        if ($branch != '' && $branch != '-1') {
            $condition = $condition . " `m09_member_detail`.`or_m_aff_id`= '" . $branch . " ' and";
        }

        $condition = $condition . " `m09_member_detail`.`associate_code`!='' ";
        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $data['data'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function search_associate_team($aff = 0)
    {
        $team = 0;
        $id = $this->input->post('txtagentcode');

        if ($id != "") {
            $cust_id = $this->mastermodel->get_associd($id);
            $cust_id = ($cust_id != '' ? $cust_id : 0);

            $data1 = $this->db->query("CALL get_downline($cust_id)");
            mysqli_next_result($this->db->conn_id);
            $row2 = $data1->row()->qc;
            if ($row2 != "") {
                $team = $row2;
            } else {
                $team = 0;
            }
            return $this->view_consultant_team($team, $aff);
        } else {
            return $this->view_consultant_team();
        }
    }

    function view_consultant_team($team = 0, $aff = 0)
    {
        $query = " SELECT
			`m09_member_detail`.`or_m_reg_id`          		AS `or_m_reg_id`,
			`m09_member_detail`.`associate_code`           	AS `Associate_Id`,
			`m09_member_detail`.`or_m_name`              	AS `Associate_Name`,
			`m09_member_detail`.`or_m_gurdian_name`      	AS `Associate_FName`,
			`m09_member_detail`.`or_m_mobile_no`         	AS `Associate_MobileNo`,
			`m09_member_detail`.`or_member_joining_date`  	AS `Joining_date`,
			DATE_FORMAT(`m09_member_detail`.`or_m_regdate`,'%Y-%m-%d')    AS `Joining_Date`,
			`m02_designation`.`m_des_name`             		AS `Associate_Rank`,
			`view_users`.`or_m_name`           		AS `Branch_Name`,
			`view_users`.`or_m_member_id`           		AS `Branch_Code`,
			(CASE WHEN (`m09_member_detail`.`or_m_intr_id`=0) THEN 'SuperAdmin' ELSE (`m09_member_detail_1`.`associate_code`) END) AS Introducer_id,
			`m09_member_detail_1`.`or_m_name`              	AS `Introducer_name`,
			`m02_designation_1`.`m_des_name`       			AS `Introducer_rank`
			FROM ((`m09_member_detail`
			LEFT JOIN `m02_designation`
			ON ((`m09_member_detail`.`or_m_designation` = `m02_designation`.`m_des_id`)))
			LEFT JOIN `view_users`
			ON ((`m09_member_detail`.`or_m_aff_id` = `view_users`.`or_m_reg_id`))
			LEFT JOIN `m09_member_detail` AS `m09_member_detail_1`
			ON ((`m09_member_detail`.`or_m_intr_id` = `m09_member_detail_1`.`or_m_reg_id`))
			LEFT JOIN `m02_designation` AS  `m02_designation_1`
			ON ((`m09_member_detail_1`.`or_m_designation` = `m02_designation_1`.`m_des_id`))
			)
			WHERE `m09_member_detail`.`or_m_reg_id` IN ($team) AND `m09_member_detail`.`associate_code`  IS NOT NULL AND (CASE WHEN '" . $aff . "'!='0' THEN `view_users`.`or_m_reg_id`= " . $aff . " ELSE 1 END) ";
        $data['team'] = $this->db->query($query);
        return $data;
    }

    function get_redirect($branch = 0)
    {
        $action = 0;
        $agent = $this->input->post("agent");
        $plan = $this->input->post("ddplan");
        $query = $this->db->query("SELECT `Check_associate_customer`(1,'$agent',0) AS res;");
        $rowass = $query->row();
        if ($rowass->res == 0) {
            if ($plan != 0 && $plan != -1) {
                $this->db->where('p_plantype_id', $plan);
                $data['action'] = $this->db->get("p01_plan_type");
                if ($data['action']->num_rows() > 0) {
                    $rowacion = $data['action']->row();
                    $action = $rowacion->p_plan_actionname;
                    if ($branch != 0) {
                        $act2 = explode("/", $action);
                        $action = "affiliate/" . $act2['1'];
                    }
                } else {
                    $action = 0;
                }
            } else {


                $action = 'agent/member_convert_to_assosiates';
                if ($branch != 0) {
                    $action = 'affiliate/member_convert_to_assosiates';
                }
            }
        } else {
            $action = 0;
        }
        return $action;
    }

    function receipt()
    {
        $member_regid = 0;
        if ($this->uri->segment(3) != "")
            $member_regid = $this->uri->segment(3);

        $record = [
            'proc' => 1,
            'querey' => "`m09_member_detail`.`or_m_member_id`  = '" . $member_regid . "' "
        ];
        $query = " CALL sp_associate(?,?) ";
        $data['rec'] = $this->db->query($query, $record);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function promotion()
    {
        $agent_id = 0;
        $data["des"] = $data['update'] = [];
        if ($this->uri->segment(3) != "" && $this->uri->segment(3) != 0)
            $agent_id = $this->uri->segment(3);

        $condition = "";
        $this->db->where("or_m_reg_id", $agent_id);
        $data["res"] = $this->db->get("m09_member_detail");

        if ($data["res"]->num_rows() > 0) {
            $data["desig"] = $this->db->query("SELECT get_intro_desig(1,$agent_id) as design");
            $rowdesig = $data["desig"]->row();
            $intro_desig = ($rowdesig->design != '' ? $rowdesig->design : 16);

            $this->db->where("m_des_id <", $intro_desig);
            $data["des"] = $this->db->get("m02_designation");

            $condition = "`m09_member_detail`.`or_m_reg_id`= $agent_id";
            $datas = [
                'querey' => $condition,
                'proc' => 1
            ];
            $query = "CALL sp_report_mem_detail(?,?)";
            $data['update'] = $this->db->query($query, $datas);
            mysqli_next_result($this->db->conn_id);
        }
        return $data;
    }

    //---------------------------------------------------------------------------------//
    //----------------------- End  Agent Controller ----------------------------------//
    //---------------------------------------------------------------------------------//
    //---------------------------------------------------------------------------------//
    //----------------------- Start  Plan Book Controller ----------------------------------//
    //---------------------------------------------------------------------------------//
    function view_due_installment()
    {
        $data['bank'] = $this->db->query("select * from m13_bank where m_bank_status=1");
        $instalment_detail = [
            'id' => $this->uri->segment(3),
            'statuss' => 1
        ];
        $query = "CALL sp_renewal(?" . str_repeat(",?", count($instalment_detail) - 1) . ") ";
        $data['sub_plan'] = $this->db->query($query, $instalment_detail);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_mis_details()
    {

        $data['designation'] = $this->db->query("select * from m02_designation where m_des_pat_id=2");
        $data['plans'] = $this->db->get("p01_plan_type");
        $mis = [
            'id' => $this->uri->segment(3),
            'statuss' => 1
        ];
        $query = " CALL sp_renewal(?" . str_repeat(",?", count($mis) - 1) . ") ";
        $data['sub_plan'] = $this->db->query($query, $mis);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_rd_details()
    {

        $data['designation'] = $this->db->query("select * from m02_designation where m_des_pat_id=2");
        $data['plans'] = $this->db->get("p01_plan_type");
        $mis = [
            'id' => $this->uri->segment(3),
            'statuss' => 1
        ];
        $query = " CALL sp_renewal(?" . str_repeat(",?", count($mis) - 1) . ") ";
        $data['sub_plan'] = $this->db->query($query, $mis);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function financial_year()
    {
        $data['years'] = $this->db->get('tr30_financial_year');
        $data['from_date'] = $this->db->query("SELECT IFNULL(DATE_ADD(MAX(tr_to_date),INTERVAL 1 DAY),'2017-03-01') AS to_date  FROM tr30_financial_year ")->row()->to_date;

        return $data;
    }

    //---------------------------------------------------------------------------------//
    //----------------------- Start  Plan Book Controller ----------------------------------//
    //---------------------------------------------------------------------------------//
    //--------------------- -----------------------------------------------------------//
    /* ------------------------- Start Loan Master ------------------------------------- */
    //--------------------- -----------------------------------------------------------//
    function view_loan_plan()
    {
        $data['loan_plan'] = $this->db->query("CALL sp_loan_plan_detail('1')");
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function select_loan_plan()
    {
        $data['loan_plan'] = $this->db->query("CALL sp_loan_plan_detail('1')");
        mysqli_next_result($this->db->conn_id);
        $id = $this->uri->segment(3);
        $condition = "`ml01_loan_plan`.`ml_loanplan_id`='$id'";
        $datas = [
            'queryy' => $condition
        ];
        $query = "CALL sp_loan_plan_detail(?)";
        $data['update'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_pupose_category()
    {
        $condition = "`ml02_purpose_category`.`ml_pur_cat_parent_id`=0";
        $datas = [
            'proc' => 1,
            'queryy' => $condition
        ];
        $query = "CALL sp_pupose_cate_detail(?,?)";
        $data['purpose_cate'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_update_pupose_category()
    {
        $data['category'] = $this->db->get_where('ml02_purpose_category', ['ml_pur_cat_parent_id' => 0, 'ml_pur_cat_status' => 1]);
        $condition = "`ml02_purpose_category`.`ml_pur_cat_parent_id`=0";
        $datas = [
            'proc' => 1,
            'queryy' => $condition
        ];
        $query = "CALL sp_pupose_cate_detail(?,?)";
        $data['purpose_cate'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        $id = $this->uri->segment(3);
        $condition2 = "`ml02_purpose_category`.`ml_pur_cat_id`=$id";
        $datas2 = [
            'proc' => 1,
            'queryy' => $condition2
        ];
        $query2 = "CALL sp_pupose_cate_detail(?,?)";
        $data['update'] = $this->db->query($query2, $datas2);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_pupose_type()
    {
        $data['category'] = $this->db->get_where('ml02_purpose_category', ['ml_pur_cat_parent_id' => 0, 'ml_pur_cat_status' => 1]);
        $condition = "`ml02_purpose_category`.`ml_pur_cat_parent_id`>0";
        $datas = [
            'proc' => 2,
            'queryy' => $condition
        ];
        $query = "CALL sp_pupose_cate_detail(?,?)";
        $data['purpose_cate'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_update_pupose_type()
    {
        $data['category'] = $this->db->get_where('ml02_purpose_category', ['ml_pur_cat_parent_id' => 0, 'ml_pur_cat_status' => 1]);
        $condition = "`ml02_purpose_category`.`ml_pur_cat_parent_id` > 0";
        $datas = [
            'proc' => 2,
            'queryy' => $condition
        ];
        $query = "CALL sp_pupose_cate_detail(?,?)";
        $data['purpose_cate'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);

        $id = $this->uri->segment(3);
        $condition2 = "`ml02_purpose_category`.`ml_pur_cat_id`=$id";
        $datas2 = [
            'proc' => 2,
            'queryy' => $condition2
        ];
        $query2 = "CALL sp_pupose_cate_detail(?,?)";
        $data['update'] = $this->db->query($query2, $datas2);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_customer_registration()
    {
        $data['category'] = $this->db->get_where('ml02_purpose_category', ['ml_pur_cat_status' => 1, 'ml_pur_cat_parent_id' => 0]);
        $data['loan_cat'] = $this->db->get_where('ml01_loan_plan', ['ml_loanplan_status' => 1]);
        $data['asset_type'] = $this->db->get_where('m44_loan_assets', ['m_status' => 1]);
        return $data;
    }

    function loan_mem_details()
    {
        $member_id = $this->uri->segment(3);
        $condition = "`m09_member_detail`.`or_m_reg_id`='$member_id'";
        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $query1 = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        $json = json_encode($query1->result());
        return $json;
    }

    function view_member_detail()
    {
        $member_id = $this->uri->segment(3);
        $condition = "`m09_member_detail`.`or_m_reg_id`='$member_id'";
        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $data['update'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function get_member_detail()
    {
        $login = $this->input->post('txtmember_id');
        $condition = "`m09_member_detail`.`or_m_member_id`='$login'";
        $datas = [
            'querey' => $condition,
            'proc' => 1
        ];
        $query = "CALL sp_report_mem_detail(?,?)";
        $query2 = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        if ($query2->num_rows() > 0) {
            $json = json_encode($query2->result());
            return $json;
        } else {
            return 0;
        }
    }

    function get_loandetail()
    {
        $query = $this->db->get_where('ml01_loan_plan', ['ml_loanplan_status' => 1, 'ml_loanplan_id' => $this->input->post('ddloan_type')]);
        $json = json_encode($query->result());
        return $json;
    }

    function get_amount()
    {
        $id = "";
        $id = $this->input->post('txtintuserid');
        $amount = 0.00;
        $due = 0.00;
        $loan_amount = 0.00;

        $query = $this->db->query("SELECT SUM(`tr18_closing_detail`.`tr_cd_business_amount`) as amount FROM `tr18_closing_detail` WHERE `tr18_closing_detail`.`tr_cd_date` = (SELECT MAX(`tr18_closing_detail`.`tr_cd_date`) AS amount FROM `tr18_closing_detail`) AND `tr_cd_business_by` = $id AND `tr_cd_for` = 'I' ");
        $row = $query->row();
        if ($query->num_rows() == 1) {
            $amount = trim($row->amount);
            $amount = $amount / 2;
        }

        $query1 = $this->db->query("SELECT get_due_advance_amount(1,0,$id) as due; ");
        $rows = $query1->row();
        if ($query1->num_rows() == 1) {
            $due = trim($rows->due);
        }

        $query2 = $this->db->query("SELECT get_due_advance_amount(3,0,$id) as loan_amnt; ");
        $rowss = $query2->row();
        if ($query2->num_rows() == 1) {
            $loan_amount = trim($rowss->loan_amnt);
        }
        return $amount - ($due + $loan_amount);
    }

    function get_plantype()
    {
        $json = json_encode($this->db->get_where('ml02_purpose_category', ['ml_pur_cat_status' => 1, 'ml_pur_cat_parent_id' => $this->input->post('ddpurpose_category')])->result());
        return $json;
    }

    function view_registration_detail($branch_condetion = null)
    {

        $condition = $branch_condetion;

        if ($this->input->post('txtrequestnumber') != '' && $this->input->post('txtrequestnumber') != '0') {
            $condition = $condition . "`ml03_loan_booking`.`ml_contract_id` = '" . $this->input->post('txtrequestnumber') . "' AND";
        }
        if ($this->input->post('txtcustomername') != '' && $this->input->post('txtcustomername') != '0') {
            $condition = $condition . "`m09_member_detail`.`or_m_member_id` ='" . $this->input->post('txtcustomername') . "' AND";
        }
        if ($this->input->post('txtassociateid') != '' && $this->input->post('txtassociateid') != '0') {
            $condition = $condition . "`m09_member_detail_1`.`or_m_member_id` ='" . $this->input->post('txtassociateid') . "' AND";
        }
        if ($this->input->post('ddbranch') != '' && $this->input->post('ddbranch') != '-1') {
            $condition = $condition . "`ml03_loan_booking`.`ml_branch` ='" . $this->input->post('ddbranch') . "' AND";
        }
        $condition = $condition . " 1";
        $datas = ['proc' => 1, 'querey' => $condition, 'reg_id' => 0];
        $query = "Call sp_loan_report(?,?,?);";
        $data['report'] = $this->db->query($query, $datas);

        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_details()
    {
        $data['sub_plan'] = $data['plan_detail'] = $data['multi_receipt'] = [];
        if ($this->uri->segment(3) != "") {
            $id = $this->uri->segment(3);
            $data['bank'] = $this->db->query("select * from m13_bank where m_bank_status=1");
            //mysqli_next_result( $this->db->conn_id );
            $instalment_detail = [
                'proc' => 2,
                'querey' => '',
                'reg_id' => (int)$this->uri->segment(3)
            ];
            $query = "CALL sp_loan_report(?" . str_repeat(",?", count($instalment_detail) - 1) . ") ";
            $query = $this->db->query($query, $instalment_detail);
            // mysqli_more_results($query);
            mysqli_next_result($this->db->conn_id);
            $data['sub_plan'] = $query;

            if (empty($data['sub_plan']->result())) {
                return false;
            }

            foreach ($data['sub_plan']->result() as $row) {
                break;
            }

            $plan_detail = [
                'proc' => 1,
                'startdate' => $row->Loan_book_id,
                'enddate' => $row->Maturity_date,
                'project_id' => $this->uri->segment(3),
                'term' => $row->Loan_mode
            ];
            $query1 = "CALL sp_get_loan_date(?" . str_repeat(",?", count($plan_detail) - 1) . ") ";
            $data['plan_detail'] = $this->db->query($query1, $plan_detail);
            mysqli_next_result($this->db->conn_id);
            $query2 = "SELECT
				@a:=@a+1 	SN,
				(SELECT `get_different_recipt_id`(1,`tr_loan_book_id`,SN))  AS  `recipt_id`,
				`tr_loan_book_id` AS Project_id,
				COUNT(`tr_loan_p_id`) AS Count_payid,
				DATE_FORMAT(`tr_loan_p_subdate`, '%Y-%m-%d') AS PAY_DATE,
				MAX(`tr_loan_p_id`) AS Max_id,
				MIN(`tr_loan_p_id`) AS Min_id,
				SUM(`tr_loan_p_amount`) AS Amount,
				`tr_loan_p_pay_status` AS  `tr_loan_p_pay_type`
				FROM
				(`tr20_loan_payment` AS tabl),(SELECT @a:= 0) AS a
				WHERE `tr_loan_book_id` = $id
				GROUP BY `tr_loan_p_subdate`,`tr_loan_p_pay_status`
				ORDER BY SN ";
            $data['multi_receipt'] = $this->db->query($query2);

        }
        return $data;
    }

    function get_fine_amount()
    {
        $no_of_ins = $this->input->post('txt_no_installment');
        $txtbook_date = $this->input->post('txtbook_date');
        $txtplan_mode = $this->input->post('txtplan_mode');
        $txtgrace_time = $this->input->post('txtgrace_time');
        $txtins_amt = $this->input->post('txtins_amt');
        $txtfine = (float)$this->input->post('txtfines');
        $fine_day_count = 0;
        $date_diff = 0;
        $no_of_times = 0;
        $interest = 0.00;
        $amount = 0.00;
        $amount1 = 0.00;
        $fine = 0.00;
        $query = $this->db->query("SELECT GetLoanDates('$txtbook_date',$no_of_ins,$txtplan_mode) as next_date");
        $rows = $query->row();
        $to_date = $rows->next_date;
        $date = CURRENT_DATE;
        $query = $this->db->query("SELECT DATEDIFF(' $date','$txtbook_date') AS DiffDate");
        $rows = $query->row();
        $date_diff = $rows->DiffDate;

        if ($date_diff > 0) {
            $fine_day_count = (int)(($date_diff / $txtgrace_time));

            if ($fine_day_count != 0) {
                $no_of_times = ($fine_day_count - 1);
            } else {
                $no_of_times = 0;
            }
            if ($no_of_times != 0) {
                for ($i = 1; $i <= $no_of_times; $i++) {
                    $amount1 = ($txtins_amt * $i);
                    $interest = $interest + ($i * $txtfine);
                    $amount = $amount + (($amount1 * $interest) / 100);
                }
            }
        }
        return $amount;
    }

    function get_ln_book_id($contract_id = '')
    {
        $this->db->select('ml_book_id');
        $this->db->where('ml_contract_id', $contract_id);
        $query = $this->db->get('ml03_loan_booking');
        if ($query->num_rows() == 1) {
            $rowss = $query->row();
            return $rowss->ml_book_id;
        } else {
            return 0;
        }
    }

    function view_loan_details()
    {
        if ($this->input->post('txtaccountnum') != "") {
            $contract = $this->input->post('txtaccountnum');
            $query = $this->db->query("SELECT `Get_loan_account_detail`(1,'$contract') as plid ");


            if ($query->num_rows() > 0) {
                $row = $query->row();
                $ac_id = $row->plid;
                if ($ac_id != "") {
                    $query1 = $this->db->query("SELECT `Get_loan_account_detail`(2,'$ac_id') as mem_det ");

                    if ($query1->num_rows() > 0) {
                        $row1 = $query1->row();
                        $mem_det = $row1->mem_det;
                        if ($mem_det != "") {

                            return $mem_det . "-" . $ac_id;
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    function closed_loan_plan()
    {

        $condition = '';
        if ($this->input->post('txtrequestnumber') != '' && $this->input->post('txtrequestnumber') != '0') {
            $condition = $condition . "`ml03_loan_booking`.`ml_contract_id` = '" . $this->input->post('txtrequestnumber') . "' AND";
        }
        if ($this->input->post('txtcustomername') != '' && $this->input->post('txtcustomername') != '0') {
            $condition = $condition . "`m09_member_detail`.`or_m_member_id` ='" . $this->input->post('txtcustomername') . "' AND";
        }
        if ($this->input->post('txtassociateid') != '' && $this->input->post('txtassociateid') != '0') {
            $condition = $condition . "`m09_member_detail_1`.`or_m_member_id` ='" . $this->input->post('txtassociateid') . "' AND";
        }
        if ($this->input->post('ddbranch') != '' && $this->input->post('ddbranch') != '-1') {
            $condition = $condition . "`ml03_loan_booking`.`ml_branch` ='" . $this->input->post('ddbranch') . "' AND";
        }
        $condition = $condition . " `ml03_loan_booking`.`ml_status`=3";
        $datas = ['proc' => 1, 'querey' => $condition, 'reg_id' => 0];
        $query = "Call sp_loan_report(?,?,?);";
        $data['report'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_requested_loan()
    {

        $condition = '';
        if ($this->input->post('txtrequestnumber') != '' && $this->input->post('txtrequestnumber') != '0') {
            $condition = $condition . "`ml03_loan_booking`.`ml_contract_id` = '" . $this->input->post('txtrequestnumber') . "' AND";
        }
        if ($this->input->post('txtcustomername') != '' && $this->input->post('txtcustomername') != '0') {
            $condition = $condition . "`m09_member_detail`.`or_m_member_id` ='" . $this->input->post('txtcustomername') . "' AND";
        }
        if ($this->input->post('txtassociateid') != '' && $this->input->post('txtassociateid') != '0') {
            $condition = $condition . "`m09_member_detail_1`.`or_m_member_id` ='" . $this->input->post('txtassociateid') . "' AND";
        }
        if ($this->input->post('ddbranch') != '' && $this->input->post('ddbranch') != '-1') {
            $condition = $condition . "`ml03_loan_booking`.`ml_branch` ='" . $this->input->post('ddbranch') . "' AND";
        }
        $condition = $condition . " `ml03_loan_booking`.`ml_status`=3";
        $datas = ['proc' => 1, 'querey' => $condition, 'reg_id' => 0];
        $query = "Call sp_loan_report(?,?,?);";
        $data['report'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_loan_policy()
    {

        $data['bank'] = $this->db->query("select * from m13_bank where m_bank_status=1");
        $data['sub_plan'] = $this->db->query("SELECT * FROM p08_policy_plan WHERE `p_plcy_plan_status`=1");
        // free_db_resource;
        return $data;
    }

    function ln_plan1()
    {
        return json_encode($this->db->query("SELECT * FROM p08_policy_plan WHERE p_plcy_plan_id=" . $this->input->post('ddplan') . " ")->result());
    }

    function policy_booking_report()
    {
        $txtmember_id = $this->input->post('txtmember_id');
        $txtcontractid = $this->input->post('txtcontractid');
        $condition = '';
        $id = '';

        if ($this->input->post('txtfromdate') != '' && $this->input->post('txtfromdate') != '0' && $this->input->post('txttodate') != '' && $this->input->post('txttodate') != '0') {
            $condition = $condition . "DATE_FORMAT(`ml04_policy_booking`.`policy_book_date`,'%Y-%m-%d') BETWEEN DATE_FORMAT('" . $this->input->post('txtfromdate') . "','%Y-%m-%d') and  DATE_FORMAT('" . $this->input->post('txttodate') . " ','%Y-%m-%d') AND ";
        }

        if ($this->input->post('txtassociateid') != '' && $this->input->post('txtassociateid') != '0') {
            $condition = $condition . " `m09_member_detail_1`.`associate_code`= '" . $this->input->post('txtassociateid') . "' and";
        }

        if ($this->input->post('txtcustomerid') != '' && $this->input->post('txtcustomerid') != '0') {
            $condition = $condition . " `m09_member_detail`.`customer_code`= '" . $this->input->post('txtcustomerid') . "' and";
        }

        if ($this->input->post('ddbranch') != '' && $this->input->post('ddbranch') != '-1') {
            $condition = $condition . " `ml04_policy_booking`.`branch_id`= '" . $this->input->post('ddbranch') . " ' and";
        }
        if ($this->input->post('txtbookingid') != '' && $this->input->post('txtbookingid') != '-1') {
            $condition = $condition . " `ml04_policy_booking`.`policy_contract_id`= '" . $this->input->post('txtbookingid') . " ' and";
        }

        $condition = $condition . " `ml04_policy_booking`.`policy_status` =1 GROUP BY `ml04_policy_booking`.`policy_book_id`";
        $clsdt = [
            'proc' => 1,
            'querey' => $condition
        ];
        $query = "CALL sp_policy_booking_report(?,?)";
        $data['maturity'] = $this->db->query($query, $clsdt);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_policy_details()
    {
        $id = $this->uri->segment(3);
        $this->data['bank'] = $this->db->query("select * from m13_bank where m_bank_status=1");
        $instalment_detail = [
            'proc' => 1,
            'statuss' => "`ml04_policy_booking`.`policy_book_id`=" . $this->uri->segment('3') . " "
        ];
        $query = "CALL sp_policy_renewal(?" . str_repeat(",?", count($instalment_detail) - 1) . ") ";
        $data['sub_plan'] = $this->db->query($query, $instalment_detail);

        mysqli_next_result($this->db->conn_id);

        foreach ($data['sub_plan']->result() as $row) {
            break;
        }

        $query2 = "SELECT
			@a:=@a+1 	SN,
			(SELECT `get_recipt_id`(`m_plcy_id`,SN))  AS  `recipt_id`,
			`m_plcy_id` AS Project_id,
			COUNT(`m_plcy_pay_id`) AS Count_payid,
			DATE_FORMAT(`m_plcy_pay_date`, '%Y-%m-%d') AS PAY_DATE,
			MAX(`m_plcy_pay_id`) AS Max_id,
			MIN(`m_plcy_pay_id`) AS Min_id,
			`m_plcy_pay_id`      AS pay_id,
			SUM(`m_plcy_amount`) AS Amount
			FROM
			(`tr24_policy_payment` AS tabl),(SELECT @a:= 0) AS a
			WHERE `m_plcy_id` = " . $this->uri->segment('3') . " AND `m_plcy_pay_status` = 1  GROUP BY `m_plcy_pay_date`";
        $data['multi_receipt'] = $this->db->query($query2);
        // free_db_resource;

        return $data;
    }

    function get_policy_book_id()
    {
        $contract_id = $this->input->post('txtcontract_id');
        $this->db->select('policy_book_id');
        $this->db->where('policy_contract_id', $contract_id);
        $query = $this->db->get('ml04_policy_booking');
        if ($query->num_rows() == 1) {
            $rowss = $query->row();
            return $rowss->policy_book_id;
        } else {
            return 0;
        }
    }

    function get_ln_saving_account()
    {
        return json_encode($this->db->query("SELECT * FROM `m18_plan_booking` WHERE `m18_plan_booking`.`customer_id`=" . $this->input->post('cust_id') . " AND `m18_plan_booking`.`plan_hold_amount`>=1000 AND `m18_plan_booking`.`plan_book_id` NOT IN (SELECT `ml_saving_acc` FROM `ml03_loan_booking` WHERE `ml03_loan_booking`.`ml_status`=1) ")->result());
    }

    function get_policy_plan()
    {
        return json_encode($this->db->query("SELECT * FROM `ml04_policy_booking` WHERE `ml04_policy_booking`.`customer_id`=" . $this->input->post('cust_id') . " AND `ml04_policy_booking`.`policy_book_id` NOT IN (SELECT `ml_policy_id` FROM `ml03_loan_booking` WHERE `ml03_loan_booking`.`ml_status`=1) ")->result());
    }

    function share()
    {
        $member_regid = 0;
        if ($this->uri->segment(3) != "")
            $member_regid = $this->uri->segment(3);
        $con = "";
        if (is_numeric($member_regid))
            $con = "`m09_member_detail`.`or_m_reg_id`  = " . $member_regid . " ";
        else
            $con = "`m09_member_detail`.`or_m_member_id`  = '" . $member_regid . "' ";
        $record = [
            'proc' => 1,
            'querey' => $con
        ];
        $query = " CALL sp_associate(?,?) ";
        $data['row'] = $this->db->query($query, $record)->row();
        mysqli_next_result($this->db->conn_id);
        if (!is_numeric($member_regid)) {
            $member_regid = $data['row']->Regid;
        } else {
            $member_regid = $member_regid;
        }
        $data['share'] = $this->db->query("SELECT t1.tr_share_id , t1.tr_share_name,t1.tr_share_date,t2.or_m_member_id,t2.or_m_name FROM tr29_share as t1 left join m09_member_detail as t2 on(t1.tr_branch_id = t2.or_m_reg_id )  WHERE t1.tr_reg_id=" . $member_regid . " ")->result();
        return $data;
    }

    //--------------------- -----------------------------------------------------------//
    /* --------------------- --End Loan Master -------------------------------------- */
    //--------------------- -----------------------------------------------------------//

    function reward_report()
    {
        $data['star_award'] = $this->db->query("SELECT * FROM view_award WHERE m_reward_status=1 AND m_reward_type=2 ");
        $data['crown_award'] = $this->db->query("SELECT * FROM view_award WHERE m_reward_status=1 AND m_reward_type=1");
        $data['award'] = $this->db->query("SELECT * FROM view_award WHERE m_reward_status=1");
        return $data;
    }

    function reward_achiver()
    {
        $data1 = $this->db->query("SELECT MAX(`tr_from_date`) AS from_date, MAX(`tr_to_date`) AS to_date FROM  `tr30_financial_year` WHERE `tr_status`=1")->row();

        $condition = "`cv_date` BETWEEN '" . $data1->from_date . "' AND '" . $data1->to_date . "' AND `is_crown_pay`=0 ";

        $datas = [
            'proc' => 1,
            'querys' => $condition
        ];
        $data['crown'] = $this->db->query("CALL sp_reward_achiever(?,?)", $datas);
        mysqli_next_result($this->db->conn_id);

        $condition1 = "`cv_date` BETWEEN '" . $data1->from_date . "' AND '" . $data1->to_date . "' AND `is_star_pay`=0 ";
        $datas1 = [
            'proc' => 1,
            'querys' => $condition1
        ];
        $data['star'] = $this->db->query("CALL sp_reward_achiever(?,?)", $datas1);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_collector_report()
    {
        $condition = '';
        $data['type'] = $this->db->get('p02_plan');
        if ($this->input->post('txtassociateid') != '' && $this->input->post('txtassociateid') != '0') {
            $condition = $condition . " `m09_member_detail_2`.`associate_code`= '" . $this->input->post('txtassociateid') . "' and";
        }
        $condition = $condition . " `m18_plan_booking`.`plan_type` =7";

        $clsdt = [
            'from_date' => ($this->input->post('txtfromdate') == '' ? CURRENT_DATE : $this->input->post('txtfromdate')),
            'to_date' => ($this->input->post('txttodate') == '' ? CURRENT_DATE : $this->input->post('txttodate')),
            'querey' => $condition
        ];
        $query = "CALL sp_upcoming_inst(?,?,?)";
        $data['maturity'] = $this->db->query($query, $clsdt);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    function view_collector_report2()
    {
        $today = $this->input->post('txtfromdate');
        $condition = '';
        $txtassociateid = $this->input->post('txtassociateid');
        $data['type'] = $this->db->get('p02_plan');

        if (!empty($txtassociateid)) {
            $condition = $condition . " `m09_member_detail_2`.`associate_code`= '" . $txtassociateid . "' OR  m09_member_detail_2.or_m_member_id = '" . $txtassociateid . "' and";
        }

        $condition = $condition . " `m18_plan_booking`.`plan_type` = 7 and  `m18_plan_booking`.plan_status = 1";

        $clsdt = [
            'querey' => $condition
        ];

        $query = "CALL sp_upcoming_inst2(?)";
        $data['maturity'] = $this->db->query($query, $clsdt);
        //   echo $this->db->last_query();die;
        mysqli_next_result($this->db->conn_id);


        return $data;
    }

    public function day_book($aff_id = 0)
    {
        $data['frombal'] = '';
        if ($aff_id != 0) {
            $data['branch'] = $this->db->get_where('view_users', ['or_status' => 1, 'or_m_reg_id' => $this->session->userdata('affid')]);
        } else {
            $data['branch'] = $this->branch();
        }
        $datas = [
            'from_date' => ($this->input->post('txtfromdate') != '' ? $this->input->post('txtfromdate') : CURRENT_DATE),
            'to_date' => ($this->input->post('txttodate') != '' ? $this->input->post('txttodate') : CURRENT_DATE),
            'aff_id' => $aff_id,
            'acc_id' => $this->input->post('ddacount')
        ];
        $query = "CALL sp_income_report(?,?,?,?)";
        $data['income'] = $this->db->query($query, $datas);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

    public function pay_commission()
    {
        $dataa = explode(',', $this->input->post('txtquid'));
        for ($i = 0; $i <= (count($dataa) - 2); $i++) {
            $data1 = explode('-', $dataa[$i]);
            $rowcon = $this->db->query("SELECT *,(SELECT GetMaturityDate(`m18_plan_booking`.`plan_book_date`,(`m18_plan_booking`.`total_paid_ins`),`m18_plan_booking`.`plan_mode`)) AS Installment FROM `m18_plan_booking` WHERE plan_book_id=" . $data1[0] . " ")->row();
            $cust = $rowcon->customer_id;
            $mis = [
                'no_ins' => ($data1[1] / $rowcon->plan_amount),
                'project_id' => $data1[0],
                'contract_id' => $rowcon->plan_contract_id,
                'm_amount' => $rowcon->plan_amount,
                'ddpayment_mode' => 1,
                'txtchequedate' => CURRENT_DATE,
                'txtcheque' => '',
                'ddcheque_bank' => '',
                'paymentBranch' => '',
                'paymentStatus' => 1,
                'paymentAmount' => $rowcon->plan_amount,
                'paymentNaration' => "installment payment",
                'm_pay_user_id' => $rowcon->customer_id,
                'm_pay_intr_id' => $rowcon->introducer_id,
                'm_install_date' => $rowcon->Installment,
                'm_pay_date' => CURRENT_DATE,
                'm_pay_branch' => $rowcon->branch_id,
                'emp_id' => $this->session->userdata('profile_id')
            ];
            $query = " CALL sp_pay_renewal(?" . str_repeat(",?", count($mis) - 1) . ",@a) ";
            $data['sub_plan'] = $this->db->query($query, $mis);
            mysqli_next_result($this->db->conn_id);
            $data['response'] = $this->db->query("SELECT @a as resp");
            foreach ($data['response']->result() as $r) {
                $resp = $r->resp;
            }

            if ($data1[0]) {
                $this->db->where('or_m_reg_id', $cust);
                $data['res'] = $this->db->get('m09_member_detail');
                $rowmob = $data['res']->row();
                $mob = $rowmob->or_m_mobile_no;
                $contract = $rowcon->plan_contract_id;
                if ($mob != "") {
                    $msg = "Thanks for submitting the installment of Rs." . $this->input->post('txtins_amt') . " for plan " . $contract;
                    if (isset($row22->plan_type)) {
                        if ($row22->plan_type == 4) {
                            $totalbal = $this->db->query("SELECT `get_saving_balance`(1," . $this->uri->segment(3) . ") as balance ")->row()->balance;
                            $branchname = $this->db->query("SELECT `view_users`.`or_m_name` AS branchname FROM `view_users` WHERE `view_users`.`or_m_reg_id`=" . $aff . " ")->row()->branchname;
                            $msg = "Welcome to " . COMPANY_FULL_NAME . ". Dear Customer, You A/c " . $contract . " Is credited with INR " . $this->input->post('txtins_amt') . " on " . date('M-d Y') . ". Info. By Cash-" . $branchname . ". Your Total Avbl. Bal is INR " . $totalbal . ".";
                        }
                        if ($row22->plan_type == 2) {
                            $msg = "Welcome to " . COMPANY_FULL_NAME . ". Dear Customer, Your Recurring Account No. " . $contract . ".is Submitting the installment on " . date('M-d Y') . ", Rs." . $this->input->post('txtins_amt') . ". Thanks You.";
                        }
                    }
                    set_msg('success', $msg);
                    //$this->send_sms($mob, $msg);
                }
            }
        }
    }

    public function send_sms($mob, $msg)
    {
        if (empty($mobile) || empty($msg)) {
            return false;
        }

        $curl = curl_init();
        $url = null;
        if (SMS_ROUTE == "sarkar") {
            $url = "http://login.sakar.me/sendSMS?username=apulki&message=$msg&sendername=" . SENDER_ID . "'&smstype=TRANS&numbers=$mobile&apikey=" . AUTH_KEY;
        } else
            $url = "http://api.msg91.com/api/sendhttp.php?country=91&sender=SONSWM&route=4&mobiles=$mobile&authkey=254648AJjnllf55c2ca609&message=$msg&campaign=sonswami";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    function view_plan_reverse()
    {
        $condition = '';
        $qery = $this->db->query("SELECT MAX(`tr_closing_todate`) as datess FROM `tr16_closing_date`")->row();
        $datess = ($qery->datess != '') ? $qery->datess : '2015-01-01';
        $condition = $condition . "DATE_FORMAT(`m18_plan_booking`.`plan_book_date`,'%Y-%m-%d') > DATE_FORMAT('" . $datess . "','%Y-%m-%d') AND ";
        if ($this->input->post('txtmemberid') != '') {
            $condition = $condition . "`m09_member_detail`.`or_m_member_id`='" . $this->input->post('txtmemberid') . "' AND ";
        }
        $condition = $condition . " `m18_plan_booking`.`plan_status` = 1 AND 1 group by `m18_plan_booking`.`plan_book_id`";
        $clsdt = [
            'proc' => 1,
            'querey' => $condition
        ];
        $query = "CALL sp_customer_plan_booking(?,?)";
        $data['maturity'] = $this->db->query($query, $clsdt);
        mysqli_next_result($this->db->conn_id);
        return $data;
    }

}