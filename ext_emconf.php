<?php
	$EM_CONF[$_EXTKEY]=
	[
		'title' => 'civiladmin',
		'description' => '',
		'category' => 'be',
		'author' => 'Krzysztof Napora',
        'author_email' => 'k.napora@familie-redlich.de',
		'state' => 'stable',
		'internal' => '',
		'uploadfolder' => 0,
		'createDirs' => '',
		'clearCacheOnLoad' => 1,
		'author_company' => '',
		'version' => '1.0.0',
		'constraints' =>
		[
			'depends' =>
			[
				'typo3' => '10.4.0-11.9.99',
				'typo3db_legacy' => '1.0.1-1.9.9'
			],
			'conflicts' => [],
			'suggests' => [],
		],
	];
?>