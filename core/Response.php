<?php

// レスポンスを表すクラス。
// HTTPヘッダとHTMLなどのコンテンツを返す
class Response {
	protected $content;
	protected $status_code;
	protected $status_text;
	protected $http_headers = array();

	// 各プロパティに設定された値を元にレスポンスを送信する
	public function send() {
		// プロトコルバージョンは1.1に固定
		header('HTTP/1.1 ' . $this->status_code . ' ' . $this->status_text);

		// $http_headerプロパティにHTTPレスポンスヘッダの指定があれば送信
		foreach ($this->http_headers as $name => $value) {
			header($name . ':' . $value);
		}

		// レスポンス内容を送信するのはechoでOK
		echo $this->content;
	}

	// HTMLなど、実際にクライアントに返す内容を格納する
	public function setContent($content) {
		$this->content = $content;
	}

	// ステータスコード（404 Not Foundなど）を設定する
	public function setStatusCode($status_code, $status_text = '') {
		$this->status_code = $status_code;
		$this->status_text = $status_text;
	}

	// HTTPヘッダの連想配列を格納する
	public function setHttpHeader($name, $value) {
		$this->http_headers[$name] = $value;
	}

}
