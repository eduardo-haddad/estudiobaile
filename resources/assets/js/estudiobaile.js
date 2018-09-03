/* jQuery */
$(document).ready(function(){
    //
});

/* Vue */

//vue-router
import router from './routes';

//components
import pfIndex from './components/pessoaFisica/pf-index';

//main instance
new Vue({
    el: '#app',
    router: router,
    components: {
        pfIndex
    },
});