<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 */
class M_users_groups extends MY_Model
{
	public function __construct()
	{
		$this->table = 'auth_users_groups';
		$this->primary_key = 'id';
		$this->timestamps = false;
		$this->fillable = ['user_id', 'group_id'];
		$this->protected = [$this->primary_key];
		parent::__construct();
	}
}
