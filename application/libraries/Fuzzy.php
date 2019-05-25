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

	public static function log($var)
	{
		var_dump($var);
		echo '<br>';
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
		$firestength = array();
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
//				if (empty($f))
//					$f[0] = 5;
				if (!empty($f)) {
					$min_fire_strength = min($f);
					$datum->fire_strength = $min_fire_strength;
					$key = $min_fire_strength . "_" . $chr++;
					$firestength[$key] = json_decode(json_encode(array_merge((array)$datum, $tmp)));
				}
			}
		}
		krsort($firestength);
		$this->_fire_strength = $firestength;
	}

	public function get_fire_strength()
	{
		return $this->_fire_strength;
	}

	public function tsukamoto($kriteria = array(), $data = array(), $primary = 'id', $exclude = array())
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
		foreach ($data as $datum) {
			foreach ($rules as $rule) {
				$state = [];
				foreach ($rule as $k => $v) {
					if ($k != 'nilai') {
						$a = $fuzzy[$datum->$primary][$k][$v];
						$state[] = $a;
					} else {
						$n = 'max';
						$state['nilai'] = $n;
						$low = 0;
						$hi = 1;
						$state['range'] = [$low, $hi];
					}
				}
				$infer = new stdClass();
				$states = [$state[0], $state[1], $state[2], $state[3], $state[4]];
//				var_dump($states);
//				$states = array_filter($states, function ($k) {
//					return $k != 0;
//				});
				$alpha = count($states) <= 0 ? 0 : min($states);
				$infer->alpha = $alpha;
				$min = $state['range'][0];
				$max = $state['range'][1];
//				$t = $alpha * ($max - $min) + $min;
				/**
				 * Menghitung nilai z
				 * Rumus: (max-alpha)/(max-min)
				 */
				$t = ($max - $alpha) / ($max - $min);
				$infer->z = $t;
				$inference[$datum->$primary][] = $infer;
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
		$x_defuzzed = array();
		foreach ($f_defuzzed as $id => $defuzz) {
			if (isset($data->{$id})) {
				$sid = $id - 1;
				$motor = $data->{$sid};
				$motor->defuzzed = $defuzz;
				$inc = strpos(strtolower(serialize($motor)), $exclude[0][1]) && strpos(strtolower(serialize($motor)), $exclude[1][1]) && strpos(strtolower(serialize($motor)), $exclude[2][1]);
				if ($inc)
					$x_defuzzed[] = $motor;
			}
		}
		$this->_defuzzed = $x_defuzzed;
	}

	public function mamdani($kriteria = array(), $data = array(), $primary = 'id', $exclude = array())
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
		foreach ($data as $datum) {
			foreach ($rules as $rule) {
				$state = [];
				foreach ($rule as $k => $v) {
					if ($k != 'nilai') {
						$a = $fuzzy[$datum->$primary][$k][$v];
						$state[] = $a;
					} else {
						$n = 'max';
						$state['nilai'] = $n;
						$low = 0;
						$hi = 1;
						$state['range'] = [$low, $hi];
					}
				}
				$infer = new stdClass();
				$states = [$state[0], $state[1], $state[2], $state[3], $state[4]];
//				var_dump($states);
				$states = array_filter($states, function ($k) {
					return $k != 0 && $k != 1;
				});
				$alpha = count($states) <= 0 ? 0 : max($states);
				$alpha2 = count($states) <= 0 ? 0 : min($states);
//				self::log($datum->$primary . " [$alpha,$alpha2]");
				$bb = $state['range'][0];
				$ba = $state['range'][1];
				$S = $ba - $bb;
				$a1 = ($S * $alpha) + $bb;
				$a2 = ($S * $alpha2) + $bb;
				$T = abs(($a2 - $a1));
				$T = ($a2 - $a1);
				$M1 = $alpha2 / 2 * pow($a1, 2);
				$M2 = ((1 / ($ba - $bb) / 2 * pow($a2, 3))) - ($bb / ($ba - $bb) / 2 * pow($a2, 3)) - ((1 / ($ba - $bb) / 3 * pow($a1, 3))) - ($bb / ($ba - $bb) / 2 * pow($a2, 2));
				$M3 = ($alpha * pow($ba, 2) / 2) - ($alpha * ($ba - $bb)) / 2 * ($ba - $bb);
//				self::log($datum->$primary . " [M1 = $M1, M2 = $M2, M3 = $M3]");
				$A1 = ($a1 - $bb) * $alpha;
				$A2 = 0.5 * ($alpha + $alpha2) * $T;
				$A3 = ($ba - $a2) * $alpha2;
//				self::log($datum->$primary . " [A1 = $A1, A2 = $A2, A3 = $A3]");
				$infer->_M = ($M1 + $M2 + $M3);
				$infer->_A = ($A1 + $A2 + $A3);
				$inference[$datum->$primary][] = $infer;
			}
		}

		//defuzzifikasi
		$defuzzed = array();
		foreach ($inference as $k => $infers) {
			$defuzzed[$k] = $this->calculateMamdaniDefuzzification($infers);
		}
//		self::log($defuzzed);
		$f_defuzzed = array_filter($defuzzed, function ($k) {
			return $k > 0 && $k < 1;
		});
		asort($f_defuzzed);
		$x_defuzzed = array();
		foreach ($f_defuzzed as $id => $defuzz) {
			if (isset($data->{$id})) {
				$sid = $id - 1;
				$motor = $data->{$sid};
				$motor->defuzzed = $defuzz;
				$inc = strpos(strtolower(serialize($motor)), $exclude[0][1]) && strpos(strtolower(serialize($motor)), $exclude[1][1]) && strpos(strtolower(serialize($motor)), $exclude[2][1]);
				if ($inc)
					$x_defuzzed[] = $motor;
			}
		}
		$this->_defuzzed = $x_defuzzed;
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

	private function calculateMamdaniDefuzzification($inference)
	{
		$side_up = 0;
		$side_down = 0;
		foreach ($inference as $infer) {
			$side_up += $infer->_M;
			$side_down += $infer->_A;
		}
		if ($side_down == 0)
			return 0;
		return $side_up / $side_down;
	}

	private function calculateMoment($top, $down, $xdx)
	{
		$c = $xdx / 2;
		$integral = function ($c, $x) {
			return $c * $x * $x;
		};
		$min = $integral($c, $top);
		$max = $integral($c, $down);
		return $max - $min;
	}

	private function calculateArea($a, $top, $alpha)
	{
		return ($top - $a) * $alpha;
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
