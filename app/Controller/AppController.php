<?php

App::uses('Controller', 'Controller');
class AppController extends Controller
{
    protected $idModule = 0;
    protected $globalPermission = [];

    public $components = [
        'Paginator',
        'Session',
        'Auth' => [
            'authenticate' => [
                'Form' => [
                    'scope' => ['User.deleted' => 0],
                ],
            ],
        ],
    ];

    public function sendEmail($settings = [], $subject = '', $content = '', $to = [], $attachments = [])
    {
        if (!empty($to)) {
            $config = [
                'host' => $settings['SMTP_host'],
                'port' => $settings['SMTP_port'],
                'username' => $settings['SMTP_username'],
                'password' => $settings['SMTP_password'],
                'auth' => (isset($settings['SMTP_auth']) and $settings['SMTP_auth'] == 'true') ? true : false,
                'tls' => true,
                'context' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ],
            ];

            try {
                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail('smtp');
                $Email->config($config);
                $from = (isset($settings['SMTP_from']) and !empty($settings['SMTP_from'])) ? $settings['SMTP_from'] : 'notification@noreply.ma';
                $Email->from([$from => $from]);
                $Email->to($to);
                $Email->subject($subject);
                if (!empty($attachments)) {
                    $Email->attachments($attachments);
                }
                $Email->emailFormat('html')->send($content);

                return true;
            } catch (Exception $e) {
                //die( "Erreur : ".$e->getMessage() );
                return false;
            }
        }
    }

    public function beforeFilter()
    {
        date_default_timezone_set('Africa/Casablanca');
        if ($this->request->params['controller'] != 'modules' && $this->request->params['action'] != 'getSidebarMenu') {
            $p = $this->getModulePermission();
            if (!$this->consulteModulePermission($p)) {
                throw new NotFoundException("Vous n'avez pas la permission de créer une entrée dans ce dossier. Consultez le propriétaire du dossier ou votre administrateur pour modifier vos autorisations !", 1);
            }
            $this->set('globalPermission', $this->globalPermission);
        }
    }

    public function generateFlashes()
    {
        $model = $this->modelClass;
        $this->loadModel($model);

        if (isset($this->$model->error) and !empty($this->$model->error)) {
            $this->Session->setFlash($this->$model->error, 'alert-danger');
        }
    }

    public function beforeRender()
    {
        date_default_timezone_set('Africa/Casablanca');
        if ($this->name == 'CakeError') {
            $this->layout = 'error';
        }

        $useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'windows';
        $iPod = stripos($useragent, 'iPod');
        $iPad = stripos($useragent, 'iPad');
        $iPhone = stripos($useragent, 'iPhone');
        $Android = stripos($useragent, 'Android');
        $iOS = stripos($useragent, 'iOS');
        $windows = stripos($useragent, 'windows');
        $macintosh = stripos($useragent, 'Macintosh');
        $MOBILE = ($iPod || $iPad || $iPhone || $Android || $iOS) ? true : false;
        $DESKTOP = ($windows || $macintosh) ? true : false;

        $user_id = $this->Auth->Session->read('Auth.User.id');
        $role_id = $this->Auth->Session->read('Auth.User.role_id');
        $alerts = [];
        $notifications = [];
        $storesList = [];
        $storeSession = [];
        $depotList = [];
        if (isset($user_id) and !empty($user_id)) {
            $this->loadModel('Lastsession');
            $SessionActive = $this->Lastsession->find('first', ['conditions' => ['Lastsession.id' => $user_id, 'Lastsession.logout' => -1]]);
            if (isset($SessionActive['Lastsession']['id']) and $SessionActive['Lastsession']['logout'] == -1) {
                $this->Auth->logout();
                $this->Session->delete('Auth');
                $this->Session->setFlash('Votre session est expiré .', 'alert-danger');

                return $this->redirect(['action' => 'login']);
            }

            $SessionData['Lastsession'] = ['id' => $user_id, 'date' => date('Y-m-d H:i:s'), 'logout' => 1];
            if ($this->Lastsession->save($SessionData));

            //$this->generate();
            /* Alert */
            $this->loadModel('Alert');
            $alerts = $this->Alert->find('all', [
                'joins' => [
                    ['table' => 'alerts_users', 'alias' => 'AlertUser', 'type' => 'INNER', 'conditions' => ['AlertUser.alert_id = Alert.id']],
                ],
                'conditions' => ['AlertUser.user_id' => $user_id, 'AlertUser.read' => -1],
            ]);
            /* Alert */

            /* Notification */
            $this->loadModel('Notification');
            $notifications = $this->Notification->find('all', [
                'joins' => [
                    ['table' => 'notifications_users', 'alias' => 'NotificationUser', 'type' => 'INNER', 'conditions' => ['NotificationUser.notification_id = Notification.id']],
                ],
                'conditions' => [
                    'NotificationUser.user_id' => $user_id,
                    'Notification.read' => -1,
                ],
            ]);

            /* Get _Config app */
            $this->loadModel('Config');
            $Config_app = $this->Config->find('first');

            $version_app 		= $Config_app['Config']['version_app'];
            $type_app 			= $Config_app['Config']['type_app'];
            $store_id_config	= $Config_app['Config']['store_id'];
            $caisse_id_config	= $Config_app['Config']['caisse_id'];
            $app_last_commit 	= $Config_app['Config']['app_last_commit'];
            $app_last_commit = substr($app_last_commit, 0, 5);

            if($type_app==1){$type_app='Administration';}
            if($type_app==2){$type_app='POS';}
            if($type_app==2){$type_app='Serveur';}

            $this->set(compact('Config_app'));

            /* Session user */
            $this->loadModel('User');
            $SessionInfo = $this->User->find('first', ['contain' => ['Role', 'StoreSession'], 'conditions' => ['User.id' => $user_id]]);

            //$store_id = (isset($SessionInfo['User']['store_id']) and !empty($SessionInfo['User']['store_id'])) ? $SessionInfo['User']['store_id'] : 1;
            

            if (isset($SessionInfo['User']['store_id']) && !empty($SessionInfo['User']['store_id'])) {

                // affecter l'ID store de l'installation au store_id
                $store_id = $this->Session->read('Auth.User.StoreSession.id');
                
            } else {
                // $store_id = 1;
                // recupérer le store_id affecté au USER connecté
                $store_id = $SessionInfo['User']['store_id'];
            }

                
                // IL FAUT AFFECTER L ADRESSE PUBLIC $ SESSION
                // Récupérer l'adresse IP PUBLIC de la machine cliente
               // $url = 'https://api.ipify.org?format=json';
               // $data = file_get_contents($url);
               // $adresse_ip_public_user = json_decode($data)->ip;
               // $adresse_ip_public_user = '105.154.28.152';

            // Récupérer l'adresse IP PUBLIC de la machine cliente
			$adresse_ip_public_user = CakeSession::read('adresse_ip_public_user');

                

            $this->GetAdmins();
        
            $this->loadModel('Store');

            // Options communes entre ==1 et !=1
            $options = [
                'fields' => ['Store.*', 'Societe.*'],
                'joins' => [
                    ['table' => 'stores_users', 'alias' => 'StoreUser', 'type' => 'INNER', 'conditions' => ['StoreUser.store_id = Store.id', 'StoreUser.deleted = 0']],
                    ['table' => 'societes', 'alias' => 'Societe', 'type' => 'INNER', 'conditions' => ['Societe.id = Store.societe_id', 'Societe.deleted = 0']],
                    ['table' => 'users', 'alias' => 'User', 'type' => 'INNER', 'conditions' => ['User.id = StoreUser.user_id', 'User.deleted = 0']],
                ],
                'conditions' => [
                    'StoreUser.user_id'=>$user_id,
                ],
            ];

            // Condition supplémentaire si $role_id est diff à 1
            if ($role_id != 1 and $role_id !=2 ) {
                // $options['conditions']['Store.adresses_ip'] = $adresse_ip_public_user;
                $options['conditions'][] = "CONCAT(',', Store.adresses_ip, ',') LIKE '%,{$adresse_ip_public_user},%'";
            }

            // Requête
            $storesList = $this->Store->find('all', $options);

            if(!empty($storesList) AND $store_id == NULL){
                $store_id = $storesList[0]['Store']['id']; // Juste récupré le permier pour l'affichage 
            }

            $depotList = $this->Store->Depot->find('list', ['fields' => ['Depot.id', 'Depot.id'], 'conditions' => ['Depot.store_id' => $store_id]]);
            $this->Session->write('depots', $depotList);

          
            $storeSession = $this->Store->find('first', ['conditions' => ['Store.id' => $store_id], 'contain' => ['Societe']]);

            $role_id = $this->Auth->Session->read('Auth.User.role_id');
            $admins = $this->Auth->Session->read('admins');
            $admin = false;
            if (in_array($role_id, $admins)) {
                $admin = true;
            }
        }

        $this->set(compact('admin', 'MOBILE', 'DESKTOP', 'SessionInfo', 'alerts', 'notifications', 'storesList', 'storeSession'));
    }

    public function callIndexAjaxExcel($page = 1)
    {
        App::uses('HtmlHelper', 'View/Helper');
        $HtmlHelper = new HtmlHelper(new View());
        if ($this->request->is('post')) {
            $filter_url['controller'] = $this->request->params['controller'];
            $filter_url['action'] = 'excel';

            if (isset($this->data['Filter']) && is_array($this->data['Filter'])) {
                foreach ($this->data['Filter'] as $name => $value) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if ($v) {
                                $filter_url[$name.'.'.$k] = $v;
                            }
                        }
                    } else {
                        if ($value) {
                            $filter_url[$name] = urlencode($value);
                        }
                    }
                }
            }
            die($HtmlHelper->url($filter_url));
        }
    }

    public function callIndexAjax($page = 1)
    {
        if ($this->request->is('post')) {
            $filter_url['controller'] = $this->request->params['controller'];
            $filter_url['action'] = 'indexAjax';

            $filter_url['page'] = $page;
            if (isset($this->data['Filter']) && is_array($this->data['Filter'])) {
                foreach ($this->data['Filter'] as $name => $value) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if ($v) {
                                $filter_url[$name.'.'.$k] = $v;
                            }
                        }
                    } else {
                        if ($value) {
                            $filter_url[$name] = urlencode($value);
                        }
                    }
                }
            }

            return $this->redirect($filter_url);
        }
    }

    protected function getPath($idModule)
    {
        $this->loadModel('Module');
        $bar = $this->Module->getPath($idModule);
        $this->set(compact('bar'));
    }

    protected function getModule($libelle)
    {
        $this->loadModel('Module');
        $module = $this->Module->find('first', ['conditions' => ['libelle' => $libelle]]);

        return isset($module['Module']['id']) ? $module['Module']['id'] : 1;
    }

    protected function getConsulteModules()
    {
        $this->loadModel('Permission');

        $res = $this->Permission->find('all', [
            'fields' => ['Permission.module_id', 'SUM(Permission.c) as c'],
            'conditions' => ['Permission.role_id' => $this->Auth->User('role_id')],
            'group' => ['Permission.module_id'],
        ]);

        $modules = [];
        foreach ($res as $module) {
            if ($module[0]['c'] != 0) {
                $modules[] = $module['Permission']['module_id'];
            }
        }

        return $modules;
    }

    protected function getModulePermission()
    {
        $idModule = $this->idModule;
        $this->loadModel('Permission');
        $role_id = $this->Auth->Session->read('Auth.User.role_id');
        $res = $this->Permission->find('all', [
            'conditions' => ['Permission.role_id' => $role_id, 'Permission.module_id' => $idModule],
        ]);

        if (!$this->Auth->user()) {
            $global['Permission'] = ['c' => 1, 'a' => 0, 'm1' => 0, 'm2' => 0, 'm3' => 0, 'm4' => 0, 'v' => 0, 's' => 0, 'h' => 0, 'i' => 0, 'e' => 0, 'sa' => 0];
        } else {
            $global['Permission'] = ['c' => 0, 'a' => 0, 'm1' => 0, 'm2' => 0, 'm3' => 0, 'm4' => 0, 'v' => 0, 's' => 0, 'h' => 0, 'i' => 0, 'e' => 0, 'sa' => 0];
        }
        foreach ($res as $val) {
            if ($val['Permission']['c'] == 1) {
                $global['Permission']['c'] = 1;
            }
            if ($val['Permission']['a'] == 1) {
                $global['Permission']['a'] = 1;
            }
            if ($val['Permission']['m1'] == 1) {
                $global['Permission']['m1'] = 1;
            }
            if ($val['Permission']['m2'] == 1) {
                $global['Permission']['m2'] = 1;
            }
            if ($val['Permission']['m3'] == 1) {
                $global['Permission']['m3'] = 1;
            }
            if ($val['Permission']['m4'] == 1) {
                $global['Permission']['m4'] = 1;
            }
            if ($val['Permission']['v'] == 1) {
                $global['Permission']['v'] = 1;
            }
            if ($val['Permission']['s'] == 1) {
                $global['Permission']['s'] = 1;
            }
            if ($val['Permission']['h'] == 1) {
                $global['Permission']['h'] = 1;
            }
            if ($val['Permission']['i'] == 1) {
                $global['Permission']['i'] = 1;
            }
            if ($val['Permission']['e'] == 1) {
                $global['Permission']['e'] = 1;
            }
            if ($val['Permission']['sa'] == 1) {
                $global['Permission']['sa'] = 1;
            }
        }
        $this->globalPermission = $global;

        return $res;
    }

    protected function getPermissionByModule($idModule = null)
    {
        if ($idModule === null) {
            $idModule = $this->idModule;
        }

        $this->loadModel('Permission');

        $res = $this->Permission->find('all', [
            'conditions' => ['Permission.role_id' => $this->Auth->User('role_id'), 'Permission.module_id' => $idModule],
        ]);

        if (!$this->Auth->user()) {
            $global['Permission'] = ['c' => 1, 'a' => 0, 'm1' => 0, 'm2' => 0, 'm3' => 0, 'm4' => 0, 'v' => 0, 's' => 0, 'h' => 0, 'i' => 0, 'e' => 0, 'sa' => 0];
        } else {
            $global['Permission'] = ['c' => 0, 'a' => 0, 'm1' => 0, 'm2' => 0, 'm3' => 0, 'm4' => 0, 'v' => 0, 's' => 0, 'h' => 0, 'i' => 0, 'e' => 0, 'sa' => 0];
        }
        foreach ($res as $val) {
            if ($val['Permission']['c'] == 1) {
                $global['Permission']['c'] = 1;
            }
            if ($val['Permission']['a'] == 1) {
                $global['Permission']['a'] = 1;
            }
            if ($val['Permission']['m1'] == 1) {
                $global['Permission']['m1'] = 1;
            }
            if ($val['Permission']['m2'] == 1) {
                $global['Permission']['m2'] = 1;
            }
            if ($val['Permission']['m3'] == 1) {
                $global['Permission']['m3'] = 1;
            }
            if ($val['Permission']['m4'] == 1) {
                $global['Permission']['m4'] = 1;
            }
            if ($val['Permission']['v'] == 1) {
                $global['Permission']['v'] = 1;
            }
            if ($val['Permission']['s'] == 1) {
                $global['Permission']['s'] = 1;
            }
            if ($val['Permission']['h'] == 1) {
                $global['Permission']['h'] = 1;
            }
            if ($val['Permission']['i'] == 1) {
                $global['Permission']['i'] = 1;
            }
            if ($val['Permission']['e'] == 1) {
                $global['Permission']['e'] = 1;
            }
            if ($val['Permission']['sa'] == 1) {
                $global['Permission']['sa'] = 1;
            }
        }

        return $global;
    }

    protected function consulteModulePermission($p)
    {
        if ($this->idModule === 0) {
            return true;
        }

        return  $this->globalPermission['Permission']['c'] == 1;
    }

    public function saveLogs($module)
    {
        $this->loadModel('Loging');
        $user_id = $this->Auth->Session->read('Auth.User.id');
        $logs = [
            'module' => $module,
            'date_c' => date('Y-m-d H:i:s'),
            'user_c' => $user_id,
            'transaction' => 'Suppression',
        ];
        $this->Loging->save($logs);
    }

    protected function GetSociete($societe_id = 1)
    {
        $this->loadModel('Societe');

        return $this->Societe->find('first', ['contain' => ['Pdfmodele'], 'conditions' => ['Societe.id' => $societe_id]]);
    }

    protected function GetClient($client_id = 2)
    {
        $this->loadModel('Client');
    
        return $this->Client->find('first', [
            'conditions' => ['Client.id' => $client_id]
        ]);
    }

    protected function GetAdmins()
    {
        $list = [];
        $this->loadModel('Admin');
        $admins = $this->Admin->findList();
        foreach ($admins as $k => $v) {
            $list[$v] = $v;
        }
        $this->Session->write('admins', $list);
    }

    protected function GetParametreSte()
    {
        $this->loadModel('Parametreste');
        $ParametreSte = $this->Parametreste->find('list', ['fields' => ['key', 'value'], 'conditions' => ['societe_id' => 1]]);

        return $ParametreSte;
    }

    public function generateNotifications($user_id = null)
    {
        $this->loadModel('Produit');
        $produitsalerts = $this->Produit->find('all', [
            'fields' => ['Depotproduit.*', 'Produit.*'],
            'conditions' => [
                'Produit.active' => 1,
                'Depotproduit.total <=' => 10,
            ],
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id', 'Depotproduit.deleted = 0']],
                ['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = Depot.id', 'Depot.deleted = 0']],
            ],
            'group' => ['Produit.id'],
        ]);
    }

    public function validateUsername($data)
    {
        $this->loadModel('User');
        $bolean = false;
        if (isset($data['User']['username']) and !empty($data['User']['username'])) {
            if (empty($data['User']['id'])) {
                $user = $this->User->find('first', ['conditions' => ['User.username' => $data['User']['username']]]);
                if (isset($user['User']['id']) and !empty($user['User']['id'])) {
                    $bolean = true;
                }
            } else {
                $user = $this->User->find('first', ['conditions' => ['User.username' => $data['User']['username'], 'User.id !=' => $data['User']['id']]]);
                if (isset($user['User']['id']) and !empty($user['User']['id'])) {
                    $bolean = true;
                }
            }
        }
        if ($bolean == true) {
            $this->Session->setFlash("Ce nom d'utilisateur '".$data['User']['username']."' existe déja !<br/>Veuillez choisir un autre svp", 'alert-danger');

            return $this->redirect($this->referer());
        }
    }

    public function generate()
    {
        $this->loadModel('Parametreste');
        $params = $this->Parametreste->findList();

        $conditions = [];
        if (isset($params['Alert_groupe']) and !empty($params['Alert_groupe'])) {
            $conditions['Groupe.id'] = $params['Alert_groupe'];
        }
        $this->loadModel('Groupe');
        $groupe = $this->Groupe->find('first', ['conditions' => $conditions, 'contain' => ['User']]);

        $users = [];
        if (isset($groupe['User']) and !empty($groupe['User'])) {
            foreach ($groupe['User'] as $key => $value) {
                $users[$value['id']] = $value['id'];
            }
        }

        $today = date('Y-m-d');
        $duree = (isset($params['Alert_duree'])) ? $params['Alert_duree'] : 2;
        $today_plus = date('Y-m-d', strtotime(date('Y-m-d').' + '.$duree.' days'));

        if (!empty($users)) {
            $alerts = [];

            $this->loadModel('Avance');
            $payments = $this->Avance->find('all', [
                'conditions' => [
                    'Avance.etat' => -1,
                    'Avance.date_echeance >=' => $today,
                    'Avance.date_echeance <=' => $today_plus,
                ],
            ]);

            $payment_alerts = [];
            foreach ($payments as $k => $v) {
                $reference = (isset($v['Avance']['id']) and !empty($v['Avance']['id'])) ? $v['Avance']['reference'] : '';
                $message = "Alerte paiement d'échéance : ".$reference;
                $content = "Vous avez un paiement d'échéance ".$reference.' dans la date suivante : '.$v['Avance']['date_echeance'];
                $payment_alerts[$v['Avance']['id']]['Alert'] = [
                    'libelle' => $message,
                    'content' => $content,
                    'icon' => 'fa fa-dollar',
                    'link' => '/calendriers',
                ];

                $payment_alerts[$v['Avance']['id']]['User']['User'] = $users;
            }

            $alerts = array_merge(
                array_values($payment_alerts)
            );

            $this->loadModel('Alert');
            if ($this->Alert->query('TRUNCATE TABLE alerts;') and $this->Alert->AlertUser->query('TRUNCATE TABLE alerts_users;'));
            if (!empty($alerts) and $this->Alert->saveMany($alerts, ['deep' => true])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
