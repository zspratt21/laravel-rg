# Resume Generator
### This laravel based web application aims to allow the user to generate a custom html resume, which is then rendered as a pdf document via a working instance of pdf reactor.
## Requirements
Standard requirements for a [Laravel project](https://laravel.com/docs/10.x#your-first-laravel-project) plus:
* Nodejs & NPM
* A working instance of [PDFreactor](https://www.pdfreactor.com/), either [local](https://www.pdfreactor.com/download/) or cloud based.
## Getting Started
### Cloning the repository
```
git clone https://github.com/zspratt21/laravel-rg
```
#### Or
Your preferred method for setting up a new git based project (E.G "get from version control" In your IDE of choice)
### Install composer dependencies
```
composer install
```
### Install npm dependencies
```
npm install
```
### Run migrations
```
php artisan migrate
```
### Build assets
```
npm run build
```
### Generate an app key
```
php artisan key:generate
```
### Setup an instance of PDFreactor
You can setup a local installation by downloading the relevant package for your system [here](https://www.pdfreactor.com/download/)
The default url that will be used by the application is local host on 9423 so no further configuration is needed if you are using a local instance (otherwise you will need to configure the host and port per the documentation [here](https://github.com/ssgglobal/PDFreactor)).
### Create needed data
In order to generate a resume, you will need to add in a few necessary datapoints. When adding images it is highly recommended to use SVGs where possible (with the exception of your profile and cover photo)
#### Populating your resume profile information
After creating your account, navigate to the profile page and fill in the details.
#### Create entities
Navigate to Create -> Entity to create some entities (E.G school or company), which you will then refer to when creating your experiences.
#### Create experiences
Using the entities you created earlier, you can now navigate to Create -> Experience to create your experience and list any milestones relevant to it (E.G a big project you worked on at x company)
#### Create skills & links
After adding some experiences you will want to add in some skills. These can be any skill you have worked on or are working on, such as a programming language (E.G PHP).
You can then link the skills to your profile by viewing the list of skills at View -> Skills and clicking 'link' in the actions column.
#### Create social media platforms & links
Similar to skills, you may also want to add in your social media profile(s).
Begin by navigating to Create -> Social Media Platform and fill in the details to create a representation of a social media profile you want to include (E.G Linkedin).
You can then link your profile as a url by navigating to Create -> Social Media Link, typing in your profile url and selecting the correct platform in the select dropdown.
### Generating the resume
Finally, you can now generate your new HTML based resume by navigating to View -> Resume 😎

You can also make further edits to the generated pdf in any app that can edit pdf files if you wish (E.G Adobe Acrobat).
