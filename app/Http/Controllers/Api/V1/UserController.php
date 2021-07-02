<?php


namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @return UserController|\Illuminate\Http\JsonResponse
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user',
        ], [
            'email.required' => trans('auth.email_null'),
            'email.email' => trans('auth.email_legitimate'),
            'email.unique' => trans('auth.email_exist'),
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return $this->sendError($error['email'][0]);
        }

        return $this->sendSuccess('OK');
    }
}
