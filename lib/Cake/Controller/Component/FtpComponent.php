<?php
App::uses('Component', 'Controller');

class FtpComponent extends Component {
    public $ftpConnection;
    public $isConnected = false; // Nouvelle variable pour suivre l'état de la connexion

    public function initialize(Controller $controller) {
        // Tentative de connexion FTP
        $this->ftpConnection = @ftp_connect('192.168.20.60'); // Utilisation de @ pour éviter les erreurs fatales

        if ($this->ftpConnection) {
            $login = @ftp_login($this->ftpConnection, 'lafondasapino\userftp', 'C-s//B*%2o14');
            if ($login) {
                $this->isConnected = true;
            } else {
                ftp_close($this->ftpConnection);
                $this->ftpConnection = null;
            }
        }
        
        // Passer la variable au contrôleur
        $controller->set('ftpConnected', $this->isConnected);
    }

    public function getFtpConnection() {
        return $this->ftpConnection;
    }

    public function shutdown(Controller $controller) {
        if ($this->ftpConnection) {
            ftp_close($this->ftpConnection);
        }
    }
}
?>
