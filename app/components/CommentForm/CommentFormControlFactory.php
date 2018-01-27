<?php

namespace App\Components;

use Nette\Database\Context;

class CommentFormControlFactory
{
	/**
	 * @var Context
	 */
	private $database;

	public function __construct(Context $database)
	{

		$this->database = $database;
	}

	public function create(callable $successCallback, $postId)
	{
		return new CommentFormControl($successCallback, $postId, $this->database);
	}
}
