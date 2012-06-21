<?php

class Request {
	// HTTPメソッドがPOSTかどうか判定する
	public function isPost() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			return true;
		}

		return false;
	}
	// $_GET変数から値を取得する
	public function getGet($name, $default = null) {
		if (isset($_GET[$name])) {
			return $_GET[$name];
		}

		return $default;
	}
	// $_POST変数から値を取得する
	public function getPOST($name, $default = null) {
		if (isset($_POST[$name])) {
			return $_POST[$name];
		}

		return $default;
	}
	// サーバのホスト名を取得する
	// ホスト名がない場合はApache側に設定されたホスト名（SERVER_NAME）を返す
	public function getHost($name, $default = null) {
		if (!empty($_SERVER['HTTP_HOST'])) {
			return $_SERVER['HTTP_HOST'];
		}

		return $_SERVER['SERVER_NAME'];
	}
	// HTTPSアクセスかどうか判定する
	public function isSsl(){
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
			return true;
		}
	}
	// リクエストされたURLの情報を返す
	// URLのホスト部分以降の値
	public function getRequestUri(){
		return $_SERVER['REQUEST_URi'];
	}
	// ベースURLを取得する
	public function getBaseUrl(){
		$script_name = $_SERVER['SCRIPT_NAME'];
		
		$request_uri = $this->getRequestUri();
		// フロントコントローラがURLに含まれる場合
		if(0 === strpos($request_uri, $script_name)){
			return $script_name;
		}
		// フロントコントローラが省略されている場合
		else if(0 === strpos($request_uri, dirname($script_name))){
			return rtrim(dirname($script_name), '/');
		}
		
		return '';
	}

	// PATH_INFOを取得する
	public function getPathInfo(){
		$base_url = $this->getBaseUrl();
		$request_url = $this->getRequestUri();
		
		// GETパラメータを除去する
		if(false !== ($pos = strpos($request_url, '?'))){
			$request_url = substr($request_url, 0, $pos);
		}
		
		$path_info = (string)substr($request_url, strlen($base_url));
		
		return $path_info;
	}

}
