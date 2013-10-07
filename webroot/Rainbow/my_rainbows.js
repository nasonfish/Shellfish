Rainbow.extend('terminal', [
    {
        'matches': {
            1: 'shellpart.user',
            2: 'shellpart.at',
            3: 'shellpart.host',
            4: 'shellpart.colon',
            5: 'shellpart.directory',
            6: 'shellpart.prompt',
            7: 'command',
            8: 'subcommand'
        },
        'pattern': /([^@]+)(@)([^:]+)(:)([^#\$]+)([#\$]? *)([^ ]*) *(.*$)/g
    }
]);
Rainbow.color();