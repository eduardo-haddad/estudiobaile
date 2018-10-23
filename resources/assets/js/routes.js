import VueRouter from 'vue-router';

let routes = [

    {   path: '/pf',
        name: 'pf-index', component: require('./components/pessoaFisica/index'),
        children: [
            {
                path: 'view/:id',
                name: 'pf-view',
                component: require('./components/pessoaFisica/view')
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
            }
        ]
    },
];


export default new VueRouter({
    routes
});