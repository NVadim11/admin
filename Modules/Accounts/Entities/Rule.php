<?php
use Illuminate\Validation\Rule;

Validator::make($data, [
	'email' => [
		'required',
		Rule::unique('users')->ignore($user->id),
	],
]);