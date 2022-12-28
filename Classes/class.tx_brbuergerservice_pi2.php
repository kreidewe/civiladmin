<?php
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;

class tx_civiladmin_pi2 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{
	var $prefixId	  = 'tx_civiladmin_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_civiladmin_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey		= 'civiladmin';	// The extension key.
	var $pi_checkCHash = true;
	var $debugMode		 = false;

	/**
	 * Main method of your PlugIn
	 *
	 * @param	string		$content: The content of the PlugIn
	 * @param	array		$conf: The PlugIn Configuration
	 * @return   string The content that should be displayed on the website
	 */
	function main($content, $conf)	{
		$this->init();
		switch((string)$conf['CMD'])	{
			case 'singleView':
				list($t) = explode(':',$this->cObj->currentRecord);
				$this->internal['currentTable']=$t;
				$this->internal['currentRow']=$this->cObj->data;
				return $this->pi_wrapInBaseClass($this->singleView($content, $conf));
				break;
			default:
				if (strstr($this->cObj->currentRecord,'tt_content'))	{
					$conf['pidList'] = $this->cObj->data['pages'];
					$conf['recursive'] = $this->cObj->data['recursive'];
				}
				return $this->pi_wrapInBaseClass($this->listView($content, $conf));
				break;
		}
	}


	protected function init()
	{
		$this->pi_loadLL('EXT:civiladmin/Resources/Private/Language/Plugin/locallang_pi2.xlf'); // Loading language-labels
	}

	/**
	 * Shows a list of database entries
	 *
	 * @param	string		$content: content of the PlugIn
	 * @param	array		$conf: PlugIn Configuration
	 * @return   string HTML list of table entries
	 */
	function listView($content, $conf) {
		$this->conf = $conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();		// Loading the LOCAL_LANG values

		$lConf = $this->conf['listView.'];	// Local settings for the listView function

		if (is_numeric($this->piVars['showUid']))	{	// If a single element should be displayed:
			$this->internal['currentTable'] = 'tx_civiladmin_contact';
			$this->internal['currentRow'] = $this->pi_getRecord('tx_civiladmin_contact',$this->piVars['showUid']);

			$content = $this->singleView($content, $conf);
			return $content;
		} else {
			if (!isset($this->piVars['pointer']))	$this->piVars['pointer']=0;
			if (!isset($this->piVars['mode']))	$this->piVars['mode']=1;

			// Initializing the query parameters:
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['results_at_a_time'],0,1000,3);		// Number of results to show in a listing.
			$this->internal['maxPages']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['maxPages'],0,1000,2);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='name,phone,fax,email,boss,oeffnungszeiten';
			$this->internal['orderByList']='uid,name,phone,fax,email,boss';


			// Make listing query, pass query to SQL database:
			$this->internal['currentTable'] = 'tx_civiladmin_contact';

			// debug, if in debug mode AND in IP-DEV-Zone
			if($this->debugMode) { //
				$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
			}

			/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
			$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->internal['currentTable']);
			$queryBuilder
				->select('uid','name','parent')
				->from('tx_civiladmin_contact')
				->orderBy('tx_civiladmin_contact.sorting');
			$res = $queryBuilder->execute();

			// debug, if in debug mode AND in IP-DEV-Zone
			if($this->debugMode) {
				\TYPO3\CMS\Core\Utility\DebugUtility::debug($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);
			}

			// Put the whole list together:
			$fullTable='';	// Clear var;


			// Adds the whole list table
			$fullTable.=$this->pi_list_makeTreelist($res);

			// Adds the result browser:
			$fullTable.=$this->pi_list_browseresults();

			// Returns the content from the plugin.
			return $fullTable;
		}
	}

	/**
	 * displays the tree
	 * @param \Doctrine\DBAL\Driver\Mysqli\MysqliStatement
	 * @return string
	 */
	function pi_list_makeTreelist( $res) {
		$ret = '';
		$items = array();

		if($res) {

			if($res->rowCount() > 0) {
				// get the rows
				while ($row = $res->fetch()) {
					$items[ ] = (object) array('id' => $row['uid'], 'parent_id' => $row['parent'], 'name' => $row['name']);
				}

			}

		}

		// Build the tree
		$tree = $this->buildTree($items);
		$ret = $this->printTree($tree);

		return $ret ;
	}



	/*
	 *
	 * */
	function buildTree($items) {

		$childs = array();

		foreach($items as $item)
			$childs[$item->parent_id][] = $item;

		foreach($items as $item) if (isset($childs[$item->id]))
			$item->childs = $childs[$item->id];

		return $childs[0];
	}



	/** printTree
	 *
	 */
	function printTree($items)
	{
		$ret = '';

		$plusIcon = '<img src="typo3conf/ext/civiladmin/Resources/Public/Brb_muster/Images/open-normal.png" height="12" width="19" alt="Aufklappen" title="Strukturebene aufklappen" class="plusInfo" />';
		$minusIcon = '<img src="typo3conf/ext/civiladmin/Resources/Public/Brb_muster/Images/close-normal.png" height="12" width="19" alt="Zuklappen" title="Strukturebene zuklappen" class="minusInfo" />';
		$noSubIconTree = '<img src="typo3conf/ext/brb_template/Resources/Public/Brb_muster/Images/nosubelements.png" height="12" width="19" alt="Keine Unterpunkte" class="minusInfo" />';

		$subCssClassWithNodes = 'withSub';
		$subCssClassWithoutNodes = 'withoutSub';
		$icon = $noSubIconTree;

		foreach($items as $item)
		{
			if(isset($item->id))
			{
				if(is_array($item->childs))
				{
					foreach($item->childs as $child1)
					{
						// if has childs
						if($child1->childs)
						{
							$subCssClass = $subCssClassWithNodes;
							$icon = $minusIcon;
							$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child1->id.'">'.$icon . '</span><span class="linkOrga">' . $this->pi_list_linkSingle($child1->name,$child1->id,1) . '</span>';
						}
						else
						{
							$subCssClass = $subCssClassWithoutNodes;
							$icon = $noSubIconTree;
							$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child1->id.'">' . $icon . '</span><span class="linkOrga">' . $this->pi_list_linkSingle($child1->name,$child1->id,1) . '</span>';
						}
						$ret .= '<li class="level_02 sub_o_m_' . $child1->parent_id . ' sub_m_' . $child1->parent_id . '">'.$liSpan.'</li>';
						if (is_array($child1->childs))
						{
							foreach($child1->childs as $child2)
							{
								if($child2->childs)
								{
									$subCssClass = $subCssClassWithNodes;
									$icon = $plusIcon;
									$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child2->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child2->name, $child2->id,1) . '</span>';
								}
								else
								{
									$subCssClass = $subCssClassWithoutNodes;
									$icon = $noSubIconTree;
									$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child2->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child2->name, $child2->id,1) . '</span>';
								}

								$ret .= '<li class="level_03 sub_o_m_' . $child2->parent_id . ' sub_m_' . $child2->parent_id . '">'.$liSpan.'</li>';
								if(is_array($child2->childs))
								{
									foreach($child2->childs as $child3)
									{
										if($child3->childs)
										{
											$subCssClass = $subCssClassWithNodes;
											$icon = $plusIcon;
											$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child3->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child3->name,$child3->id,1) . '</span>';
										}
										else
										{
											$subCssClass = $subCssClassWithoutNodes;
											$icon = $noSubIconTree;
											$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child3->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child3->name,$child3->id,1) . '</span>';
										}
										$ret .= '<li class="level_04 sub_o_m_' . $child3->parent_id . ' sub_m_' . $child3->parent_id . ' sub_m_' . $child2->parent_id . '">'.$liSpan.'</li>';

										if(is_array($child3->childs))
										{
											foreach($child3->childs as $child4)
											{
												if($child4->childs)
												{
													$subCssClass = $subCssClassWithNodes;
													$icon = $plusIcon;
													$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child4->id.'">'.$icon. '</span><span class="linkOrga">' . $this->pi_list_linkSingle($child4->name,$child4->id,1) . '</span>';
												}
												else
												{
													$subCssClass = $subCssClassWithoutNodes;
													$icon = $noSubIconTree;
													$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child4->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child4->name,$child4->id,1) . '</span>';
												}
												$ret .= '<li class="level_05 sub_o_m_' . $child4->parent_id . ' sub_m_' . $child4->parent_id . ' sub_m_' . $child3->parent_id . ' sub_m_' . $child2->parent_id . '">'.$liSpan.'</li>';

												if(is_array($child4->childs))
												{
													foreach($child4->childs as $child5)
													{
														if($child5->childs)
														{
															$subCssClass = $subCssClassWithNodes;
															$icon = $plusIcon;
															$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child5->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child5->name,$child5->id,1) . '</span>';
														}
														else
														{
															$subCssClass = $subCssClassWithoutNodes;
															$icon = $noSubIconTree;
															$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child5->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child5->name,$child5->id,1) . '</span>';
														}

														$ret .= '<li class="level_06 sub_o_m_' . $child5->parent_id . ' sub_m_' . $child5->parent_id . ' sub_m_' . $child4->parent_id . ' sub_m_' . $child3->parent_id . ' sub_m_' . $child2->parent_id . '">'.$liSpan.'</li>';
														if(is_array($child5->childs))
														{
															foreach($child5->childs as $child6)
															{
																if($child6->childs)
																{
																	$subCssClass = $subCssClassWithNodes;
																	$icon = $plusIcon;
																	$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child6->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child6->name,$child6->id,1) . '</span>';
																}
																else
																{
																	$subCssClass = $subCssClassWithoutNodes;
																	$icon = $noSubIconTree;
																	$liSpan = '<span class="'.$subCssClass.'" id="m_'.$child6->id.'">'.$icon.'</span><span class="linkOrga">' . $this->pi_list_linkSingle($child6->name,$child6->id,1) . '</span>';
																}
																$ret .= '<li class="level_07 sub_m_' . $child6->parent_id . ' sub_o_m_' . $child6->parent_id . ' sub_m_' . $child5->parent_id . ' sub_m_' . $child4->parent_id . ' sub_m_' . $child3->parent_id . ' sub_m_' . $child2->parent_id . '">'.$liSpan.'</li>';
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$ret='<ul'.$this->pi_classParam('structureList').'>'.$ret.'</ul>';


		return $ret;
	}

	/**
	 * @param $row
	 * @return string HTML-List
	 */

	function subItemsList($row)
	{
		/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
		$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->internal['currentTable']);
		$queryBuilder
			->select('uid', 'name', 'parent')
			->from('tx_civiladmin_contact')
			->where(
				$queryBuilder->expr()->eq('parent', $queryBuilder->createNamedParameter($row['uid'], \PDO::PARAM_INT))
			)
			->orderBy('tx_civiladmin_contact.sorting');
		$res = $queryBuilder->execute();

		$ret = '';
		$items = array();
		if ($res) {

			// get the rows
			if ($res->rowCount() > 0) {
				while ($row = $res->fetch()) {
					$items[] = (object)array('id' => $row['uid'], 'parent_id' => $row['parent'], 'name' => $row['name']);
				}

			}

		}

		foreach ($items as $item) {
			$ret .= "<li>" . $this->pi_list_linkSingle($item->name, $item->id, 1) . "</li>";
		}

		if ($items) {
			$ret = '<ul' . $this->pi_classParam('subunitList') . '>' . $ret . '</ul>';
		}

		return $ret;
	}



	/**
	 * Display a single item from the database
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return   string HTML of a single database entry
	 */
	function singleView($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->init();

		$content='<div'.$this->pi_classParam('singleView').'>
			<h2>'.$this->internal['currentRow']['name'].'</h2>';

		if(trim($this->getFieldContent('address'))) {
			$content.='<h3>'. $this->pi_getLL('address') . '</h3>' . $this->getFieldContent('address');
		}

		if($this->getFieldContent('phone')) {
			$content.='<h3>' . $this->pi_getLL('phone') . '</h3><p>' . $this->getFieldContent('phone').'</p>';
		}

		if($this->getFieldContent('fax')) {
			$content.='<h3>' . $this->pi_getLL('fax') . '</h3><p>' . $this->getFieldContent('fax').'</p>';
		}

		if($this->getFieldContent('email') &&  \TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($this->getFieldContent('email'))) {
			$content.='<h3>' . $this->pi_getLL('email') . '</h3><p>' . $this->cObj->getTypoLink($this->getFieldContent('email'),$this->getFieldContent('email')).'</p>';
		}

		if($this->getFieldContent('boss')) {
			$content.= '<h3>' . $this->pi_getLL('boss') . '</h3><p>' . $this->getFieldContent('boss').'</p>';
		}

		if($this->getFieldContent('contacts')) {
			$content.='<h3>' . $this->pi_getLL('contacts') . '</h3><p>' . $this->getFieldContent('contacts').'</p>';
		}

		if($this->getFieldContent('oeffnungszeiten')) {
			$content.= '<h3>' . $this->pi_getLL('opening_hours') . '</h3><p>' . $this->getFieldContent('oeffnungszeiten');
		}

		if($this->getFieldContent('services')) {
			$content.= '<h3>' . $this->pi_getLL('services') . '</h3><p>' . $this->getFieldContent('services').'</p>';
		}

		if ($this->subItemsList($this->internal['currentRow'])) {
			$content.= '<h3>' . $this->pi_getLL('subordinate_offices') . '</h3><p>' . $this->subItemsList($this->internal['currentRow']);
		}

		$currentPage = $this->pi_getPageLink((int)$GLOBALS['TSFE']->id);
		$content.='<p class="backList">'.$this->pi_linkToPage($this->pi_getLL('back_to_list'),$currentPage).'</p></div>';

		return $content;
	}
	/**
	 * Returns a single table row for list view
	 *
	 * @param	integer		$c: Counter for odd / even behavior
	 * @return   string A HTML table row
	 */
	function pi_list_row($c)	{

		return '<li>'.$this->getFieldContent('name').'</li>';
	}
	/**
	 * Returns a table row with column names of the table
	 *
	 * @return	A HTML table row
	 */
	function pi_list_header()	{
		return '';
	}
	/**
	 * Returns the content of a given field
	 *
	 * @param	string		$fN: name of table field
	 * @return   string Value of the field
	 */
	function getFieldContent($fN)	{

		$pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(PageRepository::class);

		switch($fN) {
			case 'uid':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
				break;

			case 'name':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
				break;

			case 'oeffnungszeiten':
				return $this->pi_RTEcssText($this->internal['currentRow'][$fN]);
				break;

			case "address":
				$ret = '';
				if($this->internal['currentRow'][$fN]) {

					/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
					$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->internal['currentTable']);
					$queryBuilder
						->select('*')
						->from('tx_civiladmin_addresses')
						->where(
							$queryBuilder->expr()->in('uid', $queryBuilder->createNamedParameter($this->internal['currentRow'][$fN], \PDO::PARAM_INT))
						);
					$res = $queryBuilder->execute();

					while ($row = $res->fetch()) {
						$ret .= '<p>' . $row['street'] . '<br />
								 ' . $row['zip'] . ' ' . $row['city'] . '<br />
								 <strong>' .$this->pi_getLL('subtitle_addresses') .'</strong> ' . $row['busstation'] . '</p>
								';
					}
				}

				return $ret;
				break;

			case "services":
				$ret = '';

				if($this->internal['currentRow']['uid']) {

					/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
					$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->internal['currentTable']);
					$queryBuilder
						->select('*')
						->from('tx_civiladmin_dienstleistung')
						->where(
							$queryBuilder->expr()->in('unit', $queryBuilder->createNamedParameter($this->internal['currentRow']['uid'], \PDO::PARAM_INT))
						)
						->orderBy('title', 'asc');
					$res = $queryBuilder->execute();

					while ($row = $res->fetch()) {
						$ret .= '<li>' . $this->pi_linkTP($row['title'], array('tx_civiladmin_pi1' => array('showUid' => $row['uid']) ), TRUE, 4651) . '</li>';
					}
				}

				if($ret) $ret = '<ul class="services">' . $ret . '</ul>';

				return $ret;
				break;


			case "contacts":
				$ret = '';

				if($this->internal['currentRow'][$fN] > 0) {

					$where =  ' AND tx_civiladmin_contact.uid = ' . $this->internal['currentRow']['uid'] .
						$pageRepository->enableFields('tx_civiladmin_contact') .
						$pageRepository->enableFields('tx_civiladmin_contacts');

					$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query('tx_civiladmin_contacts.*',
						'tx_civiladmin_contact',
						'tx_civiladmin_contact_contacts_mm',
						'tx_civiladmin_contacts',
						$where,
						'tx_civiladmin_contact_contacts_mm.sorting'
					);


					while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
						$ret .= '<li style="margin-bottom:1em">';

						if($row['name'])
						$ret .= '<strong>' . $row['prenom'] . ' ' . $row['name'] . '</strong>';

						if($row['phone'])
						$ret .= '<p>' . $this->pi_getLL('short_phone'). ' ' . $row['phone'] . '</p>';

						if($row['fax'])
						$ret .= '<p>' . $this->pi_getLL('short_fax'). ' ' . $row['fax'] . '</p>';

						if ($row['email'] &&  \TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($row['email']))
						$ret .= '<p>' . $this->pi_getLL('short_email') . ' ' . $this->cObj->getTypoLink($row['email'],$row['email']) . '</p>';

						if($row['shorttext'])
						$ret .= '<p>' . $this->pi_getLL('short_info') . ' ' . $row['shorttext'] . '</p>';
						$ret .= '</li>';
					}
				}

				if($ret) $ret = '<ul class="contacts">' . $ret . '</ul>';


				return $ret;
				break;

			default:
				return $this->internal['currentRow'][$fN];
				break;
		}
	}
//	/**
//	 * Returns the label for a fieldname from local language array
//	 *
//	 * @param	[type]		$fN: ...
//	 * @return	[type]		...
//	 */
//	function getFieldHeader($fN)	{
//		switch($fN) {
//
//			default:
//				return $this->pi_getLL('listFieldHeader_'.$fN,'['.$fN.']');
//				break;
//		}
//	}
//
//	/**
//	 * Returns a sorting link for a column header
//	 *
//	 * @param	string		$fN: Fieldname
//	 * @return	The fieldlabel wrapped in link that contains sorting vars
//	 */
//	function getFieldHeader_sortLink($fN)	{
//		return $this->pi_linkTP_keepPIvars($this->getFieldHeader($fN),array('sort'=>$fN.':'.($this->internal['descFlag']?0:1)));
//	}
}

?>
