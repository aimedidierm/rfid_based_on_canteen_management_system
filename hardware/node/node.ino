#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ArduinoJson.h>

const char* ssid = "Balance";
const char* password = "balance1234";

String serverName = "http://192.168.43.83/rfid_based_on_canteen_management_system/data.php";

void setup() {
  Serial.begin(9600); 

  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
 
  Serial.println("Timer set to 5 seconds (timerDelay variable), it will take 5 seconds before publishing the first reading.");
}

void loop() {
  // Send an HTTP POST request depending on timerDelay
  if (Serial.available() > 0) {
    // Check WiFi connection status
    if(WiFi.status() == WL_CONNECTED){
      WiFiClient client;
      HTTPClient http;
      String data = Serial.readStringUntil('\n');
      
      // JSON Parsing with ArduinoJson v6
      DynamicJsonDocument doc(1024);  // Adjust size if necessary
      DeserializationError error = deserializeJson(doc, data);
      
      if (error) {
        Serial.print("deserializeJson() failed: ");
        Serial.println(error.c_str());
        return;
      }

      JsonObject root = doc.as<JsonObject>();
      String card = root["card"];
      String code = root["code"];
      String pass = root["pass"];

      String serverPath = serverName + "?card=" + card + "&code=" + code  + "&pass=" + pass;
      Serial.println(serverPath);
      http.begin(client, serverPath);
  
      // If you need Node-RED/server authentication, insert user and password below
      // http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
        
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      if (httpResponseCode > 0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        Serial.println(payload);
      } else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      // Free resources
      http.end();
    } else {
      Serial.println("WiFi Disconnected");
    }
  }
}
