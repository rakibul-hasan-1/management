import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import Main from './components/Main.vue';
import App from './App.vue';
app.component('example-component', ExampleComponent);
app.component('app-component', App);

app.mount('#app');
