<?php
return [
    'ctrl' => array(
        'title' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => array (
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:civiladmin/Resources/Public/Icons/Extension.svg',
        'searchFields' => 'title,synonyms,keywords',
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1),
                    array('LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0)
                )
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.title',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'slug' =>array(
            'exclude' => true,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.slug',
            'config' => array(
                'type' => 'slug',
                'generatorOptions' => array(
                    'fields' => ['title'],
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
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.synonyms',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'keywords' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.keywords',
            'config' => array(
                'type' => 'input',
                'size' => '30',
            )
        ),
        'description' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.description',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'cols' => '40',
                'rows' => '5',
            )
        ),
        'documents' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.documents',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'cols' => '30',
                'rows' => '5',
            )
        ),
        'costs' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.costs',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'cols' => '30',
                'rows' => '5',
            )
        ),
        'laws' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.laws',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'cols' => '30',
                'rows' => '5',
            )
        ),
        'forms' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.forms',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'cols' => '30',
                'rows' => '5',
            )
        ),
        'unit' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.unit',
            'config' => array(
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Verwaltunngseinheit bearbeiten'
                        )
                    ),
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Verwaltunngseinheit hinzufügen'
                        )
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'Verwaltunngseinheiten anzeigen'
                        )
                    ),
                ),
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_civiladmin_contact',
                'foreign_table_where' => 'ORDER BY tx_civiladmin_contact.uid',
                'size' => 6,
                'minitems' => 0,
                'maxitems' => 100,
            ),
        ),
        'contacts' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tx_civiladmin_dienstleistung.contacts',
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
                "MM" => "tx_civiladmin_dienstleistung_contacts_mm",
            )
        ),
    ),
    'types' => array(
        '0' => array('showitem' => 'title,slug,synonyms,keywords,description,documents,costs,laws,forms,--div--;LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xlf:tabs.relationships,unit,contacts,--div--;LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xlf:tabs.languages,sys_language_uid,l10n_parent,l10n_diffsource,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden')
    ),

    'palettes' => array(
        '1' => array('showitem' => '')
    )
];