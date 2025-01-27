<?php
App::uses('AppModel', 'Model');

/**
 * Registrepassation Model
 *
 * Représente la table `registrepassation` dans la base de données.
 */
class Registrepassation extends AppModel {
    /**
     * Nom de la table (si différent du nom du modèle au pluriel)
     *
     * @var string
     */
    public $useTable = 'registrepassation';

    /**
     * Comportements utilisés
     */
    public $actsAs = ['Containable']; // Ajoutez ici les comportements si nécessaire.

    /**
     * Règles de validation
     *
     * Permet de définir les règles de validation des champs.
     */
    public $validate = [
        'reference' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'La référence est obligatoire.',
                'required' => true,
            ]
        ],
        'Objectif' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'L’objectif est obligatoire.',
                'required' => true,
            ]
        ],
        'date' => [
            'date' => [
                'rule' => ['date', 'ymd'],
                'message' => 'Veuillez entrer une date valide au format AAAA-MM-JJ.',
                'allowEmpty' => true,
            ]
        ],
        'statut' => [
            'numeric' => [
                'rule' => 'numeric',
                'message' => 'Le statut doit être un nombre.',
                'required' => true,
            ]
        ]
    ];

    /**
     * Relations entre modèles
     *
     * Définir les associations si la table est liée à d'autres tables.
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
        ],
        'Depot' => [
            'className' => 'Depot',
            'foreignKey' => 'depot_id',
        ]
    ];

    public $hasMany = [
        // Exemple si `Registrepassation` a des relations `hasMany`.
        // 'OtherModel' => [
        //     'className' => 'OtherModel',
        //     'foreignKey' => 'registrepassation_id',
        //     'dependent' => true,
        // ]
    ];

    /**
     * Méthodes personnalisées
     */

    /**
     * Exemple : méthode pour obtenir tous les enregistrements actifs
     *
     * @return array
     */
    public function getActiveEntries() {
        return $this->find('all', [
            'conditions' => [
                'Registrepassation.deleted' => 0,
                'Registrepassation.statut >' => 0
            ],
            'order' => ['Registrepassation.date' => 'DESC']
        ]);
    }
}
