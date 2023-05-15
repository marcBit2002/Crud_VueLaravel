import './bootstrap';
import * as bootstrap from 'bootstrap'

import {createApp} from 'vue'
import cicle from './components/Cicle.vue'
import curs from './components/Curs.vue'

createApp(cicle).mount('#cicle')
createApp(curs).mount('#curs')