import VueRouter from 'vue-router';

let routes = [
    {   path: '/',
        name: 'home', component: require('./components/home/view'),
    },
    {   path: '/pf',
        name: 'pf-index', component: require('./components/pessoaFisica/index'),
        children: [
            {
                path: 'view/:id',
                name: 'pf-view',
                component: require('./components/pessoaFisica/view')
            },
            {
                path: 'add',
                name: 'pf-create',
                component: require('./components/pessoaFisica/create')
            }
        ]
    },
    {   path: '/pj',
        name: 'pj-index', component: require('./components/pessoaJuridica/index'),
        children: [
            {
                path: 'view/:id',
                name: 'pj-view',
                component: require('./components/pessoaJuridica/view')
            },
            {
                path: 'add',
                name: 'pj-create',
                component: require('./components/pessoaJuridica/create')
            }
        ]
    },
    {   path: '/projetos',
        name: 'projetos-index', component: require('./components/projetos/index'),
        children: [
            {
                path: 'view/:id',
                name: 'projetos-view',
                component: require('./components/projetos/view')
            },
            {
                path: 'add',
                name: 'projetos-create',
                component: require('./components/projetos/create')
            }
        ]
    },
    {   path: '/tags',
        name: 'tags-index', component: require('./components/tags/index'),
        children: [
            {
                path: 'view/:id',
                name: 'tags-view',
                component: require('./components/tags/view')
            }
        ]
    },
    {   path: '/interna',
        name: 'interna-view', component: require('./components/interna/view'),
    },
    {   path: '/usuarios',
        name: 'usuarios-index', component: require('./components/usuarios/index'),
        children: [
            {
                path: 'view/:id',
                name: 'usuarios-view',
                component: require('./components/usuarios/view')
            },
            {
                path: 'add',
                name: 'usuarios-create',
                component: require('./components/usuarios/create')
            }
        ]
    },
];


export default new VueRouter({
    routes
});