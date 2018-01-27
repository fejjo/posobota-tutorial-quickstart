<?php

namespace App\Presenters;

use Nette\Application\Helpers;
use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{
	public function formatTemplateFiles()
	{
		list(, $presenter) = Helpers::splitName($this->getName());
		$rc = new \ReflectionClass($this);

		return [dirname($rc->getFileName()).'/'.$presenter.'.latte'];
		//return parent::formatTemplateFiles();

	}

}
