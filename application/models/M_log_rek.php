<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 * @method $this with_motor(string $arguments = '', string $where = '')
 */
class M_log_rek extends MY_Model
{
	public function __construct()
	{
		$this->table = 'log_rek';
		$this->primary_key = 'id_log';
		$this->fillable = ['motor_id', 'metode', 'nilai', 'urutan', 'created_by', 'updated_by', 'nilai', 'exec_time', 'sesi'];
		$this->protected = [$this->primary_key];
		$this->has_one['motor'] = array('foreign_model' => 'M_motor', 'foreign_table' => 'motor', 'foreign_key' => 'id_motor', 'local_key' => 'motor_id');
		parent::__construct();
	}
}
