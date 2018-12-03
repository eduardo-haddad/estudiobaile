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