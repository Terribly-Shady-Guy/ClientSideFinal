import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../views/HomeView.vue')
  },
  {
    path: '/signup',
    name: 'signup',
    component: () => import('../views/SignUpView.vue')
  },
  {
    path: '/photodisplay',
    name: 'photodisplay',
    component: () => import('../views/PhotoDisplayView.vue')
  },
  {
    path: '/insertimage',
    name: 'insertimage',
    component: () => import('../views/InsertImageView.vue')
  },
  {
    path: '/updateimage',
    name: 'updateimage',
    component: () => import('../views/UpdateImageView.vue')
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router
