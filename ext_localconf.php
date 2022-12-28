<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

call_user_func(
    function()
    {
        if (TYPO3_MODE === 'BE') {
            $icons = [
                'ext-civiladmin_pi1-wizard-icon' => 'Extension.svg',
                'ext-civiladmin_pi2-wizard-icon' => 'Extension.svg',
            ];
            $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
            foreach ($icons as $identifier => $path) {
                $iconRegistry->registerIcon(
                    $identifier,
                    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                    ['source' => 'EXT:civiladmin/Resources/Public/Icons/' . $path]
                );
            }
        }
        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					civiladmin_dienstleistung {
					    iconIdentifier = ext-civiladmin_pi1-wizard-icon
						title = LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi1
						description = LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi1
						tt_content_defValues {
							CType = list
							list_type = civiladmin_pi1
						}
					}
					civiladmin_contact {
						iconIdentifier = ext-civiladmin_pi2-wizard-icon
						title = LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi2
						description = LLL:EXT:civiladmin/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi2
						tt_content_defValues {
							CType = list
							list_type = civiladmin_pi2
						}
					}					
				}
				show = *
			}
	   }'
        );
    }
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43('civiladmin', 'Classes/class.tx_civiladmin_pi1.php', '_pi1', 'list_type', 1);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43('civiladmin', 'Classes/class.tx_civiladmin_pi2.php', '_pi2', 'list_type', 1);

?>