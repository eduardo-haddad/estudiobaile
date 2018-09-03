import VueRouter from 'vue-router';

let routes = [
    //PessoaFisica Index
    {   path: '/pf',
        name: 'ajax-pf-index', components: {lista: require('./components/pessoaFisica/pf-index')},

        children: [
            {   name: 'ajax-pf-view',
                path: ':id',
            },
        ]



    },

    //PessoaFisica View
    // {   path: '/ajax/pf/view/:id',
    //     name: 'ajax-pf-view', components: {conteudo: require('./components/pessoaFisica/pf-view')} }

];


export default new VueRouter({
    routes
});