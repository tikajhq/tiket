<?php

/**
 * Class QuickTemplate
 * Very small class forked from CI Parser -just without dependency of CI.
 */
class QuickTemplate
{

	public $l_delim = '{{';
	public $r_delim = '}}';

	public function parse($template, $data)
	{
		if ($template === '') {
			return FALSE;
		}

		$replace = array();
		foreach ($data as $key => $val) {
			$replace = array_merge(
				$replace,
				is_array($val)
					? $this->_parse_pair($key, $val, $template)
					: $this->_parse_single($key, (string)$val, $template)
			);
		}

		unset($data);
		$template = strtr($template, $replace);
		return $template;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse a tag pair
	 *
	 * Parses tag pairs: {some_tag} string... {/some_tag}
	 *
	 * @param string
	 * @param array
	 * @param string
	 * @return    string
	 */
	protected function _parse_pair($variable, $data, $string)
	{
		$replace = array();
		preg_match_all(
			'#' . preg_quote($this->l_delim . $variable . $this->r_delim) . '(.+?)' . preg_quote($this->l_delim . '/' . $variable . $this->r_delim) . '#s',
			$string,
			$matches,
			PREG_SET_ORDER
		);

		foreach ($matches as $match) {
			$str = '';
			foreach ($data as $row) {
				$temp = array();
				foreach ($row as $key => $val) {
					if (is_array($val)) {
						$pair = $this->_parse_pair($key, $val, $match[1]);
						if (!empty($pair)) {
							$temp = array_merge($temp, $pair);
						}

						continue;
					}

					$temp[$this->l_delim . $key . $this->r_delim] = $val;
				}

				$str .= strtr($match[1], $temp);
			}

			$replace[$match[0]] = $str;
		}

		return $replace;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse a single key/value
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return    string
	 */
	protected function _parse_single($key, $val, $string)
	{
		return array($this->l_delim . $key . $this->r_delim => (string)$val);
	}

	// --------------------------------------------------------------------

	/**
	 * Set the left/right variable delimiters
	 *
	 * @param string
	 * @param string
	 * @return    void
	 */
	public function set_delimiters($l = '{', $r = '}')
	{
		$this->l_delim = $l;
		$this->r_delim = $r;
	}

}
