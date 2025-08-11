<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jewelry_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    /**
     * Quan hệ với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với Jewelry
     */
    public function jewelry()
    {
        return $this->belongsTo(Jewelry::class);
    }

    /**
     * Tính tổng tiền cho item này
     */
    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    /**
     * Scope để lấy giỏ hàng của user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public static function addItem($userId, $jewelryId, $quantity = 1)
    {
        $jewelry = Jewelry::find($jewelryId);
        if (!$jewelry) {
            return false;
        }

        $existingItem = static::where('user_id', $userId)
            ->where('jewelry_id', $jewelryId)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
            return $existingItem;
        } else {
            return static::create([
                'user_id' => $userId,
                'jewelry_id' => $jewelryId,
                'quantity' => $quantity,
                'price' => $jewelry->price
            ]);
        }
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public static function updateQuantity($userId, $jewelryId, $quantity)
    {
        $cartItem = static::where('user_id', $userId)
            ->where('jewelry_id', $jewelryId)
            ->first();

        if ($cartItem) {
            if ($quantity <= 0) {
                $cartItem->delete();
                return null;
            } else {
                $cartItem->quantity = $quantity;
                $cartItem->save();
                return $cartItem;
            }
        }

        return false;
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public static function removeItem($userId, $jewelryId)
    {
        return static::where('user_id', $userId)
            ->where('jewelry_id', $jewelryId)
            ->delete();
    }

    /**
     * Lấy tất cả sản phẩm trong giỏ hàng của user
     */
    public static function getUserCart($userId)
    {
        return static::with('jewelry.files')
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * Tính tổng tiền giỏ hàng
     */
    public static function getCartTotal($userId)
    {
        return static::where('user_id', $userId)
            ->get()
            ->sum(function ($item) {
                return $item->quantity * $item->price;
            });
    }

    /**
     * Đếm số lượng sản phẩm trong giỏ hàng
     */
    public static function getCartCount($userId)
    {
        return static::where('user_id', $userId)
            ->sum('quantity');
    }

    /**
     * Xóa toàn bộ giỏ hàng của user
     */
    public static function clearCart($userId)
    {
        return static::where('user_id', $userId)->delete();
    }
}
