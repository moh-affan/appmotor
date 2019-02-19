<?php
/**
 * Created by IntelliJ IDEA.
 * User: ASUS
 * Date: 16/02/2019
 * Time: 10:46
 * Fuzzy Class
 * Used to compute Fuzzy Tahani and Tsukamoto method
 */

class Fuzzy
{
	private $_variables = array();
	private $_m_vars;
	private $_fire_strength = array();
	private $_defuzzed = array();
	private $_alpha = array();

	/**
	 * Fuzzy constructor.
	 */
	public function __construct()
	{
		$this->_initialize_variable();
	}

	/**
	 * @return CI_Controller
	 */
	private function _ci()
	{
		return get_instance();
	}

	/**
	 * @return void
	 */
	private function _initialize_variable()
	{
		$this->_ci()->load->model('m_variabel');
		$this->_m_vars = $this->_ci()->m_variabel;
		foreach ($this->_m_vars->get_all() as $var) {
			$this->_variables[$var->field] = ['min' => $var->min, 'max' => $var->max, 'mid' => 'mid'];
		}
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return float|int
	 */
	public function __call($name, $arguments)
	{
		$mtd = array_pad(explode('_', $name), 2, '');
		$variabel = $mtd[0];
		$kategori = $mtd[1];
		$x = isset($arguments[0]) ? $arguments[0] : false;
		if (array_key_exists($variabel, $this->_variables)) {
			if (array_key_exists($kategori, $this->_variables[$variabel])) {
				$range_min = array_pad(explode(':', $this->_variables[$variabel]['min']), 2, 0);
				$range_max = array_pad(explode(':', $this->_variables[$variabel]['max']), 2, 0);
				$min_min = $range_min[0];
				$min_max = $range_min[1];
				$delta_min_range = $min_max - $min_min;
				$max_min = $range_max[0];
				$max_max = $range_max[1];
				$delta_max_range = $max_max - $max_min;
				if ($kategori == 'min') {
					if ($x <= $min_min)
						return 1;
					elseif ($x >= $min_max)
						return 0;
					else
						return ($min_max - $x) / $delta_min_range;
				} elseif ($kategori == 'max') {
					if ($x <= $max_min)
						return 0;
					elseif ($x >= $max_max)
						return 1;
					else
						return ($x - $max_min) / $delta_max_range;
				} else {
					if ($x <= $min_min || $x >= $max_max)
						return 0;
					elseif ($x == $min_max)
						return 1;
					elseif ($x > $min_min && $x < $min_max)
						return ($x - $min_min) / $delta_min_range;
					elseif ($x > $max_min && $x < $max_max)
						return ($max_max - $x) / $delta_max_range;
				}
			}
		}
		return -1;
	}

	private function _reset_fire_strength()
	{
		$this->_fire_strength = array();
	}

	private function _reset_defuzzed()
	{
		$this->_defuzzed = array();
	}

	public function tahani($kriteria = array(), $data = array())
	{
		$this->_reset_fire_strength();
		$chr = 'a';
		foreach ($data as $datum) {
			$tmp = array();
			$exclude = false;
			foreach ($kriteria as $k) {
				$field = array_pad(explode('_', $k), 2, '');
				$c = $field[1];
				$field = $field[0];
				$res = $this->$k($datum->$field);
				if ($res == -1) {
					$res = strpos(' ' . strtolower($datum->$field), strtolower($c)) > 0 ? 1 : 0;
					if ($res == 0)
						$exclude = true;
				}
				$tmp[$k] = $res;
			}
			if (!$exclude) {
				$f = array_values($tmp);
				$f = array_filter($f, function ($k) {
					return $k != 0 && $k != 1;
				});
				$min_fire_strength = min($f);
				$datum->fire_strength = $min_fire_strength;
				$key = $min_fire_strength . "_" . $chr++;
				$this->_fire_strength[$key] = json_decode(json_encode(array_merge((array)$datum, $tmp)));
			}
		}
	}

	public function get_fire_strength()
	{
		return $this->_fire_strength;
	}

	public function tsukamoto($kriteria = array(), $data = array(), $primary = 'id')
	{
		$this->_reset_fire_strength();
		$this->_reset_defuzzed();
		$this->_alpha = array();
		foreach ($data as $datum) {
			$this->_defuzzed[$datum->$primary]['min'] = array();
			$this->_defuzzed[$datum->$primary]['mid'] = array();
			$this->_defuzzed[$datum->$primary]['max'] = array();
			$tmp = array();
			$exclude = false;
			foreach ($kriteria as $k) {
				$field = array_pad(explode('_', $k), 2, '');
				$c = $field[1];
				$field = $field[0];
				$himpunan = ['min', 'mid', 'max'];
				$tmp2 = array();
				foreach ($himpunan as $him) {
					$field_himpunan = $field . '_' . $him;
					$res = $this->$field_himpunan($datum->$field);
					if ($res == -1) {
						$res = strpos(' ' . strtolower($datum->$field), strtolower($c)) > 0 ? 1 : 0;
						if ($res == 0)
							$exclude = true;
					} else {
						if ($res > 0.0 || $res < 1.0)
							array_push($this->_defuzzed[$datum->$primary][$him], $res);
					}
				}
			}
			$this->_defuzzed[$datum->$primary]['min']['min'] = min($this->_defuzzed[$datum->$primary]['min']);
			$this->_defuzzed[$datum->$primary]['mid']['min'] = min($this->_defuzzed[$datum->$primary]['mid']);
			$this->_defuzzed[$datum->$primary]['max']['min'] = min($this->_defuzzed[$datum->$primary]['max']);
//			if (!$exclude) {
//				$this->_defuzzed[$datum->$primary] = $tmp2;
//			}
		}
	}

	public function get_defuzzed()
	{
		print_r($this->_defuzzed);
		return $this->_defuzzed;
	}

	private function sum($array = array())
	{
		$res = 0;
		foreach ($array as $k => $v)
			$res += $v;
		return $res;
	}
}
