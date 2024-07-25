<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Task',
        'model' => Task::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The auto incremented task ID.',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'The associated user to the task.'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the task.'
            ],
            'status' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The status of the task.',
            ]
        ];
    }
}
