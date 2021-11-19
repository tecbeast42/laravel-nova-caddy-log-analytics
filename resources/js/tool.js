import CaddyAnalytics from "./components/CaddyAnalytics.vue";
/* global Nova */

Nova.booting((_Vue, router) => {
  router.addRoutes([
    {
      name: "caddy-analytics",
      path: "/caddy-analytics",
      component: CaddyAnalytics,
    },
  ]);
});
