<?php

/**
 * Contao Open Source CMS
 *
 * @author    Jimmy Nogherot
 * @license   Payant
 * @copyright Tabula Rasa
 */

use trdev\ContaoBaseBundle\Classes\TypeChamp;

$t = basename(__FILE__, '.php');

/**
 * Table tl_bien
 */
$GLOBALS['TL_DCA'][$t] = array(

    // Config
    'config'      => array(
        'dataContainer'    => 'Table',
        'enableVersioning' => false, //True si tu veux du versionning
        'sql'              => array(
            'keys' => array(
                'id' => 'primary',
            ),
        ),
    ),

    // List
    'list'        => array(
        'sorting'           => array(
            'mode'        => 1,
            'fields'      => array('tstamp'),
            'panelLayout' => 'filter;sort,search,limit',
            'flag'        => 12, //https://docs.contao.org/dev/reference/dca/fields/#reference
        ),
        'label'             => array(
            'fields'      => array('name'),
            'showColumns' => false,
        ),
        'global_operations' => array(
            'all' => array(
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"',
            ),
        ),
        'operations'        => array(
            'edit'   => array(
                'label' => &$GLOBALS['TL_LANG'][$t]['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG'][$t]['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG'][$t]['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show'   => array(
                'label' => &$GLOBALS['TL_LANG'][$t]['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),

    // Select
    'select'      => array(
        'buttons_callback' => array(),
    ),

    // Edit
    'edit'        => array(
        'buttons_callback' => array(),
    ),

    // Palettes
    'palettes'    => array(
        '__selector__' => array(''),
        'default'      => 'name',
    ),

    // Subpalettes
    'subpalettes' => array(
        '' => 'text',
    ),

    // Fields
    'fields'      => array(
        'id'          => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ),
        'tstamp'      => array(
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'pid'         => array(
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'message'     => TypeChamp::textarea(true),
        'membre'      => TypeChamp::selectTable('tl_member.username', false, true),
        'utilisateur' => TypeChamp::selectTable('tl_user.username', false, true),
    ),
);

class tl_base extends Backend
{
    /*
     public function generateAlias($varValue, DataContainer $dc)
        {
            if ($varValue == '') {
                $varValue = BaseModel::getNewAlias();
            }
            return $varValue;
        }
    
        public function editColumns($row, $label, DataContainer $dc, $args)
        {
            $args[0] = date('d/m/Y H:i', $args[0]);
            $args[6] = FonctionsBlandin::printPrice($args[6]);
            return $args;
        }
    */
}
