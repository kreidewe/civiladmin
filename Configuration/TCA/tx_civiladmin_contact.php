<?php
return [
    'ctrl' => array(
        'title' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
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
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.name',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'slug' =>array(
            'exclude' => true,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.slug',
            'config' => array(
                'type' => 'slug',
                'generatorOptions' => array(
                    'fields' => ['name'],
                    'replacements' => array(
                        '/' => ''
                    ),
                ),
                'fallbackCharacter' => '-',
                'prependSlash' => false,
                'eval' => 'uniqueInPid'
            ),
        ),
        'synonyms' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.synonyms',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'address' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.address',
            'config' => array(
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Adresse bearbeiten'
                        )
                    ),
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Adresse hinzufügen'
                        )
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Adressen anzeigen'
                        )
                    ),
                ),
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_civiladmin_addresses',
                'foreign_table_where' => 'ORDER BY tx_civiladmin_addresses.street',
                'size' => 6,
                'minitems' => 0,
                'maxitems' => 100,
            )
        ),
        'phone' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.phone',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'fax' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.fax',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'email' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.email',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'boss' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.boss',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'contacts' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.contacts',
            'config' => array(
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Kontakt bearbeiten'
                        )
                    ),
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Kontakt hinzufügen'
                        )
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Kontakte anzeigen'
                        )
                    ),
                ),
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_civiladmin_contacts',
                'foreign_table_where' => 'ORDER BY tx_civiladmin_contacts.uid',
                'size' => 6,
                'minitems' => 0,
                'maxitems' => 100,
                "MM" => "tx_civiladmin_contact_contacts_mm",
            )
        ),
        'oeffnungszeiten' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.oeffnungszeiten',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'cols' => '30',
                'rows' => '5',
            )
        ),
        'parent' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_contact.parent',
            'config' => array(
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Verwaltungseinheit bearbeiten'
                        )
                    ),
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Verwaltungseinheit hinzufügen'
                        )
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Verwaltungseinheiten anzeigen'
                        )
                    ),
                ),
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_civiladmin_contact',
                'foreign_table_where' => 'ORDER BY tx_civiladmin_contact.name',
                'size' => 6,
                'maxitems' => 1,
                'default' => 0
            )
        ),
    ),
    'types' => array(
        '0' => array('showitem' => 'name,slug,synonyms,boss,oeffnungszeiten,--div--;LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xlf:tabs.contact_data,address,phone,fax,email,contacts,--div--;LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xlf:tabs.structure,parent,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden')

    ),
    'palettes' => array(
        '1' => array('showitem' => '')
    )
];