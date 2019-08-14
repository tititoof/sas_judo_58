<?php

namespace App\Helpers;

/**
 * Helper message
 */
class Answer
{
    /**
     *
     */
    const SUCCESS = true;

    const ERROR   = false;

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


    /**
     * Success return
     */
    public static function success($code, $data = null)
    {
        return [
            'success' => self::SUCCESS,
            'code' => $code,
            'message' => self::TYPES_SUCCESS[$code],
            'data' => $data
        ];
    }


    /**
     * Error return
     */
    public static function error($exception, $data = null)
    {
        return [
            'success'   => self::ERROR,
            'code'      => array_key_exists($exception->getCode(), self::TYPES_ERROR) ? $exception->getCode() : 400,
            'message'   => self::TYPES_ERROR[$exception->getCode()] ?? $exception->getMessage(),
            'data'      => $data
        ];
    }

}
