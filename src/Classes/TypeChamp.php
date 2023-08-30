<?php
/**
 * Contao Open Source CMS
 *
 *
 * @package   Contao
 * @author    Jimmy Nogherot
 * @license   Not free
 * @copyright Tabula Rasa
 */

namespace trdev\ContaoBaseBundle\Classes;

class TypeChamp extends \Backend
{
    #region Texte
    /**
     * Créer un champ Texte en lien avec une table existante
     * @param bool $obligatoire
     * @param string $classe w50/clr
     * @return array
     */
    public static function text($obligatoire = false, $classe = 'w50')
    {
        $item = array(
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array('maxlength' => 255, 'tl_class' => $classe, 'mandatory' => $obligatoire),
            'sql'       => "varchar(255) NOT NULL default ''",
        );

        return $item;
    }
    #endregion

    #region Number
    /**
     * Créer un champ numérique en lien avec une table existante
     * @param bool $obligatoire
     * @return array
     */
    public static function number($obligatoire = false)
    {
        $item = array(
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array('maxlength' => 255, 'rgxp' => 'digit', 'tl_class' => 'w50', 'mandatory' => $obligatoire),
            'sql'       => "float(10) unsigned NOT NULL default '0'",
        );

        return $item;
    }
    #endregion

    #region TexteArea
    /**
     * Créer un champ Select en lien avec une table existante
     * @param bool $tinyMce
     * @param bool $obligatoire
     * @return array
     */
    public static function textarea($tinyMce = false, $obligatoire = false)
    {
        $item = array(
            'inputType'     => 'textarea',
            'eval'          => array(
                'tl_class'  => 'clr',
                'mandatory' => $obligatoire,
            ),
            'load_callback' => array(array('trdev\ContaoBaseBundle\Classes\TypeChamp', 'convertAbsoluteLinks')),
            'save_callback' => array(array('trdev\ContaoBaseBundle\Classes\TypeChamp', 'convertRelativeLinks')),
            'sql'           => "mediumtext NULL",
        );

        if ($tinyMce === true) {
            $item['eval']['rte']        = 'tinyNews';
            $item['eval']['helpwizard'] = true;
        }

        return $item;
    }
    #endregion

    #region Switch
    /**
     * Créer un champ avec juste une case a coché, fait office de Oui/Non
     * @param bool $obligatoire
     * @param int $default 0 ou 1
     * @return array
     */
    public function ouiNon($obligatoire = false, $default = '0')
    {
        $item = array(
            'inputType' => 'checkbox',
            'sql'       => "char(1) NOT NULL default '" . $default . "'",
            'eval'      => array('tl_class' => 'clr', 'mandatory' => $obligatoire),
        );

        return $item;
    }
    #endregion

    #region Date
    /**
     * Créer un champ avec juste une case a coché, fait office de Oui/Non
     * @param bool $heures On a les heures ou pas ?
     * @param bool $obligatoire
     * @param bool $classe w50/clr
     * @return array
     */
    public static function date($heures = false, $obligatoire = false, $classe = 'w50')
    {
        $rgxp = ($heures === true) ? 'datim' : 'date';
        $item = array(
            'inputType' => 'text',
            'eval'      => array('rgxp' => $rgxp, 'datepicker' => true, 'tl_class' => $classe, 'mandatory' => $obligatoire),
            'sql'       => "varchar(11) NOT NULL default ''",
        );

        return $item;
    }
    #endregion

    #region Select a partir d'une table
    /**
     * Créer un champ Select en lien avec une table existante
     * @param string $foreignKey tl_article.name
     * @param bool $multiple
     * @param bool $includeBlankOption
     * @param bool $obligatoire
     * @return array
     */
    public static function selectTable($foreignKey = '', $multiple = false, $includeBlankOption = false, $obligatoire = false)
    {
        $item = array(
            'inputType'  => 'select',
            'filter'     => true,
            'foreignKey' => $foreignKey,
            'sql'        => ($multiple === true) ? "blob NULL" : "int(10) unsigned NOT NULL default '0'",
            'eval'       => array('chosen' => true, 'includeBlankOption' => $includeBlankOption, 'multiple' => $multiple, 'tl_class' => 'w50', 'mandatory' => $obligatoire),
            'relation'   => array('type' => 'hasOne', 'load' => 'lazy'),
        );

        return $item;
    }
    #endregion

    #region Select
    /**
     * Créer un champ Select
     * @param array $options Liste des options dans un tableau (avec ou sans key)
     * @param bool $multiple
     * @param bool $includeBlankOption
     * @param bool $obligatoire
     * @param bool $autoSubmit Si on utilise des subpalettes
     * @return array
     */
    public static function select($options, $multiple = false, $includeBlankOption = false, $obligatoire = false, $autoSubmit = false)
    {
        $item = array(
            'inputType' => 'select',
            'filter'    => true,
            'options'   => $options,
            'sql'       => ($multiple === true) ? "blob NULL" : "varchar(255) NOT NULL default ''",
            'eval'      => array('chosen' => true, 'includeBlankOption' => $includeBlankOption, 'multiple' => $multiple, 'tl_class' => 'w50', 'mandatory' => $obligatoire, 'submitOnChange' => $autoSubmit),
        );

        return $item;
    }
    #endregion

    #region Checkboxs
    /**
     * Créer un champ Checkbox
     * @param array $options Liste des options dans un tableau (avec ou sans key)
     * @return array
     */
    public static function checkbox($options)
    {
        $item = array(
            'inputType' => 'checkbox',
            'options'   => $options,
            'eval'      => array(
                'multiple' => true,
            ),
            'sql'       => 'blob NULL',
        );

        return $item;
    }

    /**
     * Créer un champ Checkbox en lien avec une table
     * @param string $options tl_article.name
     * @return array
     */
    public static function checkboxTable($options)
    {
        $item = array(
            'inputType'  => 'checkbox',
            'foreignKey' => $options,
            'eval'       => array(
                'multiple' => true,
            ),
            'sql'        => 'blob NULL',
        );

        return $item;
    }

    /**
     * Créer un champ Checkbox qui récupère les options à partir d'une function
     * @param string $options array('maClasse','MaFonction')
     * @return array
     */
    public static function checkboxCallback($options)
    {
        $item = array(
            'inputType'        => 'checkbox',
            'options_callback' => $options,
            'eval'             => array(
                'multiple' => true,
            ),
            'sql'              => 'blob NULL',
        );

        return $item;
    }
    #endregion

    #region Fichiers
    /**
     * @param bool $multiple
     * @param bool $obligatoire
     * @return array
     */
    public static function fichier($multiple = false, $obligatoire = false)
    {
        $item = array(
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => [
                'tl_class'   => 'clr',
                'mandatory'  => $obligatoire,
                'fieldType'  => ($multiple === true) ? 'checkbox' : 'radio',
                'multiple'   => $multiple,
                'files'      => true,
                'extensions' => \Contao\Config::get('uploadTypes'),
                //'path'      => sprintf('/files/uploads/%s/%s/', date('Y'), date('m')),
            ],
            'sql'       => "blob NULL",
        );
        /*
        $item = array(
        'exclude'   => true,
        'inputType' => 'multifileupload',
        'eval'      => [
        'tl_class'     => 'clr',
        'fieldType'    => ($multiple === true) ? 'checkbox' : 'radio',
        'uploadFolder' => sprintf('/files/uploads/%s/%s/', date('Y'), date('m')),
        'labels'       => array(
        'head' => 'Pour télécharger un fichier, déposez-le ici ou cliquez sur le champ.',
        ),
        ],
        'sql'       => "blob NULL",
        );
         */
        return $item;
    }
    #endregion

    #region Dossier
    /**
     * @param bool $multiple
     * @param bool $obligatoire
     * @return array
     */
    public static function dossier($multiple = false, $obligatoire = false)
    {
        $item = array(
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => [
                'tl_class'  => 'clr',
                'mandatory' => $obligatoire,
                'fieldType' => ($multiple === true) ? 'checkbox' : 'radio',
                'multiple'  => $multiple,
                'files'     => false,
            ],
            'sql'       => "blob NULL",
        );
        return $item;
    }
    #endregion

    #region Multicolumn
    /**
     * @param string $table tl_article
     * @param string $champ nomChamp
     * @param array $cols array('annee' => 'text', 'id' => 'text')
     * @param array $options
     * @return array
     */
    public static function mcw($table, $champ, $cols, $options = false)
    {
        $item = array(
            'exclude'   => true,
            'inputType' => 'multiColumnWizard',
            'eval'      => array
            (
                'tl_class' => 'clr',
            ),
            'sql'       => "blob NULL",
        );

        foreach ($cols as $key => $value) {
            $val = array(
                'label' => &$GLOBALS['TL_LANG'][$table][$champ][$key],
            );
            switch ($value) {
                case 'date':
                    $val['inputType'] = 'text';
                    $val['eval']      = array(
                        'rgxp'       => 'date',
                        'datepicker' => true,
                        'tl_class'   => 'wizard',
                    );
                    break;
                case 'select':
                    $val['inputType'] = 'select';
                    $val['options']   = $options[$key];
                    $var['eval']      = array(
                        'includeBlankOption' => true,
                    );
                    break;
                case 'selectTable':
                    $val['inputType']  = 'select';
                    $val['foreignKey'] = $options[$key];
                    $var['eval']       = array(
                        'includeBlankOption' => true,
                    );
                    break;

                default:
                    $val['inputType'] = $value;
                    break;
            }
            $item['eval']['columnFields'][$key] = $val;
        }
        return $item;
    }
    #endregion

    #region List Wizard
    public static function listWizard()
    {
        $item = array(
            'inputType' => 'listWizard',
            'eval'      => array(
                'maxlength' => 255,
                'allowHtml' => false,
            ),
            'sql'       => 'blob NULL',
        );

        return $item;
    }
    #endregion

    #region Alias
    public static function alias($table)
    {
        $item = array(
            'inputType'     => 'text',
            'search'        => true,
            'sql'           => "varchar(255) NOT NULL default ''",
            'eval'          => array('rgxp' => 'alias', 'doNotCopy' => true, 'unique' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'save_callback' => array
            (
                array($table, 'generateAlias'),
            ),
        );

        return $item;
    }
    #endregion

    #region Traductions = Ajouter les traductions de base, commune a une grande majorité des tables
    public static function traductions($t)
    {
        $GLOBALS['TL_LANG'][$t]['name'][0]      = "Nom";
        $GLOBALS['TL_LANG'][$t]['alias'][0]     = "Alias";
        $GLOBALS['TL_LANG'][$t]['tstamp'][0]    = "Date de création";
        $GLOBALS['TL_LANG'][$t]['published'][0] = "Publié ?";

        $GLOBALS['TL_LANG'][$t]['system'] = "Champs système";

        $GLOBALS['TL_LANG'][$t]['new']     = array('Nouveau ', 'Ajouter');
        $GLOBALS['TL_LANG'][$t]['show']    = array(' détails', 'Montrer les détails  ID %s');
        $GLOBALS['TL_LANG'][$t]['edit']    = array('Editer ', 'Editer  ID %s');
        $GLOBALS['TL_LANG'][$t]['cut']     = array('Déplacer ', 'Déplacer  ID %s');
        $GLOBALS['TL_LANG'][$t]['copy']    = array('Dupliquer ', 'Dupliquer  ID %s');
        $GLOBALS['TL_LANG'][$t]['delete']  = array('Effacer ', 'Effacer  ID %s');
        $GLOBALS['TL_LANG'][$t]['toggle']  = array('Publier ', 'Publier  ID %s');
        $GLOBALS['TL_LANG'][$t]['feature'] = array('Mise en avant ', 'Mettre en avant ID %s');
    }
    #endregion

    public static function toggleButton($table)
    {
        return array(
            'label'           => &$GLOBALS['TL_LANG'][$table]['toggle'],
            'icon'            => 'visible.gif',
            'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
            'button_callback' => array($table, 'toggleIcon'),
        );
    }

    /*
    Dans la table parent, appellé comme suit :
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
    return TypeChamp::toggleIcon($this, $row, $href, $label, $title, $icon, $attributes);
    }
     */
    public function toggleIcon($table, $row, $href, $label, $title, $icon, $attributes)
    {
        $table->import('BackendUser', 'User');
        if (strlen($table->Input->get('tid'))) {
            $table->toggleVisibility($table->Input->get('tid'), ($table->Input->get('state') == 0));
            $table->redirect($table->getReferer());
        }

        $href .= '&amp;id=' . $table->Input->get('id') . '&amp;tid=' . $row['id'] . '&amp;state=' . $row[''];
        if (!$row['published']) {
            $icon = 'invisible.gif';
        }
        return '<a href="' . $table->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $table->generateImage($icon, $label) . '</a> ';
    }

    /*
    Dans la table parent, appellé comme suit :
    public function toggleVisibility($intId, $blnPublished)
    {
    return TypeChamp::toggleVisibility($this, $intId, $blnPublished);
    }
     */
    public function toggleVisibility($table, $intId, $blnPublished)
    {
        $tableName = get_class($table);
        $table->createInitialVersion($tableName, $intId);

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA'][$tableName]['fields']['published']['save_callback'])) {
            foreach ($GLOBALS['TL_DCA'][$tableName]['fields']['published']['save_callback'] as $callback) {
                $table->import($callback[0]);
                $blnPublished = $table->$callback[0]->$callback[1]($blnPublished, $table);
            }
        }

        // Update the database
        $table->Database->prepare("UPDATE " . $tableName . " SET tstamp=" . time() . ", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")->execute($intId);
    }

    public static function checkAlias($baseStr, $table, $i = 0)
    {
        $str = ($i != 0) ? $baseStr . '-' . $i : $baseStr;

        if ($table->Database->prepare("SELECT id FROM " . get_class($table) . " WHERE alias=?")->execute($str)->numRows > 0) {
            return self::checkAlias($baseStr, $table, $i + 1);
        } else {
            return $str;
        }
    }

    public static function generateAlias($values, $table)
    {
        $varValue = implode('_', $values);
        $alias    = \System::getContainer()->get('contao.slug')->generate($varValue);
        return self::checkAlias($alias, $table);
    }

    public static function printIcon($fichier)
    {
        return sprintf('%simg/%s', $GLOBALS['assetsFolder']['ContaoBaseBundle'], $fichier);
    }

    public function convertAbsoluteLinks($strContent)
    {
        return str_replace('src="' . \Environment::get('base'), 'src="', $strContent);
    }

    public function convertRelativeLinks($strContent)
    {
        return $this->convertRelativeUrls($strContent);
    }
}

class_alias(TypeChamp::class, 'TypeChamp');
