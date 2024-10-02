#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "Cardd";
const char* password = "studentcard";
// const char* serverName = "http://192.168.54.66/rfid_based_on_canteen_management_system/data.php";
const char* serverName = "http://192.168.54.66/canteen_mis/data.php";

WiFiClient client;

void setup() {
  Serial.begin(9600);
  
  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  Serial.print("Connecting to Wi-Fi");
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  
  Serial.println("\nConnected to Wi-Fi");
}

void loop() {
  if (Serial.available()) {
    String card = Serial.readStringUntil(',');
    String code = Serial.readStringUntil(',');
    String password = Serial.readStringUntil('\n');
    String url = String(serverName) + "?card=" + String(card) + "&code=" + String(code) + "&pass=" + String(password);
    sendHTTPRequest(url);
  }
  delay(1000);
}

void sendHTTPRequest(String url) {
  if(WiFi.status() == WL_CONNECTED){
    
    HTTPClient http;
    
    http.begin(client, url);
    
    int httpResponseCode = http.GET();
    
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(response);
    } else {
      Serial.println("Error in GET request. HTTP Response code: " + String(httpResponseCode));
    }
    
    http.end();
  }
}