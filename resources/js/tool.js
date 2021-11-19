import Tool from "./components/Tool.vue";

Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'caddy-analytics',
      path: '/caddy-analytics',
      component: Tool,
    },
  ])
})
