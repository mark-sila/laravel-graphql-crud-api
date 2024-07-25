<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;

class LogoutUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logoutUser'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        Auth::guard('api')->logout();
        
        return true;
    }
}
