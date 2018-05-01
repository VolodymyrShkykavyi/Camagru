<?php

namespace app\lib;


use app\core\View;

class Pagination
{
	private $pagination = array();
	private $baseURI = '/';
	private $currentPage = 1;

	/**
	 * @var bool set true if requested page is out pages range
	 */
	private $redirect = false;

	public function __construct(Array $options = ['itemsTotal' => 0, 'itemsPerPage' => 5])
	{
		$url = trim(strtok($_SERVER['REQUEST_URI'], '?'),'/');
		if (!preg_match('~^((?:.+)/page/)([0-9]+)$~', $url, $matches)){
			$options['currPage'] = 1;
			$this->baseURI = '/' . $url . '/page/';
		}
		else{
			$options['currPage'] = $matches[2];
			$this->baseURI = '/' . $matches[1];
		}
		if (!is_numeric($options['itemsTotal']) || !is_numeric($options['itemsPerPage']) ||
			$options['itemsTotal'] < 1 || $options['itemsPerPage'] < 1 ||
			$options['itemsTotal'] <= $options['itemsPerPage']){
			return;
		}
		$this->setPagination($options);
	}

	private function addButton($pageNum, $isActive, $isAble = true, $value = '')
	{
		$btn = array();

		if (empty($value)){
			$value = $pageNum;
		}
		$btn['active'] = $isActive;
		$btn['able'] = $isAble;
		if ($pageNum){
			$btn['href'] = $this->baseURI . $pageNum;
		}
		else {
			$btn['href'] = '';
		}
		$btn['value'] = (string)$value;
		return ($btn);
	}

	private function setPagination($options)
	{
		$options['itemsTotal'] = (int)$options['itemsTotal'];
		$options['itemsPerPage'] = (int)$options['itemsPerPage'];
		$numPages = ceil($options['itemsTotal'] / $options['itemsPerPage']);
		if ($options['currPage'] > $numPages){
			$options['currPage'] = $numPages;
			$this->redirect = true;
		}
		$this->currentPage = $options['currPage'];
		$this->pagination[] = $this->addButton(
			($options['currPage'] > 1) ? $options['currPage'] - 1 : 1,
			false,
			($options['currPage'] > 1),
			'Prev'
		);
		$this->pagination[] = $this->addButton(1, ($options['currPage'] == 1),$options['currPage'] != 1 );
		if ($options['currPage'] - 2 > 2){
			$this->pagination[] = $this->addButton(false, false, false, '...');
		}
		for ($i = $options['currPage'] - 2; $i < $numPages; $i++){
			if ($i > 1 && $i <= $options['currPage'] + 2) {
				$this->pagination[] = $this->addButton($i, ($options['currPage'] == $i), $options['currPage'] != $i);
			}
		}
		if ($options['currPage'] + 3 < $numPages){
			$this->pagination[] = $this->addButton(false, false, false, '...');
		}
		$this->pagination[] = $this->addButton($numPages,
			$options['currPage'] >= $numPages,
			$options['currPage'] < $numPages);
		$this->pagination[] = $this->addButton(
			($options['currPage'] < $numPages) ? $options['currPage'] + 1 : $numPages,
			false,
			$options['currPage'] < $numPages,
			'Next'
		);
	}

	public function getPagination()
	{
		return ($this->pagination);
	}

	public function getCurrentPage()
	{
		return ($this->currentPage);
	}

	public function getRedirect()
	{
		return ($this->redirect);
	}
}