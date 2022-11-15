#### How could you ensure that an email is sent at 8 o'clock users time?
#### How would you achieve that the scheduling is done at the correct time?
While creating the user we will ask user to choose its timezone from the dropdown, or we could automatically get it from the request and store it in its profile. In this way we can filter out the users of the same timezone and know if monday and 8am time is reached or not in their timezone (Please follow next answer to know about the implementation).

#### What kind of frameworks, PAAs etc. would you use for achieving it?
Scheduling of tasks can be achieved using the cron jobs on the server. Which will run specific task at the configured time. e.g sending email or notifications to users.

Laravel provide Task scheduler which allows you to fluently and expressively define your command schedule within your Laravel application itself. When using the scheduler, only a single cron entry is needed on your server.

We will schedule different commands in scheduler according to the users timezones 
```php
foreach($usersTimeZones as $timeZone){
    $schedule->call(
        function () {
            OpenTodoNotification::send($timeZone);
        })->weekly()
        ->mondays()
        ->at('08:00')
        ->timezone($timezone)
        ->runInBackground();
}
```
```$usersTimeZones``` is the array of all the timezones stored in users profiles. They could be 10, 20, 30. We can cache the result of ```$usersTimeZones``` and destroy the cache whenever new timezone is introduced.

According to the above code every minute laravel scheduler will run, and it will check if for any time zone if day is monday and time is ```08:00``` then it will send the notification to all the users which have that timezone in their profile. 
