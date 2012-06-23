<?php

// ルーティング定義配列とPATH_INFOを受け取り、
// ルーティングパラメータを特定する
class Router {
	protected $routes;

	public function __construct($definitions) {
		$this->routes = $this->compileRoutes($definitions);
	}

	// ルーティング定義配列を変換する
	// array( '/user/:id' => array('controller' => 'user', 'action' => 'show');
	// みたいなやつ
	public function compileRoutes($definitions) {
		$routes = array();

		foreach ($definitions as $url => $params) {
			// スラッシュ(/)でURLを分割する
			$tokens = explode('/', ltrim($url, '/'));
			foreach ($tokens as $i => $token) {
				// コロンで始まる文字列の場合は正規表現の形式に変更する
				if (0 === strpos($token, ':')) {
					$name = substr($token, 1);
					// 名前付きキャプチャ
					$token = '(?P<' . $name . '>[^/]+)';
				}
				$tokens[$i] = $token;
			}
			// 分割した（変換済み）URLを再度スラッシュでつなげる
			$pattern = '/' . implode('/', $tokens);
			$routes[$pattern] = $params;
		}

		return $routes;
	}

	// PATH_INFOを受け取りマッチングを行う
	public function resolve($path_info){
		// 先頭がスラッシュでない場合、先頭にスラッシュを付与する
		if('/' !== substr($path_info, 0, 1)){
			$path_info = '/' . $path_info;
		}

		// TODO #がわからないので調べる
		foreach ($this->routes as $pattern => $params) {
			// #はデリミタ。$patternにスラッシュが出現するため。
			if(preg_match('#^' . $pattern . '$#', $path_info, $matches)){
				// 連想配列をまとめる（$matchesのkeyは?P<>で指定したキー(id,nameとか)）
				$params = array_merge($params, $matches);

				return $params;
			}
		}

		return false;		
	}

}
