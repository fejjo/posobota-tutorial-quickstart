<?php

namespace App\Components;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Database\Context;

class CommentFormControl extends Control
{
	/**
	 * @var Context
	 */
	private $database;
	private $postId;
	private $successCallback;

	public function __construct($successCallback, $postId, Context $database)
	{
		$this->database = $database;
		$this->postId = $postId;
		$this->successCallback = $successCallback;
	}

	public function render()
	{
		$this['form']->render();
	}

	protected function createComponentForm()
	{
		$form = new Form;
		$form->addText('name', 'Your name:')
			->setRequired();

		$form->addEmail('email', 'Email:');

		$form->addTextArea('content', 'Comment:')
			->setRequired();

		$form->addSubmit('send', 'Publish comment');
		$form->onSuccess[] = [$this, 'processForm'];

		return $form;
	}


	public function processForm($form, $values)
	{
		$this->database->table('comments')->insert([
			'post_id' => $this->postId,
			'name' => $values->name,
			'email' => $values->email,
			'content' => $values->content,
		]);

		($this->successCallback)($this);
	}

}
