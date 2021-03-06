<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|BaseModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @method static \Illuminate\Database\Query\Builder|BaseModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BaseModel withoutTrashed()
 */
	class BaseModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Difficulty
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Routine[] $routines
 * @property-read int|null $routines_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Workout[] $workouts
 * @property-read int|null $workouts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty newQuery()
 * @method static \Illuminate\Database\Query\Builder|Difficulty onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty query()
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Difficulty withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Difficulty withoutTrashed()
 */
	class Difficulty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Equipment
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Workout[] $workouts
 * @property-read int|null $workouts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Equipment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Equipment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Equipment withoutTrashed()
 */
	class Equipment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Goal
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Routine[] $routines
 * @property-read int|null $routines_count
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newQuery()
 * @method static \Illuminate\Database\Query\Builder|Goal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Goal withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Goal withoutTrashed()
 */
	class Goal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Muscle
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Workout[] $workouts
 * @property-read int|null $workouts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle newQuery()
 * @method static \Illuminate\Database\Query\Builder|Muscle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Muscle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Muscle withoutTrashed()
 */
	class Muscle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PersonalAccessToken
 *
 * @property string $id
 * @property string $tokenable_type
 * @property string $tokenable_id
 * @property string $name
 * @property string $token
 * @property array|null $abilities
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $tokenable
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereUpdatedAt($value)
 */
	class PersonalAccessToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Plan
 *
 * @property string $id
 * @property string $name
 * @property string $difficulty_id
 * @property string $introduction
 * @property string $description
 * @property string $instructions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Difficulty $difficulty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goal[] $goals
 * @property-read int|null $goals_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Routine[] $routines
 * @property-read int|null $routines_count
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Query\Builder|Plan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDifficultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Plan withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Plan withoutTrashed()
 */
	class Plan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Routine
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Workout[] $workouts
 * @property-read int|null $workouts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Routine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Routine newQuery()
 * @method static \Illuminate\Database\Query\Builder|Routine onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Routine query()
 * @method static \Illuminate\Database\Eloquent\Builder|Routine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Routine whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Routine whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Routine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Routine whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Routine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Routine withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Routine withoutTrashed()
 */
	class Routine extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Routine[] $routines
 * @property-read int|null $routines_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Workout[] $workouts
 * @property-read int|null $workouts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Query\Builder|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Tag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tag withoutTrashed()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Query\Builder|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Unit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Unit withoutTrashed()
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Workout
 *
 * @property string $id
 * @property string|null $workout_id
 * @property string $difficulty_id
 * @property string $cover
 * @property string $illustration
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Difficulty $difficulty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Equipment[] $equipment
 * @property-read int|null $equipment_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Muscle[] $muscles
 * @property-read int|null $muscles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Routine[] $routines
 * @property-read int|null $routines_count
 * @property-read Workout|null $workout
 * @method static \Illuminate\Database\Eloquent\Builder|Workout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Workout newQuery()
 * @method static \Illuminate\Database\Query\Builder|Workout onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Workout query()
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereDifficultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereIllustration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workout whereWorkoutId($value)
 * @method static \Illuminate\Database\Query\Builder|Workout withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Workout withoutTrashed()
 */
	class Workout extends \Eloquent {}
}

