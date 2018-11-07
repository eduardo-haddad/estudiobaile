/* Vue */

//vue-router
import router from './routes';
//components
import pfIndex from './components/pessoaFisica/index';
//event bus
export const eventBus = new Vue();
//main instance
new Vue({
    el: '#app',
    router: router,
    components: {
        pfIndex
    },
});

// jQuery

$(document).ready(function(){

    // $('.add_contato .botao_inner').on('click', function(){
    //
    // });
    // $('[data-toggle="popover"]').popover();

});