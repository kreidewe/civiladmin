<?php
return [
    'ctrl' => array(
        'title' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contacts',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY name',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:civiladmin/Resources/Public/Icons/Extension.svg',
        'searchFields' => 'name',
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contacts.name',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'shorttext' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contacts.shorttext',
            'config' => array(
                'type' => 'text',
            )
        ),
        'prenom' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contacts.prenom',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'phone' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contacts.phone',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'fax' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contacts.fax',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'email' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contacts.email',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
    ),
    'types' => array(
        '0' => array('showitem' => 'name,prenom,phone,fax,email,shorttext,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden')
    ),
    'palettes' => array(
        '1' => array('showitem' => '')
    )
];