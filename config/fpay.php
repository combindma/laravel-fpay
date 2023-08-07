<?php

// config for Combindma/Fpay
return [
    /*
     * Identifiant du marchand (attribué par Fpay)
     * */
    'merchantId' => env('FPAY_MERCHANT_ID', ''),

    /*
     * clé secrète du magasin (configurée dans votre espace back office de la plate-forme Fpay)
     * */
    'merchantKey' => env('FPAY_MERCHANT_KEY', ''),

    /*
    * La langue utilisée lors de l’affichage des pages de paiement. Valeurs possibles : ar, fr, en
    * */
    'lang' => env('FPAY_DEFAULT_LANG', 'fr'),

    /*
    * Code ISO de la devise par défaut de la transaction
    * */
    'currency' => env('FPAY_DEFAULT_CURRENCY', '504'),

    /*
     * Gateway de paiement en mode web (attribué par Fpay)
     * */
    'baseUri' => env('FPAY_BASE_URI', 'https://payment.fpay-worldwide.com/sandbox/fpay-frontend/fpayreq'),

    /*
     * URL pour rediriger le navigateur du client vers le site marchand. Ce renvoi se fait à l’initiative du client en cliquant sur le lien “Retour Marchand” de la page résultat.
     * */
    'merchantUrl' => env('FPAY_MERCHANT_URL', ''),

    /*
     * URL que FPAY fait appel pour notifier le site marchand du déroulement de la transaction.
     * */
    'callbackUrl' => env('FPAY_URLREPAUTO', ''),

    /*
     * Type de la transaction
     * */
    'tranType' => 'AUTH',

    /*
     * Type de la transaction
     * */
    'tranMode' => 'MODE',

    /*
     * Capturer la transaction
     * */
    'tranCapture' => 'false',
];
