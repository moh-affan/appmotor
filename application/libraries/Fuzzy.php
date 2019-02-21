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
	private $_rules = array();

	/**
	 * Fuzzy constructor.
	 */
	public function __construct()
	{
		$this->_initialize_variable();
		$this->_initialize_rules();
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
				if (empty($f))
					$f[0] = 0;
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
		//fuzzyfikasi
		$fuzzy = array();
		foreach ($data as $datum) {
			foreach ($kriteria as $k) {
				$field = array_pad(explode('_', $k), 2, '');
				$field = $field[0];
				$himpunan = ['min', 'mid', 'max'];
				foreach ($himpunan as $him) {
					$field_himpunan = $field . '_' . $him;
					$res = $this->$field_himpunan($datum->$field);
					if ($res != -1) {
						$fuzzy[$datum->$primary][$field][$him] = $res;
					}
				}
			}
		}

		//inferensi
		$inference = array();
		foreach ($data as $datum) {
			foreach ($this->_rules as $rule) {
				$state = [];
				foreach ($rule as $k => $v) {
					if ($k != 'nilai') {
						$a = $fuzzy[$datum->$primary][$k][$v];
						$state[] = $a;
					} else {
						$n = 'max';
						if ($v == 1)
							$n = 'min';
						elseif ($v == 2)
							$n = 'mid';
						$state['nilai'] = $n;
						if ($n != 'mid')
							$state['range'] = explode(':', $this->_variables['harga'][$n]);
						else {
							$low = explode(':', $this->_variables['harga']['min']);
							$hi = explode(':', $this->_variables['harga']['max']);
							$state['range'] = [$low[0], $hi[1]];
						}

					}
				}
				$infer = new stdClass();
				$alpha = min($state[0], $state[1], $state[2], $state[3], $state[4]);
				$infer->alpha = $alpha;
				$state['min'] = $alpha;
				$min = $state['range'][0];
				$max = $state['range'][1];
				$state_range = $state['nilai'];
				switch ($state_range) {
					case 'min':
						$z = $max - $alpha * ($max - $min);
						$infer->z = $z;
						$inference[$datum->$primary][] = $infer;
						break;
					case 'mid':
						$middle = ($max - $min) / 2 + $min;
						$z = $alpha * ($middle - $min) + $min;
						$infer->z = $z;
						$infer2 = clone $infer;
						$t2 = $max - $alpha * ($max - $middle);
						$infer2->z = $t2;
						$inference[$datum->$primary][] = $infer;
						$inference[$datum->$primary][] = $infer2;
						break;
					case 'max':
						$t = $alpha * ($max - $min) + $min;
						$infer->z = $t;
						$inference[$datum->$primary][] = $infer;
						break;
					default:
						echo 'range state invalid';
				}
			}
		}

		//defuzzifikasi
		$defuzzed = array();
		foreach ($inference as $k => $infers) {
			$defuzzed[$k] = $this->calculateDefuzzification($infers);
		}
		asort($defuzzed);
		$this->_defuzzed = $defuzzed;
	}

	public function tsukamoto2($kriteria = array(), $data = array(), $primary = 'id')
	{
		//fuzzyfikasi
		$fuzzy = array();
		foreach ($data as $datum) {
			foreach ($kriteria as $k) {
				$field = array_pad(explode('_', $k), 2, '');
				$field = $field[0];
				$himpunan = ['min', 'mid', 'max'];
				foreach ($himpunan as $him) {
					$field_himpunan = $field . '_' . $him;
					$res = $this->$field_himpunan($datum->$field);
					if ($res != -1) {
						$fuzzy[$datum->$primary][$field][$him] = $res;
					}
				}
			}
		}

		//inferensi
		$inference = array();
		$rl = array();
		foreach ($kriteria as $ker) {
			$x = explode('_', $ker);
			$rl[$x[0]] = $x[1];
		}
		$rl['nilai'] = 3;
		$rules = array($rl);
//		var_dump($this->_rules);
//		var_dump($k);
		foreach ($data as $datum) {
			foreach ($rules as $rule) {
				$state = [];
				foreach ($rule as $k => $v) {
					if ($k != 'nilai') {
						$a = $fuzzy[$datum->$primary][$k][$v];
						$state[] = $a;
					} else {
						$n = 'max';
						if ($v == 1)
							$n = 'min';
						elseif ($v == 2)
							$n = 'mid';
						$state['nilai'] = $n;
						if ($n != 'mid')
							$state['range'] = explode(':', $this->_variables['harga'][$n]);
						else {
							$low = explode(':', $this->_variables['harga']['min']);
							$hi = explode(':', $this->_variables['harga']['max']);
							$state['range'] = [$low[0], $hi[1]];
						}

					}
				}
				$infer = new stdClass();
				$alpha = min($state[0], $state[1], $state[2], $state[3], $state[4]);
				$infer->alpha = $alpha;
				$state['min'] = $alpha;
				$min = $state['range'][0];
				$max = $state['range'][1];
				$state_range = $state['nilai'];
				switch ($state_range) {
					case 'min':
						$z = $max - $alpha * ($max - $min);
						$infer->z = $z;
						$inference[$datum->$primary][] = $infer;
						break;
					case 'mid':
						$middle = ($max - $min) / 2 + $min;
						$z = $alpha * ($middle - $min) + $min;
						$infer->z = $z;
						$infer2 = clone $infer;
						$t2 = $max - $alpha * ($max - $middle);
						$infer2->z = $t2;
						$inference[$datum->$primary][] = $infer;
						$inference[$datum->$primary][] = $infer2;
						break;
					case 'max':
						$t = $alpha * ($max - $min) + $min;
						$infer->z = $t;
						$inference[$datum->$primary][] = $infer;
						break;
					default:
						echo 'range state invalid';
				}
			}
		}

		//defuzzifikasi
		$defuzzed = array();
		foreach ($inference as $k => $infers) {
			$defuzzed[$k] = $this->calculateDefuzzification($infers);
		}
		$f_defuzzed = array_filter($defuzzed, function ($k) {
			return $k != 0;
		});
		asort($f_defuzzed);
		$this->_defuzzed = $f_defuzzed;
	}

	private function calculateDefuzzification($inference)
	{
		$side_up = 0;
		$side_down = 0;
		foreach ($inference as $infer) {
			$side_up += $infer->alpha * $infer->z;
			$side_down += $infer->alpha;
		}
		if ($side_down == 0)
			return 0;
		return $side_up / $side_down;
	}

	private function _initialize_rules()
	{
		$this->_ci()->load->model('m_rule');
		$m_rule = $this->_ci()->m_rule;
		foreach ($m_rule->get_all() as $var) {
			$this->_rules[] = ['harga' => $var->harga, 'tangki' => $var->tangki, 'kecepatan' => $var->kecepatan, 'bagasi' => $var->bagasi, 'berat' => $var->berat, 'nilai' => $var->nilai];
		}
	}

	public function get_defuzzed()
	{
		return $this->_defuzzed;
	}
}
