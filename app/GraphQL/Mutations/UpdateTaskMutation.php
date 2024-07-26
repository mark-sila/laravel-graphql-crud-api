<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateTask'
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The auto incremented ID of user.',
            ],
            'user_id' => [
                'type' => Type::id(),
                'description' => 'The id of associated user to the task.',
            ],
            'name' => [
                'type' => Type::string(),
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
            'id' => ['required', Rule::exists('tasks', 'id')],
            'status' => ['required', 'string']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $task = Task::find($args['id']);
        
        $task->update($args);

        return $task->refresh();
    }
}
