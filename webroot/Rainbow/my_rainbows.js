Rainbow.extend('terminal', [
    /*{
        'name': 'superuser',
        'pattern': /root/g
    },
    {
        'matches': {
            1: 'package-manager.command',
            2: 'package-manager.subcommand',
            3: 'package-manager.package'
        },
        'pattern': /(apt\-get|yum|aptitude) (install) ([^ ]+)|(pacman) (\-S) ([^ ]+)/g
    },*/
    {
        'matches': {
            1: 'shellpart.user',
            2: 'superuser',
            3: 'shellpart.at',
            4: 'shellpart.host',
            5: 'shellpart.colon',
            6: 'shellpart.directory',
            7: 'shellpart.prompt',
            8: 'superuser',
            9: 'command',
            10:'flag',
            11:'path',
            12:'subcommand'
        },
        'pattern': /(?:([^@]+)|(root))(@)([^:]+)(:)([^#\$]+)([#\$] )?(sudo )?([^ ]*)?(?: (?:([-\+][^ ]*)|((?:[\/\.~]|[a-z]*:\/\/)[^ ]*)|([^ ]+)))*/g
    }
], true);
Rainbow.color();
