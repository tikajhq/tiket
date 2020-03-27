<?PHP

class DataHandler
{
	/**
	 * getContent()
	 *
	 * fetches a url & returns the data/html
	 *
	 * @param mixed $url
	 * @param array $query
	 * @param array $options
	 * @param int $retry
	 * @return string
	 * @throws Exception
	 */
	public static function get($url, $query = null, $options = array(), $retry = 1)
	{

		if ($query !== null) {
			// if url has get param then use & to prefix and append more param else use ? & add query
			if (!parse_url($url, PHP_URL_QUERY))
				$url = $url . '?' . http_build_query($query);
			else
				$url = $url . '&' . http_build_query($query);
		}
		return self::hitCURL($url, $options, $retry);
	}

	private static function hitCURL($url, $options, $retry)
	{
		do {
			$ch = curl_init();
			$options = array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HEADER => false,
					// CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_ENCODING => "",
					CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0",
					CURLOPT_AUTOREFERER => true,
					CURLOPT_CONNECTTIMEOUT => 120,
					CURLOPT_TIMEOUT => 120,
					CURLOPT_MAXREDIRS => 10) + $options;
			curl_setopt_array($ch, $options);
			$result = curl_exec($ch);
			//If there is any error & this is last try i.e. retry=1 then throw exception
			if ($c_error_no = curl_errno($ch)) {
				if ($retry <= 1)
					throw new Exception("[$c_error_no]" . curl_error($ch));
			}
			curl_close($ch);
		} while ($retry--);

		return $result;
	}

	/**
	 * postContent()
	 *
	 * makes a post request on given url with given data & returns the response
	 *
	 * @param mixed $url
	 * @param mixed $data ,data to attach in post request
	 * @param array $options
	 * @return string
	 * @throws Exception
	 */
	public static function post($url, $data, $options = array(), $retry = 1)
	{

		$options = array(
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $data) + $options;

		return self::hitCURL($url, $options, $retry);
	}

	public static function download($url, $filepath)
	{
		file_put_contents($filepath, fopen($url, 'r'));
	}
}
