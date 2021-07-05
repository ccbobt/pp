<?php


namespace App\Http\Controllers\Api\V1;


use App\Models\Goods;
use App\Models\Shop;
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

    public function getService(Request $request)
    {
        $user = $request->user('api');
        $order = $user->orders()->active()->first();
        $shop = [];
        if ($order) {
            $shop = Goods::query()->with(['category'])->find($order->goods_id);
        }
        $totalTransfer = $user->transfer_enable;
        $usedTransfer = $user->usedTraffic();
        $unusedTraffic = $totalTransfer - $usedTransfer > 0 ? $totalTransfer - $usedTransfer : 0;
        $referral_traffic = flowAutoShow(sysConfig('referral_traffic') * MB);
        $referral_percent = sysConfig('referral_percent');
        $aff_text = trans('user.invite.promotion', ['traffic' => $referral_traffic, 'referral_percent' => $referral_percent * 100]);

        return $this->sendJson([
            'shop_id' => $shop ? $shop->id : '',
            'shop_name' => $shop ? $shop->category->name . ' - ' . $shop->name : '',
            'expired_at' => strtotime($user->expired_at) * 1000,
            'also_traffic' => sprintf('%.2f', flowAutoShow($unusedTraffic)),   // 剩余流量
            'reset_time' => date('Y-m-d', strtotime($user->reset_time)),  // 重置日期
            'speed_limit' => $user->speed_limit,
            'money' => $user->credit,
            'subscriptionUrl' => $user->subUrl(),
            'aff_url' => sysConfig('website_url') . '/?aff=' . $user->invite_code,
            'aff_text' => $aff_text,
        ]);
    }
}
