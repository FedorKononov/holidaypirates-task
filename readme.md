## Requirements

All Laravel requirements plus `short_open_tag = On` in php settings.

## Installation

    git clone https://github.com/kaainet/holidaypirates-task.git

    php artisan migrate --seed

To reset database data to defaults run:

    php artisan migrate:refresh --seed

To run delayed jobs run:

    php artisan queue:listen --queue=holidaypirates.default --env=local

Default users:

    admin@holidaypirates.vg
    admin
    
    moderator@holidaypirates.vg
    moderator

Default groups:

    Admins
    Moderators

Default permissions:

    'App\Http\Controllers\Moderator\Job\JobController@index'
    'App\Http\Controllers\Moderator\Job\JobController@statusShift'

## Highlights

I have implemented user based job dashboard. To post a job you have to be registered. Each user can participate in several groups and have corresponding permissions. Those permissions are checked to access some restricted actions. For example users and jobs moderation. To gain full access use admin account.

I have added theme support based on Laravel view hints (look `AppServiceProvider`). Based on that moderator theme was separated from main user theme (called pirates).

I have added a repository level for some crucial models (User, Job). That was done with thoughts in mind that those models can be heavy loaded  with database records, and in repository level will help to handle those problems. For example by splitting data to several tables or databases.

Controller's actions were named in restful way. Migrations and Seeders were used for schema definition and initial users creation. 

Too keep application responsive to user. Some logic which can slow down server response were implemented in delayed tasks. Which were generated then some event happens. For example mail delivery. In `AppServiceProvider` you can look how events are transformed to delayed jobs. For queues i like to use pheanstalk.

I have tried to use Laravel default solutions (user auth and registration) to keep my code simple but in our projects sometimes we are using custom solutions.

