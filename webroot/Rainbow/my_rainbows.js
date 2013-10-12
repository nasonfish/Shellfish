Rainbow.extend('terminal', [
    {
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
    },
    {
        'matches': {
            1: 'shellpart.user',
            2: 'shellpart.at',
            3: 'shellpart.host',
            4: 'shellpart.colon',
            5: 'shellpart.directory',
            6: 'shellpart.prompt',
            7: 'superuser',
            8: 'command'
        },
        'pattern': /([^@]+)(@)([^:]+)(:)([^#\$]+)([#\$]?)(?: ?(sudo |)([^ ]*)|)/g
    },
    {
        'name': 'flag',
        'pattern': / (\-|\+)[^ ]*/g
    },
    {
        'name': 'path',
        'pattern': / (\/|\.|~|[a-z]*:\/\/.*)[^ ]*/g
    }
], true);
Rainbow.color();
