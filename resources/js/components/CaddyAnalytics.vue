<template>
  <div class="flex flex-col">
    <div class="w-full flex flex-col">
      <div>
        <heading level="2">Views</heading>
        <card class="mb-8">
          <div class="views-chart"></div>
        </card>
      </div>
      <div>
        <heading level="2">Status Codes</heading>
        <card>
          <div class="status-code-chart"></div>
        </card>
      </div>
    </div>
    <!-- <pre> -->
    <!--   {{ logs[0] }} -->
    <!-- </pre> -->
  </div>
</template>

<script>
import chartist from "chartist";

/* global axios */
export default {
  metaInfo: () => ({
    title: "CaddyAnalytics",
  }),
  data: () => ({
    logs: [],
  }),
  async mounted() {
    this.logs = (await axios.get("/nova-vendor/caddy-analytics/log")).data;
    chartist.Bar(".status-code-chart", this.statusCodes);
    chartist.Bar(".views-chart", this.views);
  },
  methods: {
    extractLogs(callback) {
      const prepared = this.logs.reduce(callback, {});
      return {
        labels: Object.keys(prepared),
        series: [Object.values(prepared)],
      };
    },
  },
  computed: {
    views() {
      return this.extractLogs((accumulator, log) => {
        if (
          (log.status === 200 &&
            !log.resp_headers["Content-Type"]?.[0]?.includes("text/html")) ||
          log.request.uri.includes("/healthcheck") ||
          log.request.uri.includes("/nova") ||
          log.request.uri.includes("/admin")
        ) {
          return accumulator;
        }
        accumulator[log.request.uri] = (accumulator[log.request.uri] ?? 0) + 1;
        return accumulator;
      });
    },
    statusCodes() {
      return this.extractLogs((accumulator, log) => {
        accumulator[log.status] = (accumulator[log.status] ?? 0) + 1;
        return accumulator;
      });
    },
  },
};
</script>

<style>
.ct-series-a .ct-bar {
  stroke-width: 20px;
}
</style>
