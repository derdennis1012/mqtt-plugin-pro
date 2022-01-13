var elements = document.querySelectorAll("[data-pk-atts]");
var fElement = null;
for (var i = 0; i < elements.length; i++) {
  var element = elements[i];
  var elmt = JSON.parse(element.getAttribute("data-pk-atts"));

  fElement = elmt;
}
var data = { siteURLG: fElement.site_url };

export const globalMixin = {
  data() {
    return {
      ...data,
      intervals:[{lables:"Once every 30 seconds" , code: "30sec"}, {lables:"Once every minute" , code: "1min"}, {lables:"Once every 5 minutes" , code: "5min"}, {lables:"Once every 15 minutes" , code: "15min"}, {lables:"Once every 30 minutes" , code: "30min"}, {lables:"Once every hour" , code: "1h"}, {lables:"Once every 3 hours" , code: "3h"}, {lables:"Once every 5 hours" , code: "5h"}, {lables:"Once every day" , code: "1d"}, {lables:"Once every 3 days" , code: "3d"}, {lables:"Once every week" , code: "1w"}]
    };
  },
  methods: {
    getSiteURLG() {
      return this.siteURLG;
    },
    async sendPostReqG(path, body = {}) {
      var self = this;
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      };
      var res = await fetch(self.getSiteURLG() + path, requestOptions);
      if (res.status == 200) {
        return res.json();
      }
      return false;
    },
    async sendGetReqG(path) {},
  },
};
