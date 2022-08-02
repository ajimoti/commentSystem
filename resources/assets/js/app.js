
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueToastr from "vue-toastr";

window.Vue = require('vue');

axios.defaults.withCredentials = true;

Vue.use(VueToastr, {
    /* OverWrite Plugin Options if you need */
});
  
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('post', require('./components/Post.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('comment', require('./components/Comment.vue'));
Vue.component('add-comment', require('./components/AddComment.vue'));
Vue.component('comment-spinner', require('./components/CommentSpinner.vue'));
Vue.component('reply', require('./components/Reply.vue'));
Vue.component('sub-reply', require('./components/SubReply.vue'));

const app = new Vue({
    el: '#app'
});
