<?php
App::uses('Component', 'Controller');

class FtpComponent extends Component {
    public $ftpConnection;

    public function initialize(Controller $controller) {
        // Initialisation de la connexion FTP
        $this->ftpConnection = ftp_connect('192.168.20.60');
        ftp_login($this->ftpConnection, 'lafondasapino\userftp', 'C-s//B*%2o14');
        // Vous pouvez ajouter d'autres configurations FTP ici
    }

    public function getFtpConnection() {
        return $this->ftpConnection;
    }

    public function shutdown(Controller $controller) {
        // Fermeture de la connexion FTP
        ftp_close($this->ftpConnection);
    }
}
?>
