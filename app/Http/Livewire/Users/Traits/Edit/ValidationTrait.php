<?php

namespace App\Http\Livewire\Users\Traits\Edit;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

trait ValidationTrait
{
	/**
	 * @param  Validator  $validator
	 * @return void
	 */
	public function displayErrors(Validator $validator)
	{
		if ($validator->errors()->count()) {
			foreach ($validator->errors()->messages() as $key => $message) {
				$this->addError($key, $message[0]);
			}
		}
	}

	/**
	 * @return Validator
	 */
	protected function validateRecord(): Validator
	{
		$transRequired = fn (string $label) => trans('general.errors.required', [
			'attribute' => strtolower(trans('users.entity.' . $label)),
		]);

		$transMin = fn (string $label, int $number) => trans('general.errors.min', [
			'attribute' => strtolower(trans('users.entity.' . $label)),
			'number' => $number,
		]);

		$rules = [
			'user.name' => 'required|min:2',
			'user.email' => ['email', 'max:255', Rule::unique(User::class, 'email')->ignore($this->user['id'])],
		];

		$messages = [
			'user.name.required' => $transRequired('name'),
			'user.name.min' => $transMin('name', 2),
			'user.email.required' => $transRequired('email'),
			'user.email.email' => trans('general.errors.email'),
		];

		$this->resetErrorBag();

		return \Illuminate\Support\Facades\Validator::make(['user' => $this->user], $rules, $messages);
	}
}
