<?php

namespace App\Traits;

class Answer
{
    const SUCCES = 'success';
    
    const ERROR  = 'error';
    
    const TYPES_ERROR = [
        '400'   => 'La syntaxe de la requête est erronée.',
        '401'   => 'Une authentification est nécessaire pour accéder à la ressource.',
        '403'   => 'Le serveur a compris la requête, mais refuse de l\'exécuter.',
        '404'   => 'Ressource non trouvée.',
        '405'   => 'Méthode de requête non autorisée.',
        '422'   => 'L’entité fournie avec la requête est incompréhensible ou incomplète.',
        '456'   => 'Erreur irrécupérable.',
    ];
    
    const TYPES_SUCCESS = [
        '200'   => 'Requête traitée avec succès.',
        '201'   => 'Requête traitée avec succès et création d’un document.',
        '202'   => 'Requête traitée, mais sans garantie de résultat.',
        '206'   => 'Une partie seulement de la ressource a été transmise.',
    ];
    
}