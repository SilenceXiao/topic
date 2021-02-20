<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     * 过滤用户提交的字段，存在时才会更新
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *  隐藏属性
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function statuses(){
        return $this->hasMany(Status::class,'user_id');
    }

    //获取粉丝
    public function followers(){
        return $this->belongsToMany(User::class, 'followers','user_id','follower_id')
            ->withTimestamps();
    }

    //获取关注人列表
    public function followings(){
        return $this->belongsToMany(User::class, 'followers','follower_id','user_id')
            ->withTimestamps();
    }

    //加关注
    public function follow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    //取关注
    public function unfollow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);

    }

    //获取关注人列表
    public function isFollowing($user_id){
        $this->followings->contains($user_id);
    }



    //生产用户头像链接
    public function gravatar($size = '100')
    {   
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }


    public static function boot()
    {
        parent::boot();

        static::creating(function ($user){
            $user->activation_token = Str::random(10);
        });
    }

    public function feed()
    {
        return $this->statuses()
            ->orderBy('created_at','desc');
    }
}
