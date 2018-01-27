<?php

namespace App\Presenters;

use App\Components\CommentFormControl;
use Nette;

class PostShowPresenter extends BasePresenter
{
	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
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
		$successCallback = function () {
			$this->flashMessage('Thank you for your comment', 'success');
			$this->redirect('this');

		};
		return new CommentFormControl($successCallback, $this->getParameter('postId'), $this->database);
	}

}