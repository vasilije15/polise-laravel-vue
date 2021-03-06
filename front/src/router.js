import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      component: () => import('@/views/dashboard/Index'),
      children: [
        // Dashboard
        {
          name: 'Početna',
          path: '',
          component: () => import('@/views/dashboard/Dashboard'),
        },
        // Pages
/*        {
          name: 'User Profile',
          path: 'pages/user',
          component: () => import('@/views/dashboard/pages/UserProfile'),
        },
        {
          name: 'Notifications',
          path: 'components/notifications',
          component: () => import('@/views/dashboard/component/Notifications'),
        },
        {
          name: 'Icons',
          path: 'components/icons',
          component: () => import('@/views/dashboard/component/Icons'),
        },
        {
          name: 'Typography',
          path: 'components/typography',
          component: () => import('@/views/dashboard/component/Typography'),
        },
        // Tables
        {
          name: 'Regular Tables',
          path: 'tables/regular-tables',
          component: () => import('@/views/dashboard/tables/RegularTables'),
        },
        // Maps
        {
          name: 'Google Maps',
          path: 'maps/google-maps',
          component: () => import('@/views/dashboard/maps/GoogleMaps'),
        }, */
        // Polise
        {
          name: 'Polise',
          path: 'polise',
          component: () => import('@/views/dashboard/pages/Polise'),
        },
        {
          name: 'Vozila',
          path: 'vozila',
          component: () => import('@/views/dashboard/pages/Vozila'),
        },
        {
          name: 'Ugovornici',
          path: 'ugovornici',
          component: () => import('@/views/dashboard/pages/Ugovornici'),
        },
        {
          name: 'Osiguranici',
          path: 'osiguranici',
          component: () => import('@/views/dashboard/pages/Osiguranici'),
        },
        {
          name: 'Login',
          path: 'login',
          component: () => import('@/views/dashboard/pages/Login'),
        },
      ],
    },
  ],
})
