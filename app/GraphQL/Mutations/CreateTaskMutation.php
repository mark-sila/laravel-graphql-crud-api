<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Task;
use Illuminate\Validation\Rule;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createTask'
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'user_id' => [
                'type' => Type::id(),
                'description' => 'The id of associated user to the task.',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the task.',
            ],
            'status' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The status of the task.',
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'name' => ['required'],
            'status' => ['required', 'string']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Task::create($args);
    }
}
