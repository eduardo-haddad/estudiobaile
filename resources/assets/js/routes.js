import VueRouter from 'vue-router';

let routes = [

    {   path: '/pf',
        name: 'pf-index', component: require('./components/pessoaFisica/pf-index'),
        children: [
            {
                path: 'view/:id',
                name: 'pf-view',
                component: require('./components/pessoaFisica/pf-view')
            }
        ]
    },
];


export default new VueRouter({
    routes
});