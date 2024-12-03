<?php


class Uploadfile{

	public function getFileInfo($path){
		$fullPath = WWW_ROOT.$path;
		$data = [];
		$data['basename'] = $path;
		$data['filename'] = pathinfo($fullPath)['filename'];
		$data['extension'] = pathinfo($fullPath)['extension'];
		$data['name'] = $data['filename'].'.'.$data['extension'];
		$result = new finfo();
		$data['type'] = $result->file($fullPath, FILEINFO_MIME_TYPE);
		$data['size'] = filesize($fullPath);
		return $data;
	}

	public function convertBaseName($basename) {
		$file_info = pathinfo($basename);
		$basenameSlug = Inflector::slug($file_info['filename']).'.'.$file_info['extension'];
		return $basenameSlug;
	}
	
}