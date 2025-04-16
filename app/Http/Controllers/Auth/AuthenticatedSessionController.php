<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $carts = session()->get('carts', []);

        foreach ($carts as $ingredientUuid => $item) {
            $cartItem = \App\Models\CartItem::firstOrNew([
                'user_uuid' => $user->uuid,
                'ingredient_uuid' => $ingredientUuid,
                'type' => 'cart',
            ]);
    
            $cartItem->quantity = $item['quantity'];
            $cartItem->price = $item['price'];
            $cartItem->save();
        }


        // "後で買う" アイテムを移行
        $savedForLater = session()->get('saveForLater', []);
        if (!empty($savedForLater)) {
            foreach ($savedForLater as $ingredientUuid => $item) {
                $savedItem = \App\Models\CartItem::firstOrNew([
                    'user_uuid' => $user->uuid,
                    'ingredient_uuid' => $ingredientUuid,
                    'type' => 'saveForLater',
                ]);
    
                // 数量を追加（既に存在する場合）
                $savedItem->quantity += $item['quantity'];
                $savedItem->price = $item['price']; // 必要に応じて価格も更新
                $savedItem->save();
            }

            // セッションから「後で買う」情報を削除
            session()->forget('saveForLater');
        }
    
        $cartItems = \App\Models\CartItem::where('user_uuid', $user->uuid)
            ->where('type', 'cart')
            ->with('ingredient')
            ->get();
    
        $newCarts = [];
        foreach ($cartItems as $item) {
            $newCarts[$item->ingredient_uuid] = [
                'name' => $item->ingredient->name,
                'price' => $item->ingredient->price,
                'quantity' => $item->quantity,
                'image_path' => $item->ingredient->image_path,
            ];
        }
    
        session()->put('carts', $newCarts);

        $redirectTo = $request->input('redirect_to');

        \Log::info('リクエスト内容:', $request->all());
        \Log::info('redirect_to の値: ' . $redirectTo);

        if ($redirectTo) {
            session(['url.intended' => $redirectTo]);
        }

        return redirect()->intended(route('top'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        \Log::info('Current session ID: ' . session()->getId());

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        \Log::info('Session ID after logout: ' . session()->getId());

        return redirect('/');
    }
}