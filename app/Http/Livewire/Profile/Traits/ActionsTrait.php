<?php

namespace App\Http\Livewire\Profile\Traits;

use App\Actions\User;
use App\Actions\UserEmail\GenerateVerificationEmailAction;

trait ActionsTrait
{
	/**
	 * Method to update the user.
	 * @return void
	 */
	public function updateUser(): void
	{
		$message = '';

		$validator = $this->validateRecord();

//		$this->setTabsErrors($validator);
//
		$this->displayErrors($validator);

		if ($validator->fails()) {
			return;
		}

		$action = trigger(User\UpdateAction::class, $this->user)->withResponse();

		if ($action->success) {
			$message = $action->message;
		}

		if ($action->errors) {
			foreach ($action->errors as $key => $error) {
				$message = $error[0];
			}
		}

		// notification
		$this->notifyAction($action->success, $message);
	}

	/**
	 * Method to send the user email verification mail.
	 * @return void
	 */
	public function sendEmailVerification(): void
	{
		$message = '';

		$action = trigger(
			GenerateVerificationEmailAction::class,
			['id' => $this->user['id']]
		)->withResponse();

		if ($action->success) {
			$message = $action->message;
		}

		if ($action->errors) {
			foreach ($action->errors as $key => $error) {
				$message = $error[0];
			}
		}

		// notification
		$this->notifyAction($action->success, $message);
	}
}
