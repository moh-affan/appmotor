<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 * @method $this with_users($arguments = array())
 */
class M_groups extends MY_Model
{
	public function __construct()
	{
		$this->table = 'auth_groups';
		$this->primary_key = 'id';
		$this->timestamps = false;
		$this->fillable = ['name', 'description'];
		$this->protected = [$this->primary_key];
		$this->has_many_pivot['users'] = array(
			'foreign_model' => 'M_users',
			'pivot_table' => 'auth_users_groups',
			'local_key' => 'id',
			'pivot_local_key' => 'group_id',
			'pivot_foreign_key' => 'user_id',
			'foreign_key' => 'id',
			'get_relate' => TRUE
		);
		parent::__construct();
	}
}
