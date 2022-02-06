<!-- Edited by Lena Scheit, Dennis Bölling  -->
<template>
  <div>
    <div class="swagger" id="swagger"></div>
  </div>
</template>
<script>
import "../../assets/swagger/swagger-ui-bundle";
import "../../assets/swagger/swagger-ui-standalone-preset";
import SwaggerUI from "swagger-ui";
import "swagger-ui/dist/swagger-ui.css";

export default {
  data: () => ({
    swaggerSpec: {
      swagger: "2.0",
      info: {
        description: "This is the documentation for the MQTT Plugin Pro API",
        version: "1.1.0",
        title: "MQTT Plugin Pro API",
        termsOfService: "http://swagger.io/terms/",
        contact: {
          email: "derdennis1012@gmail.com",
        },
        license: {
          name: "free software",
          url: "https://www.fsf.org/",
        },
      },
      host: "localhost:8888",
      basePath: "/wp/wp-json/mqtt-plugin-pro/v1",
      tags: [
        {
          name: "Settings",
          description: "Manage the Plugin settings",
        },
        {
          name: "MQTT Data",
          description: "Manage the MQTT Data",
        },
      ],
      schemes: ["https", "http"],
      paths: {
        "/settings": {
          get: {
            tags: ["Settings"],
            summary: "Get the current settings",
            description: "",
            operationId: "getSettings",
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
                schema: {
                  $ref: "#/definitions/SettingsData",
                },
              },
              500: {
                description: "Invalid input",
              },
            },
          },
          post: {
            tags: ["Settings"],
            summary: "Update the settings",
            description: "",
            operationId: "updatePet",
            consumes: ["application/json"],
            produces: ["application/json"],
            parameters: [
              {
                in: "body",
                name: "body",
                description: "Settings Object needs to be stored",
                required: true,
                schema: {
                  $ref: "#/definitions/SettingsData",
                },
              },
            ],
            responses: {
              200: {
                description: "successful operation",
                schema: {
                  $ref: "#/definitions/SettingsData",
                },
              },
              400: {
                description: "Invalid ID supplied",
              },
              404: {
                description: "Pet not found",
              },
              405: {
                description: "Validation exception",
              },
            },
          },
        },
        "/settings/get/intervall": {
          get: {
            tags: ["Settings"],
            summary: "Get the intervall",
            description: "",
            operationId: "getSettingsIntervall",
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Invalid input",
              },
            },
          },
        },
        "/settings/activate": {
          get: {
            tags: ["Settings"],
            summary: "Activate the Service",
            description: "",
            operationId: "activateSettings",
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Settings are not correct",
              },
            },
          },
        },
        "/settings/disable": {
          get: {
            tags: ["Settings"],
            summary: "Disable the Service",
            description: "",
            operationId: "disableeSettings",
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Error",
              },
            },
          },
        },
        "/mqtt-functions/get/timestamp": {
          get: {
            tags: ["MQTT Data"],
            summary: "Get Server Time",
            description: "",
            operationId: "getTimeStamp",
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Error",
              },
            },
          },
        },
        "/mqtt-functions/get/all": {
          get: {
            tags: ["MQTT Data"],
            summary: "Get all MQTT Data",
            description: "",
            operationId: "getAllData",
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Error",
              },
            },
          },
        },
        "/mqtt-functions/get": {
          post: {
            tags: ["MQTT Data"],
            summary: "Get Values by Topic",
            description: "",
            operationId: "getByTopic",
            parameters: [
              {
                in: "body",
                name: "filter",
                description: "The topic filter",
                schema: {
                  type: "object",
                  required: ["topic"],
                  properties: {
                    topic: {
                      type: "string",
                      default: "ferries",
                    },
                  },
                },
              },
            ],
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Error",
              },
            },
          },
        },
        "/mqtt-functions/get-avg": {
          post: {
            tags: ["MQTT Data"],
            summary: "Get AVG value by Topic",
            description: "",
            operationId: "getByTopicAVG",
            parameters: [
              {
                in: "body",
                name: "filter",
                description: "The topic filter",
                schema: {
                  type: "object",
                  required: ["topic"],
                  properties: {
                    topic: {
                      type: "string",
                      default: "ferries",
                    },
                  },
                },
              },
            ],
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Error",
              },
            },
          },
        },
        "/mqtt-functions/get-latest": {
          post: {
            tags: ["MQTT Data"],
            summary: "Get Latest Value by topic",
            description: "",
            operationId: "getByTopicLatest",
            parameters: [
              {
                in: "body",
                name: "filter",
                description: "The topic filter",
                schema: {
                  type: "object",
                  required: ["topic"],
                  properties: {
                    topic: {
                      type: "string",
                      default: "ferries",
                    },
                  },
                },
              },
            ],
            produces: ["application/json"],
            responses: {
              200: {
                description: "successful operation",
              },
              500: {
                description: "Error",
              },
            },
          },
        },
      },
      definitions: {
        SettingsData: {
          type: "object",
          properties: {
            mqtt_pro_mqtt_url: {
              type: "string",
              example: "141.28.73.33",
            },
            mqtt_pro_mqtt_port: {
              type: "string",
              example: "80",
            },
            mqtt_pro_mqtt_client_id: {
              type: "string",
              example: "don_oatmeal4132",
            },
            mqtt_pro_requires_auth: {
              type: "boolean",
              example: true,
            },
            mqtt_pro_mqtt_user: {
              type: "string",
              example: "admin",
            },
            mqtt_pro_mqtt_password: {
              type: "string",
              example: "Word_press1021",
            },
            mqtt_pro_mqtt_topics: {
              type: "string",
              example: "test,ferries",
            },
            mqtt_pro_mqtt_interval: {
              type: "string",
              example: "5min",
            },
            mqtt_pro_has_ttl: {
              type: "boolean",
              example: true,
            },
            mqtt_pro_mqtt_ttl: {
              type: "string",
              example: "365",
            },
            mqtt_pro_active: {
              type: "boolean",
              example: true,
            },
          },
        },
      },
    },
  }),
  props: {},
  methods: {},
  beforeMount() {
    this.swaggerSpec.host = this.getSiteURLG()
      .replace("http://", "")
      .split("/")[0];
    this.swaggerSpec.basePath = "/";
    if (this.getSiteURLG().replace("http://", "").split("/")[1]) {
      this.swaggerSpec.basePath +=
        this.getSiteURLG().replace("http://", "").split("/")[1] + "/";
    }
    this.swaggerSpec.basePath += "wp-json/mqtt-plugin-pro/v1";
  },
  mounted() {
    SwaggerUI({
      spec: this.swaggerSpec,
      dom_id: "#swagger",
    });
  },
};
</script>
<style>
@import "../../assets/swagger/swagger-ui.css";
</style>