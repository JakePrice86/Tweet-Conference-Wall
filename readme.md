## Tweet-Conference-Wall

As all existing solutions for a twitter wall with speakers and sponsors on it was pretty expensive (£200+) I decided to hack together my own in a hour or so. This system was used for #hackference 2015 in all 3 main track rooms and worked perfectly!

## What does it use?

### Search Side
- [twitter-api-php](http://github.com/j7mbo/twitter-api-php) (Used for all twitter search API calls)
- [fllat file DB](https://github.com/wylst/fllat) (Used for stopping duplicate tweets from showing)
- [Pusher API](https://github.com/pusher/pusher-http-php) (Used for pushing data to the server - not used in final version)

### Client Side
- [Bootstrap](https://github.com/twbs/bootstrap) (grids etc!)
- [jQuery](https://github.com/jquery/jquery) (Cross browser ajax calls FTW)

## Installation

1. Clone onto server that has PHP enabled. Should work on PHP 5.3.3 and above
2. In search.php is spaces to enter your Twitter API keys and your search term (it'll have #hackference in it to start!)
3. Edit the track's you want to display at the bottom of the file. There are pretty self-explanatory :)
4. Open the index.html file - and it *should* all be working!

## Editing

You'll want to change the styling in the index.html file - its pretty obvious what needs to change - but make sure you:

- Change the sponsors at the bottom. At the moment there is a slider which changes those.
- Make sure to edit the tracks in the search.php file. If you want more or less tracks, just remove the arrays.

## Tests

LOL tests! The only checking tool that was built, was calling the search.php with a variable with a time, so you could check what would be displayed at a set time. To do this, you do search.php?time=5:00 pm - which would display the system as it was 5pm! Handy eh!!

## Contributors

As mentioned, this is a hacky hack - but it worked perfectly in our conference. Feel free to pull apart etc. Pull requests loved though if your feeling creative :) I am happy to help you customise - you can contact me via twitter - [@jakelprice](https://twitter.com/jakelprice)

## License

Each system used has there own licenses - *please* consult these before doing anything silly!