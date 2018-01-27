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

	public function __construct($postId, Context $database)
	{
		$this->database = $database;
		$this->postId = $postId;
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

		$this->flashMessage('Thank you for your comment', 'success');
		$this->redirect('this');
	}

}
