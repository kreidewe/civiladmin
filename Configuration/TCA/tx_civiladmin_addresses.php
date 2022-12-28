<?php
return [
    'ctrl' => array (
        'title'     => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses',
        'label'     => 'street',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY street',
        'delete' => 'deleted',
        'enablecolumns' => array (
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:civiladmin/Resources/Public/Icons/Extension.svg',
        'searchFields' => 'name,street,zip,city',
    ),
    'columns' => array (
            'hidden' => array (
                'exclude' => 1,
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
                'config'  => array (
                    'type'    => 'check',
                    'default' => '0'
                )
            ),
            'name' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses.name',
                'config' => array (
                    'type' => 'input',
                    'size' => '30',
                )
            ),
            'street' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses.street',
                'config' => array (
                    'type' => 'input',
                    'size' => '30',
                )
            ),
            'housenr' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses.housenr',
                'config' => array (
                    'type' => 'input',
                    'size' => '30',
                )
            ),
            'room' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses.room',
                'config' => array (
                    'type' => 'input',
                    'size' => '30',
                )
            ),
            'zip' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses.zip',
                'config' => array (
                    'type' => 'input',
                    'size' => '30',
                )
            ),
            'city' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses.city',
                'config' => array (
                    'type' => 'input',
                    'size' => '30',
                )
            ),
            'busstation' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_addresses.busstation',
                'config' => array (
                    'type' => 'input',
                    'size' => '30',
                )
            ),
        ),
    'types' => array (
            '0' => array('showitem' => 'name,street,housenr,room,zip,city,busstation,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden')
        ),
    'palettes' => array (
            '1' => array('showitem' => '')
        )
];