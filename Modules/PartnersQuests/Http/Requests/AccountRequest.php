<?php
/**
 * Created by PhpStorm.
 * User: alexeyapostolov
 * Date: 25.08.2020
 * Time: 17:23
 */

namespace Modules\PartnersQuests\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnersQuestRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required|unique:addresses,id,' . $this->id,
		];
	}

	public function messages()
	{
		return [
			'name.min' => 'Поле ФИО должно быть больше 2х символов',
		];
	}
}
