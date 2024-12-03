<?php
class BackupController extends AppController {
	public $idModule = 72;
	

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Backup.libelle' )
					$conditions['Backup.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Backup.date1' )
					$conditions['Backup.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Backup.date2' )
					$conditions['Backup.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Backup->recursive = -1;
		$this->Paginator->settings = ['order'=>['Backup.date_c'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function download($id = null) {
		if ($this->Backup->exists($id)) {
			$options = array('conditions' => array('Backup.' . $this->Backup->primaryKey => $id));
			$dossier = $this->Backup->find('first', $options);
			$link = str_replace('\\', '/', WWW_ROOT.'backups'.DS.$dossier['Backup']['libelle']);
			$file = ( file_exists($link) ) ? $link : ''; 

			if ( empty($file) ) {
				$this->Session->setFlash("Le fichier ou le dossier n’existe pas. ",'alert-danger');
				return $this->redirect( $this->referer() );
			}else{

				header("Content-Description: File Transfer"); 
				header("Content-Type: application/octet-stream"); 
				header("Content-Disposition: attachment; filename=" . basename($file) . ""); 

				readfile ($file);
				exit(); 
			}

		}else{
			$this->Session->setFlash('Il y a un problème dans votre serveur de stockage !','alert-danger');
			return $this->redirect( $this->referer() );
		}
	}

	public function savedatabase($tables = '*') {

	    $return = '';

	    $modelName = $this->modelClass;


	    $dataSource = $this->{$modelName}->getDataSource();
	    $databaseName = $dataSource->getSchemaName();


	    // Do a short header
	    $return .= '-- Database: `' . $databaseName . '`' . "\n";
	    $return .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";

	    if ($tables == '*') {
	        $tables = array();
	        $result = $this->{$modelName}->query('SHOW TABLES');
	        foreach($result as $resultKey => $resultValue){
	            $tables[] = current($resultValue['TABLE_NAMES']);
	        }
	    } else {
	        $tables = is_array($tables) ? $tables : explode(',', $tables);
	    }

	    // Run through all the tables
	    foreach ($tables as $table) {
	        $tableData = $this->{$modelName}->query('SELECT * FROM ' . $table);

	        $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
	        $createTableResult = $this->{$modelName}->query('SHOW CREATE TABLE ' . $table);
	        $createTableEntry = current(current($createTableResult));
	        $return .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";

	        // Output the table data
	        foreach($tableData as $tableDataIndex => $tableDataDetails) {

	            $return .= 'INSERT INTO ' . $table . ' VALUES(';

	            foreach($tableDataDetails[$table] as $dataKey => $dataValue) {

	                if(is_null($dataValue)){
	                    $escapedDataValue = 'NULL';
	                }
	                else {
	                    // Convert the encoding
	                    $escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );

	                    // Escape any apostrophes using the datasource of the model.
	                    $escapedDataValue = $this->{$modelName}->getDataSource()->value($escapedDataValue);
	                }

	                $tableDataDetails[$table][$dataKey] = $escapedDataValue;
	            }
	            $return .= implode(',', $tableDataDetails[$table]);

	            $return .= ");\n";
	        }

	        $return .= "\n\n\n";
	    }

	    // Set the default file name
	    $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
	    $data['Backup'] = ['id' => null,'libelle' =>  $fileName ,'date' => date('Y-m-d')];
	    $this->Backup->save($data);

	    // Serve the file as a download
    	$destination = WWW_ROOT.'backups';
    	if (!file_exists( $destination )) mkdir($destination,true, 0700);

    	// Create and save file
	    $my_file = $destination.DS.$fileName;
		$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

		if ( fwrite($handle, $return) ) die("Good");
		else die("Bad");

	    // $this->autoRender = false;
	    // $this->response->type('Content-Type: text/x-sql');
	    // $this->response->download($fileName);
    	// $this->response->body($return);

	}
}