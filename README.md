Tutorials. And stuff.

## Running

We use a library named `predis` for interacting with our database, so to run this, you need to use `pear` to install it:

    pear channel-discover pear.nrk.io
    pear install nrk/predis

You also need to have a Redis server running locally. You can change settings for it in /libs/Tutorials.class.php/line 34,
using predis' Predis\Client constructor.

## Credits

Libraries we use include:
 - Predis (https://github.com/nrk/predis/)
 - Peregrine (https://github.com/botskonet/Peregrine/)
 - Rainbows (http://craig.is/making/rainbows)
 - php-Markdown-extra (http://michelf.ca/projects/php-markdown/extra/).
 - Sliding Tags (http://www.cssflow.com/snippets/sliding-tags).
 - Font Awesome by Dave Gandy (http://fontawesome.io).
 - Download Buttons (http://www.cssflow.com/snippets/download-buttons)

Otherwise, this software is licensed under the GNU General Public License, more information in License,
by nasonfish <nasonfish@nasonfish.com>, with ideas and other cool stuff by puffrfish. Feel free to fork and submit bug fixes, or run your own version of this!
