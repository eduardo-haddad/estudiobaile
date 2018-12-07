/* Vue */

//vue-router
import router from './routes';
//components
import modal from './components/modal_novo_registro';
//event bus
export const eventBus = new Vue();

//main instance
new Vue({
    el: '#app',
    router: router,
    components: {
        modal,
    },
    data: {
        showModal: false
    }
});