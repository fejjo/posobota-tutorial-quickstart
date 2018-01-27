<?php

namespace App\Presenters;

use App\Components\CommentFormControl;
use App\Components\CommentFormControlFactory;
use Nette;

class PostShowPresenter extends BasePresenter
{
	/** @var Nette\Database\Context */
	private $database;
	/**
	 * @var CommentFormControlFactory
	 */
	private $commentFormControlFactory;


	public function __construct(Nette\Database\Context $database, CommentFormControlFactory $commentFormControlFactory)
	{
		$this->database = $database;
		$this->commentFormControlFactory = $commentFormControlFactory;
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
		$postId = $this->getParameter('postId');

		return $this->commentFormControlFactory->create($successCallback, $postId, $this->database);
	}

}