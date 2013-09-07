Tutorials. And stuff.

## Running

We use a library named `predis` for interacting with our database, so to run this, you need to use `pear` to install it:

    pear channel-discover pear.nrk.io
    pear install nrk/predis

You also need to have a Redis server running locally. You can change settings for it in /libs/Tutorials.class.php/line 34,
using predis' Predis\Client constructor.

## Credits

Libraries we use include Predis (https://github.com/nrk/predis/) and Peregrine (https://github.com/botskonet/Peregrine/), as well as Rainbows (http://craig.is/making/rainbows) and php-Markdown-extra (http://michelf.ca/projects/php-markdown/extra/).

The tag-entering system was based off of (<http://pste.me/>)'s tag-entering system, and uses Sliding Tags (http://www.cssflow.com/snippets/sliding-tags).

Otherwise, this software is licensed under the GNU General Public License, more information in License,
by nasonfish <nasonfish@gmail.com>, with ideas and other cool stuff by puffrfish. Feel free to fork and submit bug fixes, or run your own version of this!
