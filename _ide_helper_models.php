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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @property-read int|null $exercises_count
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty newQuery()
 * @method static \Illuminate\Database\Query\Builder|Difficulty onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Difficulty query()
 * @method static \Illuminate\Database\Query\Builder|Difficulty withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Difficulty withoutTrashed()
 */
	class Difficulty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Equipment
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @property-read int|null $exercises_count
 * @property-read mixed $image_thumbnail_url
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Equipment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment query()
 * @method static \Illuminate\Database\Query\Builder|Equipment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Equipment withoutTrashed()
 */
	class Equipment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Exercise
 *
 * @property-read \App\Models\Difficulty|null $difficulty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Equipment[] $equipment
 * @property-read int|null $equipment_count
 * @property-read mixed $illustration_thumbnail_url
 * @property-read mixed $illustration_url
 * @property-read mixed $image_thumbnail_url
 * @property-read mixed $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Muscle[] $muscles
 * @property-read int|null $muscles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Exercise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exercise newQuery()
 * @method static \Illuminate\Database\Query\Builder|Exercise onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Exercise query()
 * @method static \Illuminate\Database\Query\Builder|Exercise withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Exercise withoutTrashed()
 */
	class Exercise extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Goal
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newQuery()
 * @method static \Illuminate\Database\Query\Builder|Goal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal query()
 * @method static \Illuminate\Database\Query\Builder|Goal withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Goal withoutTrashed()
 */
	class Goal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Muscle
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @property-read int|null $exercises_count
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle newQuery()
 * @method static \Illuminate\Database\Query\Builder|Muscle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Muscle query()
 * @method static \Illuminate\Database\Query\Builder|Muscle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Muscle withoutTrashed()
 */
	class Muscle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PersonalAccessToken
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $tokenable
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken query()
 */
	class PersonalAccessToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Plan
 *
 * @property-read \App\Models\Difficulty|null $difficulty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @property-read int|null $exercises_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goal[] $goals
 * @property-read int|null $goals_count
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Query\Builder|Plan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Query\Builder|Plan withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Plan withoutTrashed()
 */
	class Plan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @property-read int|null $exercises_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Query\Builder|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Query\Builder|Tag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tag withoutTrashed()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Query\Builder|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Query\Builder|Unit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Unit withoutTrashed()
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

