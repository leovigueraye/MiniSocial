# MiniSocial app

## Introduction

A very Simple Social media web application built with laravel. It offers users a seamless and intuitive platform to share their thoughts, opinions, and updates with a global audience in real-time.

<b>User Profiles:</b> Users can create personalized profiles with profile pictures, bios, and other customizable details to showcase their personality and interests.

<b>Posting:</b> It allows users to compose and share posts, enabling them to express themselves concisely and creatively.

<b>Follow and Unfollow:</b> Users can follow other users to stay updated with their posts and activities. Additionally, they can unfollow users at any time to manage their timeline.

<b>Timeline:</b> The application provides users with a dynamic timeline that aggregates posts from users they follow, ensuring they never miss out on important updates from their network.

<b>Likes and Retweets:</b> Users can engage with posts by liking them to show appreciation, fostering interaction and virality within the community.


## Installation

- Clone this repo using any method (https, ssh, gh cli)

- Set the configuration file using the command 
``` cp .env.example .env ```

- Install all required packages via composer. ``` composer install ```

- Set up Database configuration inside .env file.

- Run the migration 

```
php artisan migrate 
```

- Install all dependencies via `npm` and Compile all assets based on your deployment environment. 

#### Npm
```bash
#Install all dependencies
npm install

#Development
npm dev

#Production
npm prod
```

- Create symbolic link 
```
php artisan storage:link
```

- Start the local server using the command
```
php artisan serve
```
## Preview

![image](Screenshot%20(142).png)

![image](Screenshot%20(143).png)

![image](Screenshot%20(168).png)