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
      timeIntervals:[
        {label:"Once every 30 seconds" , key: "30sec"}, {label:"Once every minute" , key: "1min"}, {label:"Once every 5 minutes" , key: "5min"}, {label:"Once every 15 minutes" , key: "15min"}, {label:"Once every 30 minutes" , key: "30min"}, {label:"Once every hour" , key: "1h"}, {label:"Once every 3 hours" , key: "3h"}, {label:"Once every 5 hours" , key: "5h"}, {label:"Once every day" , key: "1d"}, {label:"Once every 3 days" , key: "3d"}, {label:"Once every week" , key: "1w"}]
    };
  },
  methods: {
    getSiteURLG() {
      return this.siteURLG;
    },
    getIntervalLabel(key){
      var ret = null;
      for(const i in this.timeIntervals){
        if(this.timeIntervals[i].key == key){
          ret =  this.timeIntervals[i].label
        }
      }
      return ret;
    },
    async sendPostReqG(path, body = {}) {
      var self = this;
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      };
      var res = await fetch(self.getSiteURLG() + path, requestOptions);
      var ret = false;
      if (res.status == 200) {
        try{
          ret = res.json();
        }catch(e){
          ret = false;
        }
      }
      console.log(ret)
      return ret;
    },
    async sendGetReqG(path) {
      var self = this;
      const requestOptions = {
        method: "GET",
        headers: { "Content-Type": "application/json" }
      };
      var res = await fetch(self.getSiteURLG() + path, requestOptions);
      if (res.status == 200) {
        try{
          console.log(res.body.json())
        }catch(e){
          console.log(e)
        }
        return res;
      }
      return false;
    },
  },
};
