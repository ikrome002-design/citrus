<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $last_name
 * @property string $first_name
 * @property string|null $phone_number
 * @property string|null $avatar
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property bool $is_active
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property User|null $user
 * @property Collection|AccountType[] $account_types
 * @property Collection|Address[] $addresses
 * @property Admin $admin
 * @property Collection|Admin[] $admins
 * @property Collection|BackOfficePlan[] $back_office_plans
 * @property BackOfficeSubscription $back_office_subscription
 * @property Collection|BannerSetting[] $banner_settings
 * @property Collection|Blog[] $blogs
 * @property Collection|BranchPlan[] $branch_plans
 * @property Collection|BranchSubscription[] $branch_subscriptions
 * @property Collection|Branch[] $branches
 * @property Collection|BusinessType[] $business_types
 * @property Collection|Category[] $categories
 * @property Collection|County[] $counties
 * @property Collection|CourierOrder[] $courier_orders
 * @property Collection|Courier[] $couriers
 * @property InvoiceItem $invoice_item
 * @property Collection|Invoice[] $invoices
 * @property MerchantBalanceTransaction $merchant_balance_transaction
 * @property Collection|Merchant[] $merchants
 * @property Merchant $merchant
 * @property Collection|Message[] $messages
 * @property MpesaTranscationStatus $mpesa_transcation_status
 * @property MpesaTranscation $mpesa_transcation
 * @property MpesaValidation $mpesa_validation
 * @property Collection|OrderItem[] $order_items
 * @property Collection|OrderStatusTimeline[] $order_status_timelines
 * @property Collection|Order[] $orders
 * @property PasswordReset $password_reset
 * @property Collection|Payment[] $payments
 * @property Collection|PermissionRole[] $permission_roles
 * @property Collection|Permission[] $permissions
 * @property Collection|PersonalAccessToken[] $personal_access_tokens
 * @property Collection|ProductAttributePrice[] $product_attribute_prices
 * @property Collection|ProductAttribute[] $product_attributes
 * @property Collection|ProductImage[] $product_images
 * @property Collection|ProductRating[] $product_ratings
 * @property Collection|ProductSubscription[] $product_subscriptions
 * @property Collection|Product[] $products
 * @property Receipt $receipt
 * @property Collection|Refund[] $refunds
 * @property Collection|Review[] $reviews
 * @property Collection|Role[] $roles
 * @property Collection|Session[] $sessions
 * @property Collection|ShippingZone[] $shipping_zones
 * @property Collection|ShoppingCart[] $shopping_carts
 * @property Collection|Sociallink[] $sociallinks
 * @property TarriffDetail $tarriff_detail
 * @property Collection|Tarriff[] $tarriffs
 * @property Collection|TeamPlan[] $team_plans
 * @property TeamSubscription $team_subscription
 * @property Collection|Ticket[] $tickets
 * @property Collection|Town[] $towns
 * @property Collection|User[] $users
 * @property Collection|Wishlist[] $wishlists
 * @property Withdrawal $withdrawal
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRoles,
        SoftDeletes,
        CreatedUpdatedDeletedBy;
    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'bool',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'last_name',
        'first_name',
        'phone_number',
        'avatar',
        'email',
        'email_verified_at',
        'user_is_active',
        'password',
        'remember_token',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function account_types()
    {
        return $this->hasMany(AccountType::class, 'created_by');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'updated_by');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'updated_by');
    }

    public function back_office_plans()
    {
        return $this->hasMany(BackOfficePlan::class, 'updated_by');
    }

    public function back_office_subscription()
    {
        return $this->hasOne(BackOfficeSubscription::class, 'updated_by');
    }

    public function banner_settings()
    {
        return $this->hasMany(BannerSetting::class, 'updated_by');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'updated_by');
    }

    public function branch_plans()
    {
        return $this->hasMany(BranchPlan::class, 'updated_by');
    }

    public function branch_subscriptions()
    {
        return $this->hasMany(BranchSubscription::class, 'updated_by');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'updated_by');
    }

    public function business_types()
    {
        return $this->hasMany(BusinessType::class, 'updated_by');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'updated_by');
    }

    public function counties()
    {
        return $this->hasMany(County::class, 'updated_by');
    }

    public function courier_orders()
    {
        return $this->hasMany(CourierOrder::class, 'updated_by');
    }

    public function couriers()
    {
        return $this->hasMany(Courier::class, 'updated_by');
    }

    public function invoice_item()
    {
        return $this->hasOne(InvoiceItem::class, 'updated_by');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function merchant_balance_transaction()
    {
        return $this->hasOne(MerchantBalanceTransaction::class, 'updated_by');
    }

    public function merchants()
    {
        return $this->hasMany(Merchant::class, 'updated_by');
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'updated_by');
    }

    public function mpesa_transcation_status()
    {
        return $this->hasOne(MpesaTranscationStatus::class, 'updated_by');
    }

    public function mpesa_transcation()
    {
        return $this->hasOne(MpesaTranscation::class, 'updated_by');
    }

    public function mpesa_validation()
    {
        return $this->hasOne(MpesaValidation::class, 'updated_by');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'updated_by');
    }

    public function order_status_timelines()
    {
        return $this->hasMany(OrderStatusTimeline::class, 'updated_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }



    public function payments()
    {
        return $this->hasMany(Payment::class, 'updated_by');
    }

    public function permission_roles()
    {
        return $this->hasMany(PermissionRole::class, 'updated_by');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'updated_by');
    }


    public function product_attribute_prices()
    {
        return $this->hasMany(ProductAttributePrice::class, 'updated_by');
    }

    public function product_attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'updated_by');
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'updated_by');
    }

    public function product_ratings()
    {
        return $this->hasMany(ProductRating::class);
    }

    public function product_subscriptions()
    {
        return $this->hasMany(ProductSubscription::class, 'updated_by');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'updated_by');
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'updated_by');
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class, 'updated_by');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'updated_by');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'updated_by');
    }


    public function shipping_zones()
    {
        return $this->hasMany(ShippingZone::class, 'updated_by');
    }

    public function shopping_carts()
    {
        return $this->hasMany(ShoppingCart::class, 'updated_by');
    }

    public function sociallinks()
    {
        return $this->hasMany(Sociallink::class, 'updated_by');
    }

    public function tarriff_detail()
    {
        return $this->hasOne(TarriffDetail::class, 'deleted_by');
    }

    public function tarriffs()
    {
        return $this->hasMany(Tarriff::class, 'deleted_by');
    }

    public function team_plans()
    {
        return $this->hasMany(TeamPlan::class, 'updated_by');
    }

    public function team_subscription()
    {
        return $this->hasOne(TeamSubscription::class, 'updated_by');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function towns()
    {
        return $this->hasMany(Town::class, 'updated_by');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'updated_by');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function withdrawal()
    {
        return $this->hasOne(Withdrawal::class, 'deleted_by');
    }
}
