<?php

// 接続情報を管理するクラス
class DbManager
{
	protected $connections = array();

	public function connect($name, $params)
	{
		$params = array_merge(array(
					'dsn' => null,
					'user' => '',
					'password' => '',
					'options' => array(),
					),$params);

		$con = new PDO(
				$params['dsn'],
				$params['user'],
				$params['password'],
				$params['options']
				);

		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		$this->connections[$name] = $con;
	}

	public function getConnection($name = null)
	{
		if(is_null($name)){
			return current($this->connections);
		}

		return $this->connections[$name];
	}
}
