<?php

namespace App\Presenters;

use Nette;
use Nette\Application\Helpers;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class PostShowPresenter extends Presenter
{
	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function formatTemplateFiles()
	{
		list(, $presenter) = Helpers::splitName($this->getName());
		return [__DIR__.'/'.$presenter.'.latte'];
		//return parent::formatTemplateFiles();

	}

	public function renderDefault($postId)
	{
		$post = $this->database->table('posts')->get($postId);
		if (!$post) {
			$this->error('Post not found');
		}

		$this->template->post = $post;
		$this->template->comments = $post->related('comment')->order('created_at');
	}

	protected function createComponentCommentForm()
	{
		$form = new Form;
		$form->addText('name', 'Your name:')
			->setRequired();

		$form->addEmail('email', 'Email:');

		$form->addTextArea('content', 'Comment:')
			->setRequired();

		$form->addSubmit('send', 'Publish comment');
		$form->onSuccess[] = [$this, 'commentFormSucceeded'];

		return $form;
	}


	public function commentFormSucceeded($form, $values)
	{
		$this->database->table('comments')->insert([
			'post_id' => $this->getParameter('postId'),
			'name' => $values->name,
			'email' => $values->email,
			'content' => $values->content,
		]);

		$this->flashMessage('Thank you for your comment', 'success');
		$this->redirect('this');
	}

}