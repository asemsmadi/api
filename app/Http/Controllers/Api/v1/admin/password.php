<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use \App\Http\Requests\admin\password\investor;

class password extends Controller
{
    public function investor(investor $request)
    {
        \DB::beginTransaction();
        $user = \App\Investor::findOrFail($request->investor_id)->user;
        $this->sendNotificationNewPasswordForInvestor($user, $request->password);
        $user->update(['password' => bcrypt($request->password)]);
        \DB::commit();
        return response()->json(['success' => 'تم التعديل بنجاح']);
    }

    public function sendNotificationNewPasswordForInvestor(User $user, $pass)
    {
        $user->notify(new \App\Notifications\Investor\password\password($pass));
    }

    public function admin(investor $request)
    {
        \DB::beginTransaction();
        $user = \App\admin::findOrFail($request->admin_id)->user;
        $this->sendNotificationNewPasswordForInvestor($user, $request->password);
        $user->update(['password' => bcrypt($request->password)]);
        \DB::commit();
        return response()->json(['success' => 'تم التعديل بنجاح']);
    }

    public function sendNotificationNewPasswordForAdmin(User $user, $pass)
    {
        $user->notify(new \App\Notifications\admin\password\password($pass));
    }
}
