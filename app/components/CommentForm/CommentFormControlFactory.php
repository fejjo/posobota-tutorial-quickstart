<?php

namespace App\Components;

interface CommentFormControlFactory
{
	public function create(callable $successCallback, $postId): CommentFormControl;
}
