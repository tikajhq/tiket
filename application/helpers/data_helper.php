<?PHP

function post($name)
{
	return isset($_POST[$name])?$_POST[$name]:null;
}

function get($name)
{
	return isset($_GET[$name])?$_GET[$name]:null;
}

function ready_message($src, $data = array())
{
	foreach ($data as $key => $value) {
		$key = strtoupper($key);
		$src = str_replace("%$key%", $value, $src);
	}
	return $src;
}


function set_title($title)
{
	echo '<div class="m-heading-1 border-green m-bordered" style="height: 48px;">
                                 <h3>' . $title . '</h3>
                                </div>';
}

function generator_barcode($id)
{
	include(APPPATH . 'third_party/barcode/BarcodeGenerator.php');
	include(APPPATH . 'third_party/barcode/BarcodeGeneratorPNG.php');

	$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
	return "data:image/png;base64," . base64_encode($generator->getBarcode($id, $generator::TYPE_CODE_128));
}



/**
 * Format Money when you want to show in frontend.
 * @param $money
 * @return string
 */
function formatMoney($money)
{
	if($money<0)
		return '- ₹'.abs(round($money, 2));
	return '₹ ' . round($money, 2);
}

/**
 * Format negative money wrapper around format money.
 * @param $money
 * @return string
 */
function formatMoneyNegative($money)
{
	return formatMoney(abs($money)*-1);
}


/**
 * Format a USERID to show with prefix and leading zeros.
 * @param $id
 * @return string
 */
function formatUserID($id)
{
	return MEMBER_ID_PREFIX . sprintf("%0" . MEMBER_ID_LENGTH . "d", $id);
}

/**
 * Return all numbers from a user ID, technically returns userid from formatted ID.
 * @param $str
 * @return int
 */
function getUserID($str)
{
	return intval(preg_replace("/[^-0-9]+/", '', $str));
}


function getCurrentUserProfile($uid = null, $gender = 0)
{
//	if($uid==null)

	$name = getUserID($uid) . '.' . 'png';

	if (file_exists(SETTING_PROFILE_PATH . $name))
		return BASE_URL . (SETTING_PROFILE_DIR . $name);
	return BASE_URL . "/assets/img/ico/" . ($gender == 0 ? "male.png" : "female.png");
}

function getCurrentUserReferralURL($uid)
{
	return base_url('auth/register') . '?r=' . $uid;
}

function upload_doc()
{
	echo '<div  style="position:relative;">';
	echo '<svg width="166" height="150" style="position:relative; margin: auto; display: block;">
                            <g id="Shot" fill="none" fill-rule="evenodd">
                                <g id="shot2" transform="translate(-135 -157)">
                                    <g id="success-card" transform="translate(48 120)">
                                        <g id="Top-Icon" transform="translate(99.9 47.7)">
                                            <g id="Circle" transform="translate(18.9 11.7)">
                                                <ellipse id="blue-color" cx="56.341267" cy="54.0791109" fill="#F05260"
                                                         rx="51.2193336" ry="51.5039151"/>
                                                <ellipse id="border" cx="51.2283287" cy="51.5039151" stroke="#3C474D"
                                                         stroke-width="5" rx="51.2193336" ry="51.5039151"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <i class="icon-upload icon-3x center-absolute"></i>
                        </svg>
                    </div>';
	echo '<div class="form-group  px-5">
            <label class=" control-label"><code> <span class="badge badge-dark" title="Pending"><b>Status: </b>Document not uploaded</span></code></label>
           </div>';
}

function verified_card()
{
	echo '<div  style="position:relative;">
                       <svg width="166" height="150" style="position:relative; margin: auto; display: block;">
                            <g id="Shot" fill="none" fill-rule="evenodd">
                                <g id="shot2" transform="translate(-135 -157)">
                                    <g id="success-card" transform="translate(48 120)">
                                        <g id="Top-Icon" transform="translate(99.9 47.7)">
                                            <g id="Circle" transform="translate(18.9 11.7)">
                                                <ellipse id="blue-color" cx="56.341267" cy="54.0791109" fill="#5AE9BA"
                                                         rx="51.2193336" ry="51.5039151"/>
                                                <ellipse id="border" cx="51.2283287" cy="51.5039151" stroke="#3C474D"
                                                         stroke-width="5" rx="51.2193336" ry="51.5039151"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <i class="icon-check icon-3x center-absolute"></i>
                        </svg>
                    </div>
                    <label class=" control-label"><code> <span class="badge badge-verified" title="Verified"><b>Status: </b>Verified</span></code></label>';
}

function rejected_card()
{
	echo '<div  style="position:relative;">
                    <svg width="166" height="150" style="position:relative; margin: auto; display: block;">
                            <g id="Shot" fill="none" fill-rule="evenodd">
                                <g id="shot2" transform="translate(-135 -157)">
                                    <g id="success-card" transform="translate(48 120)">
                                        <g id="Top-Icon" transform="translate(99.9 47.7)">
                                            <g id="Circle" transform="translate(18.9 11.7)">
                                                <ellipse id="blue-color" cx="56.341267" cy="54.0791109" fill="#F05260"
                                                         rx="51.2193336" ry="51.5039151"/>
                                                <ellipse id="border" cx="51.2283287" cy="51.5039151" stroke="#3C474D"
                                                         stroke-width="5" rx="51.2193336" ry="51.5039151"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <i class="icon-cross icon-3x center-absolute"></i>
                        </svg>
                    </div>';
	echo '<div class="form-group  px-5">
            <label class=" control-label"><code> <span class="badge badge-danger" title="Pending"><b>Status: </b>Rejected</span></code></label>
            </div>';
}


function waiting_card()
{
	echo '<div  style="position:relative;">
                    <svg width="166" height="150" style="position:relative; margin: auto; display: block;">
                            <g id="Shot" fill="none" fill-rule="evenodd">
                                <g id="shot2" transform="translate(-135 -157)">
                                    <g id="success-card" transform="translate(48 120)">
                                        <g id="Top-Icon" transform="translate(99.9 47.7)">
                                            <g id="Circle" transform="translate(18.9 11.7)">
                                                <ellipse id="blue-color" cx="56.341267" cy="54.0791109" fill="#ff7043"
                                                         rx="51.2193336" ry="51.5039151"/>
                                                <ellipse id="border" cx="51.2283287" cy="51.5039151" stroke="#3C474D"
                                                         stroke-width="5" rx="51.2193336" ry="51.5039151"/>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <i class="icon-database-time2 icon-3x center-absolute"></i>
                        </svg>
                    </div>';

	echo '<div class="form-group  px-5">
   <label class=" control-label"><code> <span class="badge badge-warning" title="Pending"><b>Status: </b>Pending...</span></code></label></div>';
}
