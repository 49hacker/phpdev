<?php
class ClassLoader {
	protected $dirs;
	// オートローダクラスを登録する
	public function register() {
		spl_autoload_register(array($this, 'loadClass'));
	}
	// 読み込むディレクトリ（パス）を登録する
	public function registerDir($dir) {
		$this -> dirs[] = $dir;
	}
	// 実際にファイルを読み込む
	public function loadClass($class) {
		foreach ($this->dirs as $dir) {
			$file = $dir . '/' . $class . '.php';
			if (is_readable($file)) {
				require $file;

				return;
			}
		}
	}

}
