<?php

namespace App\Actions\User;

use App\Actions\User\Base\BaseUserAction;
use App\Actions\User\Transformers\ShowTransformer;
use App\Http\Response\ResponseBuilder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateAction extends BaseUserAction
{
	use ShowTransformer;

	protected string $action = 'update';

	/**
	 * @param  array  $args
	 * @return $this
	 */
	public function execute(array $args = [])
	{
		// exists
		$userBuilder = $this->validateModel($args);

		// transaction
		DB::beginTransaction();
		try {
			$user = tap(
				$userBuilder->first(),
				function (User $user) use ($args) {
					// update user
					$user->fill($args);

					if ($user->isDirty('email')) {
						$user->email_verified_at = null;
					}

					$user->save();
				}
			);

			DB::commit();
			$this->success = true;
		} catch (Exception $e) {
			DB::rollback();
			throw $e;
		}

		$this->data = $this->success
			? $this->transform($user->refresh())
			: [];

		return $this;
	}

	/**
	 * @return ResponseBuilder
	 */
	public function withResponse(): ResponseBuilder
	{
		return ResponseBuilder::make()
			->setSuccess($this->success)
			->setActionMessage($this->action, $this->attribute, $this->success)
			->setData($this->data)
			->setErrors()
			->setStatusOk();
	}
}
