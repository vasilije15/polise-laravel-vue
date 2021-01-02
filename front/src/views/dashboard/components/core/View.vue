<template>
  <v-content>
    <router-view />

    <dashboard-core-footer v-if="['Login'].indexOf($route.name)" />
  </v-content>
</template>

<script>
  export default {
    name: 'DashboardCoreView',

    components: {
      DashboardCoreFooter: () => import('./Footer'),
    },
  }
</script>
