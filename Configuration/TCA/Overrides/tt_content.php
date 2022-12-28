<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_civiladmin_dienstleistung');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi1',
        'civiladmin_pi1',
        'EXT:civiladmin/Resources/Public/Icons/Extension.svg'
    ),
    'list_type',
    'civiladmin'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi2',
        'civiladmin_pi2',
        'EXT:civiladmin/Resources/Public/Icons/Extension.svg'
    ),
    'list_type',
    'civiladmin'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'civiladmin_pi1',
    'FILE:EXT:civiladmin/Configuration/FlexForms/flexform_pi1.xml'
);

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['civiladmin_pi1']='layout,select_key,pages';

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['civiladmin_pi1']='layout,select_key,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['civiladmin_pi1'] = 'pi_flexform';

});