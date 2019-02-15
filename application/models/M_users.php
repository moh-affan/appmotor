<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 * @method $this with_groups(string $arguments = '', string $where = '')
 */
class M_users extends MY_Model
{
	public function __construct()
	{
		$this->table = 'auth_users';
		$this->primary_key = 'id';
		$this->timestamps = false;
		$this->fillable = ['username', 'email', 'active', 'first_name', 'last_name', 'company', 'phone'];
		$this->protected = [$this->primary_key, 'password'];
		$this->has_many_pivot['groups'] = array(
			'foreign_model' => 'M_groups',
			'pivot_table' => 'auth_users_groups',
			'local_key' => 'id',
			'pivot_local_key' => 'user_id',
			'pivot_foreign_key' => 'group_id',
			'foreign_key' => 'id',
			'get_relate' => TRUE
		);
		parent::__construct();
	}
}
