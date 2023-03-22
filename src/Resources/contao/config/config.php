<?php

/**
 * Contao Open Source CMS
 *
 *
 * @package   Fonctions Contao
 * @author    Jimmy Nogherot
 * @license   Not free
 * @copyright Tabula Rasa
 */

use trdev\ContaoBaseBundle\Element\ceBase;
use trdev\ContaoBaseBundle\Module\beBaseModel;

/**
 * Insert Tags
 */
//use trdev\ContaoBaseBundle

$GLOBALS['assetsFolder']['ContaoBaseBundle']    = "/bundles/contaobase/";
$GLOBALS['bundleNamespace']['ContaoBaseBundle'] = "trdev\\ContaoBaseBundle\\";

$helpers = $GLOBALS['assetsFolder']['ContaoBaseBundle'] . "helpers/";

//$exp = new cocciExport();
//$exp->exec();

//$GLOBALS['TL_CSS'][] = $GLOBALS['assetsFolder']['ContaoBaseBundle'] . "css/be.css";

//$GLOBALS['TL_JAVASCRIPT'][] = $GLOBALS['assetsFolder']['ContaoBaseBundle'] . "js/full/be.js";
//$GLOBALS['TL_JAVASCRIPT'][] = ($_ENV['APP_ENV'] == "dev") ? $GLOBALS['assetsFolder']['ContaoBaseBundle'] . 'js/full/chat.js' : $GLOBALS['assetsFolder']['ContaoBaseBundle'] . 'js/chat.min.js';
//$GLOBALS['TL_JAVASCRIPT'][] = ($_ENV['APP_ENV'] == "dev") ? $GLOBALS['assetsFolder']['ContaoBaseBundle'] . 'js/full/tickets.js' : $GLOBALS['assetsFolder']['ContaoBaseBundle'] . 'js/tickets.min.js';
//
//$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array(AjaxTickets::class, 'pageLoad');
//$GLOBALS['TL_HOOKS']['processFormData'][]        = array(TicketsFormSubmit::class, 'saveSubmission');

//$GLOBALS['FE_MOD']['Tabularasa']['Tabularasa-loader'] = loaderModule::class;

array_insert($GLOBALS['TL_CTE']['Tickets'], 1, array(
    'ceBase' => ceBase::class,
    //'Biens'        => ceBien::class,
    //'Pieces'       => cePiece::class,
    //'Liens'        => ceLien::class,
    //'Mandats'      => ceMandat::class,
    //'Recherche'    => ceRechercheBien::class,
    //'FicheVitrine' => ceFicheVitrine::class,
    //'Impression'   => ceImpression::class,
    //'BonVisite'    => ceBonVisite::class,
));

//Menu BE
array_insert($GLOBALS['BE_MOD']['groupe'], 98, array(
    'table' => array(
        'tables' => array('tl_base'),
    ),
    'module'    => array(
        'callback'         => beBaseModel::class,
        'hideInNavigation' => true,
    ),
));
