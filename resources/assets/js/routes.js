import VueRouter from 'vue-router';

let routes = [

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
];


export default new VueRouter({
    routes
});