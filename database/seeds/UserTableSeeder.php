<?php

use Illuminate\Database\Seeder;
use App\Repositories\UserRepository;
use App\Models\User\Group;

class UserTableSeeder extends Seeder
{
    /**
     * Constructor
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->users->newQuery()->delete();
        (new Group)->newQuery()->delete();

        $admins_group = Group::create([
            'title' => 'Admins',
            'code' => 'admins',
        ]);

        $moderators_group = Group::create([
            'title' => 'Moderators',
            'code' => 'moderators',
        ]);

        $admin = $this->users->create([
            'name' => 'admin',
            'email' => 'admin@holidaypirates.vg',
            'password' => bcrypt('admin'),
        ]);

        $moderator = $this->users->create([
            'name' => 'moderator',
            'email' => 'moderator@holidaypirates.vg',
            'password' => bcrypt('moderator'),
        ]);

        $admin->groups()->sync([$admins_group->id]);
        $moderator->groups()->sync([$moderators_group->id]);
    }
}
