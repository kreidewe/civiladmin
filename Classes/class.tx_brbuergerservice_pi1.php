<?php

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use TYPO3\CMS\Core\Domain\Repository\PageRepository;



class tx_civiladmin_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{
	var $prefixId	  = 'tx_civiladmin_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_civiladmin_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey		= 'civiladmin';	// The extension key.
	var $pi_checkCHash = true;
	var $viewType   = 1; // List view

	/**
	 * Main method of your PlugIn
	 *
	 * @param	string		$content: The content of the PlugIn
	 * @param	array		$conf: The PlugIn Configuration
	 * @return   string The content that should be displayed on the website
	 */
	function main($content, $conf)
	{
		$this->pi_initPIflexForm();	// Init FlexForm configuration for plugin
		$this->init();
		// Display Type ( calendar, listview, listinterval, nextevents )
		$this->viewType = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'viewType', 'sDEF');

		switch($this->viewType)	{
			// list view
			case 1:
				if (strstr($this->cObj->currentRecord,'tt_content'))
				{
					if ($this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'pidList', 'sDEF')) {
						$conf['pidList'] = (int) $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'pidList', 'sDEF');
					} else {
						$conf['pidList']= 'this';
					}
					$conf['recursive'] = $this->cObj->data['recursive'];
				}
				return $this->pi_wrapInBaseClass($this->listView($content, $conf));
			break;

			// single view
			case 2:

				list($t) = explode(':',$this->cObj->currentRecord);
				$this->internal['currentTable']=$t;
				$this->internal['currentRow']=$this->cObj->data;
				return $this->pi_wrapInBaseClass($this->singleView($content, $conf));

			break;

		}
	}

	protected function init()
	{
		$this->pi_loadLL('EXT:civiladmin/Resources/Private/Language/Plugin/locallang_pi1.xlf'); // Loading language-labels
	}



	/** pi_list_makelist
	 *
	 */
	function pi_list_makelist($statement,$tableParams='')
	{
		$r='';
		$this->internal['currentRow']='';

		$c=0;

		while($this->internal['currentRow'] = $statement->fetch())
		{
			$r.=$this->pi_list_row($c);
			$c++;
		}

		return '<div class="tx-civiladmin-pi1-listrow">'.$r.'</div>';
	}



	/**
	 * Shows a list of database entries
	 *
	 * @param	string		$content: content of the PlugIn
	 * @param	array		$conf: PlugIn Configuration
	 * @return   string HTML list of table entries
	 */
	function listView($content, $conf)
	{

		$this->conf = $conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();		// Loading the LOCAL_LANG values

		$lConf = $this->conf['listView.'];	// Local settings for the listView function

		if($this->piVars['sword'] != '') {
			unset($this->piVars['lexi']);
		}


		if (is_numeric($this->piVars['showUid']))	{	// If a single element should be displayed:
			$this->internal['currentTable'] = 'tx_civiladmin_dienstleistung';
			$this->internal['currentRow'] = $this->pi_getRecord('tx_civiladmin_dienstleistung',$this->piVars['showUid']);

			$content = $this->singleView($content, $conf);
			return $content;
		}
		else
		{

			//if (!isset($this->piVars['pointer']))	$this->piVars['pointer']=0;
			unset($this->piVars['mode']);

			// Initializing the query parameters:
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['results_at_a_time'],0,30,30);		// Number of results to show in a listing.
			$this->internal['maxPages']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['maxPages'],0,1000,10);		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='title,synonyms,keywords,description';
			$this->internal['orderByList']='title';

			$offset = 0;

			if($this->piVars['pointer'] > 0)
				// Pager Offset
				$offset = ($this->piVars['pointer']*$this->internal['results_at_a_time'])+1;

			/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
			$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_civiladmin_dienstleistung');

			$count = $queryBuilder
				->count('uid')
				->from('tx_civiladmin_dienstleistung')
				->where(
					$queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter($this->conf['pidList'], \PDO::PARAM_INT))
				);

			if ($this->piVars['lexi'] != '') {
				$count
					->andWhere(
						$queryBuilder->expr()->orX(
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.title', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($this->piVars['lexi']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($this->piVars['lexi']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter(',' . $queryBuilder->escapeLikeWildcards($this->piVars['lexi']) . '%'))
						)
					);

			}

			if ($this->piVars['sword'] != '') {
				$count
					->andWhere(
						$queryBuilder->expr()->orX(
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.title', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter(',%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.keywords', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.keywords', $queryBuilder->createNamedParameter(',%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.description', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%'))
						)
					);
			}

			// Get number of records:
			$count = $count->execute()->fetchColumn(0);
			$this->internal['res_count'] = $count;

			$queryBuilder
				->select('uid','pid','title','synonyms','keywords','description')
				->from('tx_civiladmin_dienstleistung')
				->where(
					$queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter($this->conf['pidList'], \PDO::PARAM_INT))
				);

			if ($this->piVars['lexi'] != '') {
				$queryBuilder
					->andWhere(
						$queryBuilder->expr()->orX(
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.title', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($this->piVars['lexi']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($this->piVars['lexi']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter(',' . $queryBuilder->escapeLikeWildcards($this->piVars['lexi']) . '%'))
						)
					);

			}

			if ($this->piVars['sword'] != '') {
				$queryBuilder
					->andWhere(
						$queryBuilder->expr()->orX(
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.title', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.synonyms', $queryBuilder->createNamedParameter(',%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.keywords', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.keywords', $queryBuilder->createNamedParameter(',%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%')),
							$queryBuilder->expr()->like('tx_civiladmin_dienstleistung.description', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($this->piVars['sword']) . '%'))
						)
					);
			}

			$queryBuilder
				->setMaxResults($this->internal['results_at_a_time'])
				->setFirstResult($offset)
				->groupBy('title')
				->orderBy('title', 'asc');

			// Make listing query, pass query to SQL database:
			$res= $queryBuilder->execute();

			$this->internal['currentTable'] = 'tx_civiladmin_dienstleistung';


			$fullTable = '';

			// Adds the search box:
			$fullTable .= $this->pi_list_searchBox();

			// draw a-z browser
			$fullTable .= $this->getAzBrowser();

			// Adds the whole list table

			if($res->rowCount()>0)
			{
				$fullTable.=$this->pi_list_makelist($res);
			}
			else
			{
				$fullTable.='<p class="no-entry">Derzeit gibt es keine Einträge unter diesem Buchstaben/Suchkriterium.</p>';
			}

			//pager
			$wrapper=
			[
				'browseBoxWrap' => '<nav class="pages">|</nav>',
				'activeLinkWrap' => '<span class="x">|',
				'showResultsWrap' => '<div class="hide">|</div>',
				'browseLinksWrap' => '|',
				'inactiveLinkWrap' => '|',
				'inactiveLinkWrap' => '|',
			];
			$pages=$this->pi_list_browseresults(0,'',$wrapper);
			$pages=strtr($pages,
			[
				'<span class="x"><a href' => '<a class="x" aria-current="page" href',
				'?no_cache=1' => '',
			]);
			$fullTable.=$pages;

			// Returns the content from the plugin.
			return $fullTable;
		}
	}


	function pi_list_searchBox($tableParams='')
	{

		$currentPage = $this->pi_getPageLink((int)$GLOBALS['TSFE']->id);
		// Search box design:
		$sTables='
			<div'.$this->pi_classParam('searchbox').'>
				<form action="'.$currentPage.'" method="post">
					<div class="form-row"><input class="form-control" type="text" title="'.$this->pi_getLL('search_placeholder').'" placeholder="'.$this->pi_getLL('search_placeholder').'" name="'.$this->prefixId.'[sword]" value="'.htmlspecialchars($this->piVars['sword']).'"'.$this->pi_classParam('searchbox-sword').'></div>
					<div class="submit">
						<button type="submit">'.$this->pi_getLL('search').'</button>
						<a href="'.$currentPage.'" class="button button_reset">'. $this->pi_getLL('remove_term') .'</a>
						<input type="hidden" name="no_cache" value="1">
						<input type="hidden" name="'.$this->prefixId.'[pointer]" value="">
					</div>
				</form>
			</div>';

		return $sTables;
	}

	/**
	 * Display a single item from the database
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	HTML of a single database entry
	 */
	function singleView($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();


		if($this->internal['currentRow']['synonyms'])
			$syn = ' ('.$this->internal['currentRow']['synonyms'].')';

		$content ='<div'.$this->pi_classParam('singleView').'>
			<h2>'.$this->internal['currentRow']['title'].$syn.'</h2>';


		if($this->getFieldContent('description')) {
			$content.= '<h3>'. $this->pi_getLL('description') . '</h3>'  .$this->getFieldContent('description').'</p>';
		}

		if($this->getFieldContent('documents')) {
			$content.= '<h3>'. $this->pi_getLL('documents') . '</h3>'  .$this->getFieldContent('documents').'</p>';
		}

		if($this->getFieldContent('costs')) {
			$content.= '<h3>'. $this->pi_getLL('costs') . '</h3>'  .nl2br($this->getFieldContent('costs')).'</p>';
		}

		if($this->getFieldContent('laws')) {
			$content.= '<h3>'. $this->pi_getLL('laws') . '</h3>' .nl2br($this->getFieldContent('laws')).'</p>';
		}

		if($this->getFieldContent('forms')) {
			$content.='<h3>'. $this->pi_getLL('forms') . '</h3>' . $this->getFieldContent('forms').'</p>';
		}

		if($this->internal['currentRow']['contacts'] > 0) {
			$content.='<div class="csc-header csc-header-n1"><h3 class="csc-firstHeader">' . $this->pi_getLL('contacts') . '</h3></div>'.$this->getFieldContent('contacts');
		}

		if($this->internal['currentRow']['unit'] != '') {

			$content.='<div class="csc-header csc-header-n1"><h3 class="csc-firstHeader">'.  $this->pi_getLL('administrative_unit') . '</h3></div>'.$this->getFieldContent('unit');
		}

		if($content) {
			$content = '<div'.$this->pi_classParam('colView').'>'.$content.'</div>';
		}

		unset($this->piVars["showUid"]);

		//$content.='<p>&laquo; '.$this->pi_list_linkSingle('Zurück zur Listenansicht',0,FALSE,$this->piVars).'</p></div>';


		$content.='<p class="backToListView">'.$this->pi_linkTP_keepPIvars($this->pi_getLL('back_to_list'),$this->piVars,1,0,$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'backPage', 'sDEF')).'</p></div>';


		return $content;
	}

	/**
	 * draws AZ-Browser
	 *
	 * @return	string  The html Content
	 */

	function getAzBrowser()
	{
		$r='';
		$letters=['a','b', 'c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','w','z'];

		foreach($letters as $letter)
		{
			$link=$this->pi_linkTP(strtoupper($letter),['tx_civiladmin_pi1' => ['lexi' => $letter]],1);

			if(!empty($this->piVars['lexi']) && $this->piVars['lexi']==$letter)
			{
				$link=str_replace('a href','a class="x" aria-current="page" href',$link);
			}
			$r.=$link;
		}

		return '<nav class="pages">'.$r.'</nav>';
	}


	/**
	 * Display a single item from the database in column
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	HTML of a single database entry
	 */
	function colView($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		$this->internal['currentRow'] = $this->pi_getRecord('tx_civiladmin_dienstleistung',$this->piVars['showUid']);

		if($this->internal['currentRow']['contacts'] > 0) {
			$content.='<div class="csc-header csc-header-n1"><h3 class="csc-firstHeader">Ansprechpartner</h3></div>

			'.$this->getFieldContent('contacts');
		}

		if($this->internal['currentRow']['unit'] != '') {

			$content.='<div class="csc-header csc-header-n1"><h3 class="csc-firstHeader">Verwaltungseinheit</h3></div>

			'.$this->getFieldContent('unit');
		}

		if($content) {
			$content = '<div'.$this->pi_classParam('colView').'>'.$content.'</div>';
		}
		return $content;
	}




	/**
	 * Returns a single table row for list view
	 *
	 * @param	integer		$c: Counter for odd / even behavior
	 * @return   string HTML table row
	 */
	function pi_list_row($c)
	{
		if($this->internal['currentRow']['synonyms'])
		{
			$syn = ' ('.$this->internal['currentRow']['synonyms'].')';
		}

		return '<p>'.$this->getFieldContent('title').'<span class="link-text-annex">'.$syn.'</span></p>';

	}
	/**
	 * Returns a table row with column names of the table
	 *
	 * @return   string A HTML table row
	 */
	function pi_list_header()	{
		//No Need of a Header-Row
		return '';
	}
	/**
	 * Returns the content of a given field
	 *
	 * @param	string		$fN: name of table field
	 * @return   string Value of the field
	 */
	function getFieldContent($fN)
	{
		$ret = '';
		$pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(PageRepository::class);

		switch($fN)
		{
			case 'uid':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
			break;

			case "title":
				// This will wrap the title in a link.
				return $this->pi_list_linkSingle($this->internal['currentRow']['title'],$this->internal['currentRow']['uid'],1,$this->piVars);
			break;

			case "description":
			case "forms":
			case "costs":
			case "documents":
			case "laws":
				// This will wrap the rte code
				return $this->pi_RTEcssText( $this->internal['currentRow'][$fN]);
			break;



			case "unit":
				if($this->internal['currentRow'][$fN]) {

					/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
					$queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_civiladmin_dienstleistung');
					$queryBuilder
						->select('uid','name')
						->from('tx_civiladmin_contact')
						->where(
							$queryBuilder->expr()->in('uid', $queryBuilder->createNamedParameter($this->internal['currentRow'][$fN], \PDO::PARAM_INT))
						);
					$res = $queryBuilder->execute();

					while ($row = $res->fetch()) {
						$ret .= '<li>' . $this->pi_linkTP($row['name'], array('tx_civiladmin_pi2' => array('showUid' => $row['uid']) ), TRUE, 4652) . '</li>';
					}
				}

				if($ret) $ret = '<ul class="unit">' . $ret . '</ul>';

				return $ret;
				break;

			case "contacts":

				//$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
				if($this->internal['currentRow'][$fN] > 0) {

					$where =  ' AND tx_civiladmin_dienstleistung.uid = ' . $this->internal['currentRow']['uid'] .
						$pageRepository->enableFields('tx_civiladmin_dienstleistung') .
						$pageRepository->enableFields('tx_civiladmin_contacts');

					$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query('tx_civiladmin_contacts.*',
						'tx_civiladmin_dienstleistung',
						'tx_civiladmin_dienstleistung_contacts_mm',
						'tx_civiladmin_contacts',
						$where,
						'tx_civiladmin_contacts.uid',
						'tx_civiladmin_dienstleistung_contacts_mm.sorting ASC'
					);


					while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
						$ret .= '<li style="margin-bottom:1em">';

						$ret .= '<strong>' . $row['prenom'] . ' ' . $row['name'] . '</strong><br />';

						if($row['phone'])
							$ret .= 'Tel.: ' . $row['phone'] . '<br />';

						if($row['fax'])
							$ret .= 'Fax: ' . $row['fax'] . '<br />';

						if($row['email'])
						$ret .= 'E-Mail: ' . $this->cObj->typolink($row['email'], array('parameter' => $row['email'],'ATagParams'=>'class="mail"')).'<br />';

						if($row['shorttext'])
							$ret .= '<p class="shorttext">'.$row['shorttext'].'</p>';


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
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/civiladmin/pi1/class.tx_civiladmin_pi1.php'])
{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/civiladmin/pi1/class.tx_civiladmin_pi1.php']);
}

?>
